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
use Illuminate\Http\Request;

class LeaveRecordController extends Controller
{
    /**
     * Get all leave records.
     */
    public function index(Request $request)
    {
        $query = LeaveRecord::orderBy('batch_id', 'asc')
            ->orderBy('forwarded', 'asc')
            ->orderBy('created_at', 'asc');

        // Isolation Logic:
        // 1. The "Registry" modal (on the Form page) is personal work - only see your own records.
        // 2. The "History" page (on leave-records page) shows everyone's work, but grouped separately.
        if ($request->has('view') && $request->view === 'registry') {
            $query->where('is_processed', false);
            if (auth()->check()) {
                $query->where('user_id', auth()->id());
            }
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        if ($request->has('incharge') && $request->incharge) {
            $query->where('incharge', $request->incharge);
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
        return response()->json(LeaveRecord::findOrFail($id));
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
        
        // Tag the record with the current user's ID
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }
        
        // If from leave-records page, mark as already processed
    if ($isFromLeaveRecords) {
        $validated['is_processed'] = true;
        $validated['processed_at'] = now();
    }

        // Automatically set incharge to the current user's username
        $validated['incharge'] = auth()->user()->username ?? auth()->user()->name ?? auth()->user()->email ?? '-';

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
                    ]
                );
            }
        }

        // Sync Remarks
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
        $names = LeaveRecord::distinct()->pluck('name')->filter()->values();
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
        $employeeMap = LeaveRecord::orderBy('created_at', 'desc')
            ->get(['name', 'forwarded', 'position', 'school'])
            ->unique('name')
            ->mapWithKeys(function ($record) {
                return [$record->name => [
                    'forwarded' => $record->forwarded ? trim(explode(' - ', $record->forwarded)[0]) : null,
                    'position' => $record->position,
                    'school' => $record->school
                ]];
            });

        $incharges = LeaveRecord::whereNotNull('incharge')->distinct()->pluck('incharge')->filter()->values();

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
        $query = LeaveRecord::where('school', $school);



        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        $records = $query->orderBy('created_at', 'asc')->get();
        return response()->json($records);
    }
    
    /**
     * Get list of all schools with stats.
     */
    public function getSchools() 
    {
        // Get unique schools from LeaveRecord table
        $schools = LeaveRecord::whereNotNull('school')
            ->where('school', '!=', '')
            ->select('school')
            ->selectRaw('COUNT(*) as leave_count')
            ->groupBy('school')
            ->orderBy('school')
            ->get()
            ->map(function($r) {
                $s = School::where('name', $r->school)->first();
                return [
                    'school' => $r->school,
                    'type' => $s ? $s->type : 'Other',
                    'leave_count' => $r->leave_count
                ];
            });
            
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
    public function getPositions()
    {
        $positions = LeaveRecord::whereNotNull('position')
            ->where('position', '!=', '')
            ->select('position')
            ->selectRaw('COUNT(*) as leave_count')
            ->groupBy('position')
            ->orderBy('position')
            ->get();
            
        return response()->json($positions);
    }

    /**
     * Get records for a specific position.
     */
    public function getByPosition(Request $request)
    {
        $position = $request->input('position');
        $query = LeaveRecord::where('position', $position);



        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        $records = $query->orderBy('created_at', 'asc')->get();
        return response()->json($records);
    }

    /**
     * Get list of all leave types with stats.
     */
    public function getLeaveTypes()
    {
        // For leave types, we use the LeaveType directory to know which types to count
        // but we only return those with count > 0.
        // Also support multi-type records by searching with 'like'.
        $types = LeaveType::orderBy('name')->get();
        
        $results = $types->map(function($t) {
            $count = LeaveRecord::where('type_of_leave', 'like', '%' . $t->name . '%')->count();
            
            return [
                'type_of_leave' => $t->name,
                'leave_count' => $count
            ];
        })
        ->filter(function($t) {
            return $t['leave_count'] > 0;
        })
        ->values();
            
        return response()->json($results);
    }

    /**
     * Get records for a specific leave type.
     */
    public function getByLeaveType(Request $request)
    {
        $type = $request->input('type');
        $query = LeaveRecord::where('type_of_leave', 'like', '%' . $type . '%');



        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        $records = $query->orderBy('created_at', 'asc')->get();
        return response()->json($records);
    }

    /**
     * Get list of all remarks with stats.
     */
    public function getRemarksList()
    {
        // Get unique remarks directly from LeaveRecord table
        $remarks = LeaveRecord::whereNotNull('remarks')
            ->where('remarks', '!=', '')
            ->select('remarks')
            ->selectRaw('COUNT(*) as leave_count')
            ->groupBy('remarks')
            ->get();

        $resultsGrouped = [];
        
        foreach ($remarks as $r) {
            $name = $r->remarks;
            $key = $name;
            
            // Normalize W/O to Without Pay for grouping
            if (strtolower($name) === 'w/o') {
                $key = 'Without Pay';
            }
            
            if (isset($resultsGrouped[$key])) {
                $resultsGrouped[$key]['leave_count'] += $r->leave_count;
            } else {
                $resultsGrouped[$key] = [
                    'remarks' => $key,
                    'leave_count' => $r->leave_count
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
        $query = LeaveRecord::query();



        if (strtolower($remark) === 'without pay') {
            $query->whereIn('remarks', ['Without Pay', 'W/O', 'w/o', 'WITHOUT PAY']);
        } else {
            $query->where('remarks', $remark);
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
        
        // Also update the matching record in employees table if it was newly added 
        // (Note: This logic could be more complex depending on how Employee entries are linked, 
        // but for now we follow the same pattern as store)
        Employee::where('name', $record->getOriginal('name'))
            ->where('date_of_action', $record->getOriginal('date_of_action'))
            ->update($validated);

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
        
        // Optionally remove from employees table too
        Employee::where('name', $record->name)
            ->where('date_of_action', $record->date_of_action)
            ->delete();
            
        $record->delete();

        // Log action
        AuditLog::logAction('Deleted leave record', $record, 'ID: ' . $id . ', Employee: ' . $record->name);

        return response()->json([
            'success' => true,
            'message' => 'Record deleted successfully!'
        ]);
    }

    /**
     * Get list of all incharges with stats and user profile data.
     */
    public function getIncharges()
    {
        $incharges = LeaveRecord::whereNotNull('incharge')
            ->where('incharge', '!=', '')
            ->select('incharge')
            ->selectRaw('COUNT(*) as leave_count')
            ->groupBy('incharge')
            ->orderBy('incharge')
            ->get();

        // Try to match incharge names to user accounts for profile/cover images
        $users = \App\Models\User::all();
        $userMap = [];
        foreach ($users as $u) {
            $fullName = trim(($u->first_name ?? '') . ' ' . ($u->last_name ?? ''));
            if ($fullName) $userMap[strtolower($fullName)] = $u;
            if ($u->name) $userMap[strtolower($u->name)] = $u;
            if ($u->username) $userMap[strtolower($u->username)] = $u;
        }

        $result = $incharges->map(function ($item) use ($userMap) {
            $key = strtolower(trim($item->incharge));
            $user = $userMap[$key] ?? null;
            $item->profile_image = $user ? $user->profile_image : null;
            $item->cover_image = $user ? $user->cover_image : null;
            $item->position = $user ? $user->position : null;
            $item->profile_offset_x = $user ? $user->profile_offset_x : 0;
            $item->profile_offset_y = $user ? $user->profile_offset_y : 0;
            $item->profile_zoom = $user ? $user->profile_zoom : 1.0;
            $item->cover_offset_x = $user ? $user->cover_offset_x : 50;
            $item->cover_offset_y = $user ? $user->cover_offset_y : 50;
            $item->cover_zoom = $user ? $user->cover_zoom : 1.0;
            return $item;
        });

        return response()->json($result);
    }

    /**
     * Get records for a specific incharge.
     */
    public function getByIncharge(Request $request)
    {
        $incharge = $request->input('incharge');
        $query = LeaveRecord::where('incharge', $incharge);



        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        $records = $query->orderBy('created_at', 'asc')->get();
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

        return response()->json([
            'total_records' => (clone $query)->count(),
            'total_employees' => (clone $query)->whereNotNull('name')->where('name', '!=', '')->distinct()->count('name'),
            'total_schools' => (clone $query)->whereNotNull('school')->where('school', '!=', '')->distinct()->count('school'),
            'total_positions' => (clone $query)->whereNotNull('position')->where('position', '!=', '')->distinct()->count('position'),
            'unprocessed' => (clone $query)->where('is_processed', false)->count(),
            'total_remarks' => (clone $query)->whereNotNull('remarks')->where('remarks', '!=', '')->distinct()->count('remarks'),
            'total_types_of_leave' => LeaveType::count(), // Leave types are global
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
        
        $query = LeaveRecord::select('remarks')
            ->selectRaw('COUNT(*) as total')
            ->whereIn('remarks', ['With Pay', 'Without Pay', 'With Pay & Without Pay'])
            ->groupBy('remarks');

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

        return response()->json($query->get());
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
                'incharge' => auth()->user()->username ?? auth()->user()->name ?? auth()->user()->email ?? '-',
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
                'incharge' => auth()->user()->username ?? auth()->user()->name ?? auth()->user()->email ?? '-',
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
