<?php

namespace App\Http\Controllers;

use App\Models\LeaveRecord;
use App\Models\School;
use App\Models\Position;
use App\Models\LeaveType;
use App\Models\Remark;
use App\Models\Forwarded;
use App\Models\Employee;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveRecordController extends Controller
{
    /**
     * Get all leave records.
     */
    public function index(Request $request)
    {
        $query = LeaveRecord::leftJoin('users', 'leave_records.user_id', '=', 'users.id')
            ->select('leave_records.*', 'users.first_name')
            ->orderBy('leave_records.batch_id', 'asc')
            ->orderBy('leave_records.forwarded', 'asc')
            ->orderBy('leave_records.created_at', 'asc');

        // Isolation Logic:
        // 1. The "Registry" modal (on the Form page) is personal work - only see your own records.
        // 2. The "History" page (on leave-records page) shows everyone's work, but grouped separately.
        if ($request->has('view') && $request->view === 'registry') {
            $query->where('is_processed', false);
            if (auth()->check()) {
                $query->where('user_id', auth()->id());
            }
        } else {
            // History pages should only show processed records
            $query->where('is_processed', true);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        if ($request->has('incharge') && $request->incharge && $request->incharge !== 'all') {
            $inchargeName = $request->incharge;
            $targetUser = User::whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$inchargeName])->first();
            
            $query->where(function($q) use ($inchargeName, $targetUser) {
                // Direct column match
                $q->where('leave_records.incharge', $inchargeName)
                  ->orWhere('leave_records.incharge', 'like', "%$inchargeName%");
                
                // If we found a system user, search by their ID and other known identifiers
                if ($targetUser) {
                    $q->orWhere('leave_records.user_id', $targetUser->id)
                      ->orWhere('leave_records.incharge', $targetUser->first_name)
                      ->orWhere('leave_records.incharge', $targetUser->email);
                }
            });
        }

        if ($request->has('assigned') && $request->assigned && $request->assigned !== 'all') {
            $assigned = $request->assigned;
            $query->where('leave_records.assigned', $assigned);
        }

        $records = $query->get();

    if ($request->wantsJson() || $request->ajax()) {
        return response()->json($records);
    }

    $role = auth()->user()->role ?? 'user';
    $view = ($role === 'admin') ? 'admin.leave-records' : 'user.leave-records';
    return view($view);
}

    /**
     * Mark records as processed/cleared from registry.
     */
    public function bulkProcess(Request $request)
{
    $ids = $request->input('ids');
    
    // Generate a unique batch_id for this specific group of processed records
    $maxBatch = LeaveRecord::max('batch_id') ?? 1;
    $newBatchId = $maxBatch + 1;
    
    $updateData = [
        'is_processed' => true,
        'batch_id' => $newBatchId,
        'date_of_action' => now()->format('Y-m-d'),
        'processed_at' => now()
    ];
    
    if ($ids === 'all') {
        LeaveRecord::where('is_processed', false)->update($updateData);
    } elseif (is_array($ids)) {
        LeaveRecord::whereIn('id', $ids)->update($updateData);
    }

    $message = 'Records processed and assigned to batch #' . $newBatchId;
    
    // Log action
    AuditLog::logAction('Bulk processed ' . (is_array($ids) ? count($ids) : 'all') . ' records', null, 'New Batch ID: ' . $newBatchId);

    return response()->json([
        'success' => true,
        'message' => $message,
        'next_batch' => $newBatchId + 1
    ]);
}

    /**
     * Get a specific leave record.
     */
    public function show($id)
    {
        $leaveRecord = LeaveRecord::findOrFail($id);
        $user = auth()->user();

        if ($user->role !== 'admin' && $leaveRecord->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($leaveRecord);
    }

    /**
     * Store a new leave record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'forwarded' => 'nullable|string|max:255',

            'position' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'type_of_leave' => 'required|string|max:255',
            'inclusive_dates' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'date_of_action' => 'nullable|date',
            'deduction_remarks' => 'nullable|string|max:255',
            'incharge' => 'nullable|string|max:255',
        ]);

        if (isset($validated['forwarded'])) {
            $validated['forwarded'] = trim(explode(' - ', $validated['forwarded'])[0]);
        }

        // Check if adding to a specific batch (from leave-records page Add button)
        $targetBatch = $request->input('target_batch');
        $isFromLeaveRecords = $request->input('source') === 'leave-records';
        
        if ($targetBatch) {
            $validated['batch_id'] = (int) $targetBatch;
        } else {
            // Assign the current batch_id
            $currentBatch = LeaveRecord::where('is_processed', false)->max('batch_id') 
                ?? (LeaveRecord::max('batch_id') ?? 0) + 1;
            $validated['batch_id'] = $currentBatch;
        }
        
        // Tag the record with the current user's ID and region
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
            $validated['assigned'] = auth()->user()->assigned ?? 'national';
        }
        
        // If from leave-records page, mark as already processed
    if ($isFromLeaveRecords) {
        $validated['is_processed'] = true;
        $validated['processed_at'] = now();
    }

        // Automatically set incharge to the current user's name
        $validated['incharge'] = auth()->user()->name;

        $record = LeaveRecord::create($validated);

        // Also save to employees table
        Employee::create($validated);

        // Sync with directory tables
        $this->syncDirectories($record);

        // Log action
        AuditLog::logAction('Created leave record', $record, 'Employee: ' . $record->name . ', Type: ' . $record->type_of_leave);

        return response()->json([
            'success' => true,
            'message' => 'Leave record saved successfully!',
            'record' => $record,
        ], 201);
    }

    /**
     * Sync data with directory tables.
     */
    private function syncDirectories($record)
    {
        // Sync School
        if ($record->school) {
            $type = 'Other';
            $lower = strtolower($record->school);
            if (str_contains($lower, 'high school') || str_contains($lower, 'secondary') || preg_match('/\bhs\b/', $lower)) {
                $type = 'High School';
            } elseif (str_contains($lower, 'integrated')) {
                $type = 'Integrated';
            } elseif (str_contains($lower, 'elementary') || preg_match('/\bes\b/', $lower)) {
                $type = 'Elementary';
            }
            School::updateOrCreate(
                ['name' => $record->school],
                [
                    'type' => $type,
                    'employee_name' => $record->name,
                    'position' => $record->position,
                    'type_of_leave' => $record->type_of_leave,
                    'inclusive_dates' => $record->inclusive_dates,
                    'remarks' => $record->remarks,
                    'date_of_action' => $record->date_of_action,
                    'deduction_remarks' => $record->deduction_remarks,
                    'assigned' => $record->assigned,
                ]
            );
        }

        // Sync Position
        if ($record->position) {
            Position::updateOrCreate(
                ['name' => $record->position],
                [
                    'employee_name' => $record->name,
                    'school' => $record->school,
                    'type_of_leave' => $record->type_of_leave,
                    'inclusive_dates' => $record->inclusive_dates,
                    'remarks' => $record->remarks,
                    'date_of_action' => $record->date_of_action,
                    'deduction_remarks' => $record->deduction_remarks,
                    'assigned' => $record->assigned,
                ]
            );
        }

        // Sync Leave Type
        if ($record->type_of_leave) {
            $types = explode(', ', $record->type_of_leave);
            foreach ($types as $type) {
                LeaveType::updateOrCreate(
                    ['name' => trim($type)],
                    [
                        'employee_name' => $record->name,
                        'position' => $record->position,
                        'school' => $record->school,
                        'inclusive_dates' => $record->inclusive_dates,
                        'remarks' => $record->remarks,
                        'date_of_action' => $record->date_of_action,
                        'deduction_remarks' => $record->deduction_remarks,
                        'assigned' => $record->assigned,
                    ]
                );
            }
        }

        // Sync Remark
        if ($record->remarks) {
            Remark::updateOrCreate(
                ['name' => $record->remarks],
                [
                    'employee_name' => $record->name,
                    'position' => $record->position,
                    'school' => $record->school,
                    'type_of_leave' => $record->type_of_leave,
                    'inclusive_dates' => $record->inclusive_dates,
                    'date_of_action' => $record->date_of_action,
                    'deduction_remarks' => $record->deduction_remarks,
                    'assigned' => $record->assigned,
                ]
            );
        }

        // Sync Forwarded
        if ($record->forwarded) {
            // Strip date suffix if present (e.g. "SDO - 03-02-2026" -> "SDO")
            $baseName = explode(' - ', $record->forwarded)[0];
            Forwarded::updateOrCreate(
                ['name' => $baseName],
                [
                    'employee_name' => $record->name,
                    'position' => $record->position,
                    'school' => $record->school,
                    'type_of_leave' => $record->type_of_leave,
                    'inclusive_dates' => $record->inclusive_dates,
                    'date_of_action' => $record->date_of_action,
                    'deduction_remarks' => $record->deduction_remarks,
                ]
            );
        }
    }

    /**
     * Get unique values for combobox dropdowns.
     */
    public function dropdownData()
    {
        // Dropdown suggestions on the FORM should show all previous data to help with entry
        // Use Employee table instead of LeaveRecord for names to ensure all personnel are selectable
        $names = Employee::distinct()->pluck('name')->filter()->values();
        $positions = Position::orderBy('name')->pluck('name');
        
        $schoolsQuery = School::orderBy('name')->get();
        $schoolGroups = [];
        foreach ($schoolsQuery as $school) {
            $type = $school->type ?? 'Other';
            $schoolGroups[$type][] = $school->name;
        }

        $leaveTypes = LeaveType::orderBy('name')->pluck('name');
        $remarks = Remark::orderBy('name')->pluck('name');
        
        $forwardeds = Forwarded::orderBy('name')->pluck('name')
            ->map(function($name) {
                return trim(explode(' - ', $name)[0]);
            })
            ->unique()
            ->values();

        // The employee map should also show all data to enable auto-fill for everyone
        // Use Employee table to ensure auto-fill works for all entered personnel
        $employeeMap = Employee::orderBy('created_at', 'desc')
            ->get(['name', 'forwarded', 'position', 'school'])
            ->unique('name')
            ->mapWithKeys(function ($record) {
                return [$record->name => [
                    'forwarded' => $record->forwarded ? trim(explode(' - ', $record->forwarded)[0]) : null,
                    'position' => $record->position,
                    'school' => $record->school
                ]];
            });

        // For incharges, show both users in the system and anyone who has handled a record
        $userNames = User::all()->pluck('name')->values();
        $recordIncharges = LeaveRecord::whereNotNull('incharge')->distinct()->pluck('incharge')->filter()->values();
        $incharges = $userNames->merge($recordIncharges)->unique()->values();

        return response()->json([
            'names' => $names,
            'positions' => $positions,
            'schools' => $schoolGroups,
            'leave_types' => $leaveTypes,
            'remarks' => $remarks,
            'forwardeds' => $forwardeds,
            'employee_map' => $employeeMap,
            'incharges' => $incharges,
        ]);
    }

    /**
     * Get records for a specific school.
     */
    public function getBySchool(Request $request)
    {
        $school = $request->input('school');
        $assigned = $request->query('assigned');
        $query = LeaveRecord::leftJoin('users', function($join) {
                $join->on('leave_records.user_id', '=', 'users.id')
                     ->orOn('leave_records.incharge', '=', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"));
            })
            ->select('leave_records.*', 'users.first_name')
            ->where('leave_records.school', $school);

        if ($assigned) {
            $query->where('leave_records.assigned', $assigned);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        $records = $query->orderBy('created_at', 'asc')->get();
        return response()->json($records);
    }
    
    /**
     * Get list of all schools with stats.
     */
    public function getSchools(Request $request) 
    {
        $assigned = $request->query('assigned');
        $query = LeaveRecord::select('school', DB::raw('count(*) as leave_count'))
                  ->whereNotNull('school')
                  ->where('school', '!=', '');
        
        if ($assigned && $assigned !== 'all') {
            $query->where('assigned', $assigned);
        }
        
        $schools = $query->groupBy('school')->orderBy('school')->get();
        return response()->json($schools);
    }

    /**
     * Get total record count.
     */
    public function count()
    {
        // The count on the sidebar/form usually refers to the personal registry
        $query = LeaveRecord::where('is_processed', false);
        
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        }

        return response()->json([
            'count' => $query->count(),
        ]);
    }

    /**
     * Get list of all positions with stats.
     */
    public function getPositions(Request $request)
    {
        $assigned = $request->query('assigned');
        $query = LeaveRecord::select('position', DB::raw('count(*) as leave_count'))
                  ->whereNotNull('position')
                  ->where('position', '!=', '');
                  
        if ($assigned && $assigned !== 'all') {
            $query->where('assigned', $assigned);
        }
        
        $positions = $query->groupBy('position')->orderBy('position')->get();
        return response()->json($positions);
    }

    /**
     * Get records for a specific position.
     */
    public function getByPosition(Request $request)
    {
        $position = $request->input('position');
        $assigned = $request->query('assigned');
        $query = LeaveRecord::leftJoin('users', function($join) {
                $join->on('leave_records.user_id', '=', 'users.id')
                     ->orOn('leave_records.incharge', '=', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"));
            })
            ->select('leave_records.*', 'users.first_name')
            ->where('leave_records.position', $position);

        if ($assigned) {
            $query->where('leave_records.assigned', $assigned);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        $records = $query->orderBy('created_at', 'asc')->get();
        return response()->json($records);
    }

    /**
     * Get list of all leave types with stats.
     */
    public function getLeaveTypes(Request $request)
    {
        $assigned = $request->query('assigned');
        $query = LeaveRecord::select('type_of_leave', DB::raw('count(*) as leave_count'))
                  ->whereNotNull('type_of_leave')
                  ->where('type_of_leave', '!=', '');
        
        if ($assigned && $assigned !== 'all') {
            $query->where('assigned', $assigned);
        }
        
        $types = $query->groupBy('type_of_leave')->orderBy('type_of_leave')->get();
        return response()->json($types);
    }

    /**
     * Get records for a specific leave type.
     */
    public function getByLeaveType(Request $request)
    {
        $type = $request->input('type');
        $assigned = $request->query('assigned');
        // Optimized regex: match if it is the whole string or separated by commas with optional spaces
        $regex = '(^|,)[[:space:]]*' . preg_quote($type) . '[[:space:]]*([,]|$)';
        $query = LeaveRecord::leftJoin('users', function($join) {
                $join->on('leave_records.user_id', '=', 'users.id')
                     ->orOn('leave_records.incharge', '=', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"));
            })
            ->select('leave_records.*', 'users.first_name')
            ->where('leave_records.type_of_leave', 'LIKE', '%' . $type . '%');

        if ($assigned) {
            $query->where('leave_records.assigned', $assigned);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        $records = $query->orderBy('created_at', 'asc')->get();
        return response()->json($records);
    }

    /**
     * Get list of all remarks with stats.
     */
    public function getRemarksList(Request $request)
    {
        $assigned = $request->query('assigned');
        $query = LeaveRecord::select('remarks', DB::raw('count(*) as leave_count'))
                  ->whereNotNull('remarks')
                  ->where('remarks', '!=', '');
        
        if ($assigned && $assigned !== 'all') {
            $query->where('assigned', $assigned);
        }
        
        $rawRecords = $query->groupBy('remarks')->get();
        
        $resultsGrouped = [];
        foreach ($rawRecords as $r) {
            $name = $r->remarks;
            $key = $name;
            $count = $r->leave_count;
            
            // Normalize common variations of "Without Pay"
            $lower = strtolower($name);
            if ($lower === 'w/o' || $lower === 'without pay' || $lower === 'w/o pay') {
                $key = 'Without Pay';
            }
            
            if (isset($resultsGrouped[$key])) {
                $resultsGrouped[$key]['leave_count'] += $count;
            } else {
                $resultsGrouped[$key] = [
                    'remarks' => $key,
                    'leave_count' => $count
                ];
            }
        }
        
        $final = array_values($resultsGrouped);
        usort($final, function($a, $b) { return strcmp($a['remarks'], $b['remarks']); });
        
        return response()->json($final);
    }

    /**
     * Get records for a specific remark.
     */
    public function getByRemark(Request $request)
    {
        $remark = $request->input('remark');
        $assigned = $request->query('assigned');
        $query = LeaveRecord::leftJoin('users', function($join) {
                $join->on('leave_records.user_id', '=', 'users.id')
                     ->orOn('leave_records.incharge', '=', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"));
            })
            ->select('leave_records.*', 'users.first_name');
            
        if (strtolower($remark) === 'without pay') {
            $query->whereIn('leave_records.remarks', ['Without Pay', 'W/O', 'w/o', 'WITHOUT PAY']);
        } else {
            $query->where('leave_records.remarks', $remark);
        }

        if ($assigned) {
            $query->where('leave_records.assigned', $assigned);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        $records = $query->orderBy('created_at', 'asc')->get();
        return response()->json($records);
    }

    /**
     * Update an existing leave record.
     */
    public function update(Request $request, $id)
    {
        $record = LeaveRecord::findOrFail($id);
        
        // Ownership Check
        if (auth()->user()->role !== 'admin' && $record->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized. You can only edit your own records.'], 403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'forwarded' => 'nullable|string|max:255',

            'position' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'type_of_leave' => 'required|string|max:255',
            'inclusive_dates' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'date_of_action' => 'nullable|date',
            'deduction_remarks' => 'nullable|string|max:255',
            'incharge' => 'nullable|string|max:255',
        ]);

        if (isset($validated['forwarded'])) {
            $validated['forwarded'] = trim(explode(' - ', $validated['forwarded'])[0]);
        }

        $record->update($validated);
        
        // Also update the matching record in employees table by ID
        Employee::where('id', $record->id)->update($validated);

        $this->syncDirectories($record);

        // Log action
        AuditLog::logAction('Updated leave record', $record, 'Employee: ' . $record->name);

        return response()->json([
            'success' => true,
            'message' => 'Record updated successfully!',
            'record' => $record,
        ]);
    }

    /**
     * Remove the specified leave record.
     */
    public function destroy($id)
    {
        $record = LeaveRecord::findOrFail($id);
        
        // Ownership Check
        if (auth()->user()->role !== 'admin' && $record->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized. You can only delete your own records.'], 403);
        }
        
        // Also remove from employees table too by ID
        Employee::where('id', $record->id)->delete();
            
        $record->delete();

        // Log action
        AuditLog::logAction('Deleted leave record', $record, 'ID: ' . $id . ', Employee: ' . $record->name);

        return response()->json([
            'success' => true,
            'message' => 'Record deleted successfully!'
        ]);
    }

    public function getIncharges(Request $request)
    {
        $assignment = $request->query('assigned');
        
        // 1. Get all users as potential incharges
        $usersQuery = User::query();
        if ($assignment && $assignment !== 'all') {
            $usersQuery->where('assigned', $assignment);
        }
        $users = $usersQuery->get();
        
        $result = $users->map(function ($user) {
            $name = trim($user->name);
            $leave_count = LeaveRecord::where('user_id', $user->id)->count();

            return (object)[
                'id' => $user->id,
                'incharge' => $name,
                'first_name' => trim($user->first_name),
                'leave_count' => $leave_count,
                'profile_image' => $user->profile_image,
                'cover_image' => $user->cover_image,
                'position' => $user->position,
                'assigned' => $user->assigned,
            ];
        });

        // 2. Add legacy incharges who might not be in the users table
        $legacyQuery = LeaveRecord::whereNotNull('incharge')->where('incharge', '!=', '');
        if ($assignment && $assignment !== 'all') {
            $legacyQuery->where('assigned', $assignment);
        }
        
        $legacyNames = $legacyQuery->distinct()->pluck('incharge');
        $existingNames = $result->pluck('incharge')->map(fn($n) => strtolower(trim($n)))->toArray();
        $existingFirstNames = $result->pluck('first_name')->map(fn($n) => strtolower(trim($n)))->toArray();
        
        foreach ($legacyNames as $lName) {
            $trimmedLName = trim($lName);
            $lowerLName = strtolower($trimmedLName);
            
            // Avoid duplicates if the legacy name matches either a user's full name or first name
            if (!in_array($lowerLName, $existingNames) && !in_array($lowerLName, $existingFirstNames)) {
                $result->push((object)[
                    'id' => null,
                    'incharge' => $trimmedLName,
                    'first_name' => $trimmedLName,
                    'leave_count' => LeaveRecord::where('incharge', $lName)->count(),
                    'profile_image' => null,
                    'assigned' => $assignment
                ]);
                
                // Add to existing names to prevent further duplicates from legacy names
                $existingNames[] = $lowerLName;
                $existingFirstNames[] = $lowerLName;
            }
        }
        
        // Final de-duplication based on first_name (what actually displays in the UI)
        $uniqueResult = [];
        $seenDisplays = [];
        
        foreach ($result as $item) {
            $display = strtolower(trim($item->first_name ?: $item->incharge));
            if (!in_array($display, $seenDisplays)) {
                $seenDisplays[] = $display;
                $uniqueResult[] = $item;
            }
        }

        return response()->json($uniqueResult);
    }

    /**
     * Get records for a specific incharge.
     */
    public function getByIncharge(Request $request)
    {
        $incharge = $request->input('incharge');
        $assigned = $request->query('assigned');
        
        // Find the user to get their name and ID for a thorough search
        $userId = $request->input('user_id');
        $user = null;
        
        if ($userId && $userId !== 'undefined' && $userId !== '') {
            $user = User::find($userId);
        }
        
        if (!$user) {
            $user = User::whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$incharge])
                      ->orWhere('first_name', $incharge)
                      ->first();
        }
        
        $query = LeaveRecord::leftJoin('users', 'leave_records.user_id', '=', 'users.id')
            ->select('leave_records.*', 'users.first_name')
            ->where(function($q) use ($incharge, $user) {
                $q->where('leave_records.incharge', $incharge);
                if ($user) {
                    $q->orWhere('leave_records.incharge', $user->name);
                    $q->orWhere('leave_records.incharge', $user->first_name);
                    $q->orWhere('leave_records.user_id', $user->id);
                }
            });

        if ($assigned && $assigned !== 'all') {
            $query->where('leave_records.assigned', $assigned);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('leave_records.date_of_action', $request->date);
        }

        $records = $query->orderBy('leave_records.created_at', 'asc')->get();
        return response()->json($records);
    }

    /**
     * Get statistics for the dashboard.
     */
    public function getDashboardStats()
    {
        $user = auth()->user();
        $isUser = $user && $user->role !== 'admin';
        
        $query = LeaveRecord::query();
        if ($isUser) {
            $query->where('user_id', $user->id);
        }

        // Calculate distinct leave types used in records (handles comma-separated values)
        $records = (clone $query)->whereNotNull('type_of_leave')
            ->where('type_of_leave', '!=', '')
            ->where('type_of_leave', '!=', '-')
            ->pluck('type_of_leave');
            
        $typesFound = [];
        foreach ($records as $r) {
            foreach (explode(',', (string)$r) as $t) {
                $trimmed = trim((string)$t);
                if ($trimmed !== '' && $trimmed !== '-') {
                    $typesFound[] = $trimmed;
                }
            }
        }
        $leaveTypesCount = count(array_unique($typesFound));

        return response()->json([
            'total_records' => (clone $query)->count(),
            'total_employees' => (clone $query)->whereNotNull('name')->where('name', '!=', '')->distinct()->count('name'),
            'total_schools' => (clone $query)->whereNotNull('school')->where('school', '!=', '')->distinct()->count('school'),
            'total_positions' => (clone $query)->whereNotNull('position')->where('position', '!=', '')->distinct()->count('position'),
            'unprocessed' => (clone $query)->where('is_processed', false)->count(),
            'total_remarks' => (clone $query)->whereNotNull('remarks')->where('remarks', '!=', '')->distinct()->count('remarks'),
            'total_types_of_leave' => $leaveTypesCount,
            'processed' => (clone $query)->where('is_processed', true)->count(),
            'today_records' => (clone $query)->whereDate('created_at', now()->toDateString())->count(),
        ]);
    }

    /**
     * Get record counts per incharge for a specific period.
     */
    public function getInchargeStats(Request $request)
    {
        $user = auth()->user();
        $isUser = $user && $user->role !== 'admin';
        $period = $request->query('period', 'day');
        
        $query = LeaveRecord::select('incharge')
            ->selectRaw('COUNT(*) as total_count')
            ->whereNotNull('incharge')
            ->where('incharge', '!=', '')
            ->where('incharge', '!=', '-')
            ->groupBy('incharge')
            ->orderBy('total_count', 'desc');

        if ($isUser) {
            $query->where('user_id', $user->id);
        }

        if ($period === 'day') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } elseif ($period === 'year') {
            $query->whereYear('created_at', now()->year);
        }

        return response()->json($query->get());
    }

    /**
     * Get module usage stats for bubble chart.
     */
    public function getModuleUsageStats(Request $request)
    {
        $user = auth()->user();
        $period = $request->query('period', 'day');
        
        $query = AuditLog::select('action');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        if ($period === 'day') {
            $query->whereDate('created_at', now()->toDateString());
            $query->selectRaw('HOUR(created_at) as time_key');
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
            $query->selectRaw('DAY(created_at) as time_key');
        } else { // year
            $query->whereYear('created_at', now()->year);
            $query->selectRaw('MONTH(created_at) as time_key');
        }

        $stats = $query->selectRaw('COUNT(*) as total')
            ->groupBy('action', 'time_key')
            ->get();

        return response()->json($stats);
    }

    /**
     * Get remark stats for pie chart.
     */
    public function getRemarkStats(Request $request)
    {
        $user = auth()->user();
        $isUser = $user && $user->role !== 'admin';
        $period = $request->query('period', 'day');
        
        $query = LeaveRecord::query();

        if ($isUser) {
            $query->where('user_id', $user->id);
        }

        if ($period === 'day') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } else { // year
            $query->whereYear('created_at', now()->year);
        }

        // Get all relevant remarks for grouping
        $records = $query->whereNotNull('remarks')->where('remarks', '!=', '')->pluck('remarks');
        
        $groups = [
            'With Pay' => 0,
            'Without Pay' => 0,
            'With Pay & Without Pay' => 0
        ];

        foreach ($records as $remark) {
            $lower = strtolower(trim((string)$remark));
            if (str_contains($lower, '&') || (str_contains($lower, 'with') && str_contains($lower, 'without'))) {
                 $groups['With Pay & Without Pay']++;
            } elseif (str_contains($lower, 'without') || $lower === 'w/o') {
                 $groups['Without Pay']++;
            } elseif (str_contains($lower, 'with') || $lower === 'w/p') {
                 $groups['With Pay']++;
            }
        }

        $result = [];
        foreach ($groups as $label => $total) {
            $result[] = ['remarks' => $label, 'total' => $total];
        }

        return response()->json($result);
    }
    /**
     * Store multiple leave records from Excel import.
     */
    public function bulkStore(Request $request)
    {
        $recordsArr = $request->input('records');
        if (!is_array($recordsArr)) {
            return response()->json(['success' => false, 'message' => 'Invalid data format'], 400);
        }

        $savedCount = 0;
        
        // If imported from leave-records page, mark as already processed
        $isFromLeaveRecords = $request->input('source') === 'leave-records';
        
        // If a target batch is specified (adding to existing batch), use it
        $targetBatch = $request->input('target_batch');
        
        // Starting batch_id
        if ($targetBatch) {
            $currentBatch = (int) $targetBatch;
        } else {
            $currentBatch = (LeaveRecord::max('batch_id') ?? 0) + 1;
        }
        
        // Track forwardeds to detect when a forwarded repeats (new group)
        $lastForwarded = null;
        $seenForwardeds = [];
        
        foreach ($recordsArr as $data) {
            // Basic validation
            if (empty($data['name']) || $data['name'] === '-') continue;

            $forwardedValue = $data['forwarded'] ?? null;
            
            // If this "forwarded" was seen before but is not the same as the last one,
            // it means a new group started (e.g., SDO → SDS → SDO again)
            if ($forwardedValue !== null && $forwardedValue !== $lastForwarded && in_array($forwardedValue, $seenForwardeds)) {
                $currentBatch++;
                $seenForwardeds = []; // Reset for the new batch
            }
            
            if ($forwardedValue !== null && !in_array($forwardedValue, $seenForwardeds)) {
                $seenForwardeds[] = $forwardedValue;
            }
            $lastForwarded = $forwardedValue;

            if ($forwardedValue) {
                $forwardedValue = trim(explode(' - ', $forwardedValue)[0]);
            }

            $record = LeaveRecord::create([
                'name' => $data['name'],
                'forwarded' => $forwardedValue,
                'position' => $data['position'] ?? '-',
                'school' => $data['school'] ?? '-',
                'type_of_leave' => $data['type_of_leave'] ?? '-',
                'inclusive_dates' => $data['inclusive_dates'] ?? '-',
                'remarks' => $data['remarks'] ?? '-',
                'date_of_action' => !empty($data['date_of_action']) && $data['date_of_action'] !== '-' 
                    ? date('Y-m-d', strtotime($data['date_of_action'])) 
                    : null,
                'deduction_remarks' => $data['deduction_remarks'] ?? '-',
                'incharge' => auth()->user()->name ?? auth()->user()->email ?? '-',
                'batch_id' => $currentBatch,
                'is_processed' => $isFromLeaveRecords,
                'processed_at' => $isFromLeaveRecords ? now() : null,
                'user_id' => auth()->id(),
            ]);

            // Also save to employees table
            Employee::create([
                'name' => $record->name,
                'forwarded' => $record->forwarded,
                'position' => $record->position,
                'school' => $record->school,
                'type_of_leave' => $record->type_of_leave,
                'inclusive_dates' => $record->inclusive_dates,
                'remarks' => $record->remarks,
                'date_of_action' => $record->date_of_action,
                'deduction_remarks' => $record->deduction_remarks,
                'incharge' => auth()->user()->name ?? auth()->user()->email ?? '-',
                'user_id' => auth()->id(),
            ]);

            $this->syncDirectories($record);
            $savedCount++;
        }

        // Log action
        AuditLog::logAction('Bulk imported ' . $savedCount . ' records', null, 'Total: ' . $savedCount);

        return response()->json([
            'success' => true,
            'message' => "Successfully imported $savedCount records!",
        ]);
    }
}
