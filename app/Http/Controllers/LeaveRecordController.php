<?php

namespace App\Http\Controllers;

use App\Models\LeaveRecord;
use App\Models\School;
use App\Models\Position;
use App\Models\LeaveType;
use App\Models\Remark;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class LeaveRecordController extends Controller
{
    /**
     * Get all leave records.
     */
    public function index(Request $request)
    {
        $query = LeaveRecord::orderBy('batch_id', 'asc')->orderBy('created_at', 'asc');

        if ($request->has('view') && $request->view === 'registry') {
            $query->where('is_processed', false);
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

        return view('leave-records');
    }

    /**
     * Mark records as processed/cleared from registry.
     */
    public function bulkProcess(Request $request)
    {
        $ids = $request->input('ids');
        
        // Get the next batch_id for future records
        $currentMaxBatch = LeaveRecord::max('batch_id') ?? 1;
        $nextBatch = $currentMaxBatch + 1;
        
        if ($ids === 'all') {
            LeaveRecord::where('is_processed', false)->update(['is_processed' => true]);
        } elseif (is_array($ids)) {
            LeaveRecord::whereIn('id', $ids)->update(['is_processed' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Records cleared from registry successfully.',
            'next_batch' => $nextBatch
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
            'department' => 'nullable|string|max:255',

            'position' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'type_of_leave' => 'required|string|max:255',
            'inclusive_dates' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'date_of_action' => 'nullable|date',
            'deduction_remarks' => 'nullable|string|max:255',
            'incharge' => 'nullable|string|max:255',
        ]);

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
        
        // If from leave-records page, mark as already processed
        if ($isFromLeaveRecords) {
            $validated['is_processed'] = true;
        }

        $record = LeaveRecord::create($validated);

        // Also save to employees table
        Employee::create($validated);

        // Sync with directory tables
        $this->syncDirectories($record);

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

        // Sync Department
        if ($record->department) {
            Department::updateOrCreate(
                ['name' => $record->department],
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
        $departments = Department::orderBy('name')->pluck('name');

        // Get latest position and school for each employee to auto-fill form
        $employeeMap = LeaveRecord::orderBy('created_at', 'desc')
            ->get(['name', 'department', 'position', 'school'])
            ->unique('name')
            ->mapWithKeys(function ($record) {
                return [$record->name => [
                    'department' => $record->department,
                    'position' => $record->position,
                    'school' => $record->school
                ]];
            });

        return response()->json([
            'names' => $names,
            'positions' => $positions,
            'schools' => $schoolGroups,
            'leave_types' => $leaveTypes,
            'remarks' => $remarks,
            'departments' => $departments,
            'employee_map' => $employeeMap,
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
        $schools = School::withCount('leaveRecords as leave_count')
            ->orderBy('name')
            ->get()
            ->map(function($s) {
                return [
                    'school' => $s->name,
                    'type' => $s->type,
                    'leave_count' => $s->leave_count
                ];
            });
            
        return response()->json($schools);
    }

    /**
     * Get total record count.
     */
    public function count()
    {
        return response()->json([
            'count' => LeaveRecord::where('is_processed', false)->count(),
        ]);
    }

    /**
     * Get list of all positions with stats.
     */
    public function getPositions()
    {
        $positions = Position::withCount('leaveRecords as leave_count')
            ->orderBy('name')
            ->get()
            ->map(function($p) {
                return [
                    'position' => $p->name,
                    'leave_count' => $p->leave_count
                ];
            });
            
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
        $types = LeaveType::orderBy('name')->get();
        
        $results = $types->map(function($t) {
            $count = LeaveRecord::where('type_of_leave', 'like', '%' . $t->name . '%')->count();
            return [
                'type_of_leave' => $t->name,
                'leave_count' => $count
            ];
        });
            
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
        $remarks = Remark::withCount('leaveRecords as leave_count')
            ->orderBy('name')
            ->get()
            ->map(function($r) {
                return [
                    'remarks' => $r->name,
                    'leave_count' => $r->leave_count
                ];
            });
            
        return response()->json($remarks);
    }

    /**
     * Get records for a specific remark.
     */
    public function getByRemark(Request $request)
    {
        $remark = $request->input('remark');
        $query = LeaveRecord::where('remarks', $remark);

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
            'department' => 'nullable|string|max:255',

            'position' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'type_of_leave' => 'required|string|max:255',
            'inclusive_dates' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'date_of_action' => 'nullable|date',
            'deduction_remarks' => 'nullable|string|max:255',
            'incharge' => 'nullable|string|max:255',
        ]);

        $record->update($validated);
        
        // Also update the matching record in employees table if it was newly added 
        // (Note: This logic could be more complex depending on how Employee entries are linked, 
        // but for now we follow the same pattern as store)
        Employee::where('name', $record->getOriginal('name'))
            ->where('date_of_action', $record->getOriginal('date_of_action'))
            ->update($validated);

        $this->syncDirectories($record);

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

        return response()->json([
            'success' => true,
            'message' => 'Record deleted successfully!'
        ]);
    }

    /**
     * Get list of all incharges with stats.
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
            
        return response()->json($incharges);
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
        
        // Track departments to detect when a department repeats (new group)
        $lastDept = null;
        $seenDepts = [];
        
        foreach ($recordsArr as $data) {
            // Basic validation
            if (empty($data['name']) || $data['name'] === '-') continue;

            $dept = $data['department'] ?? null;
            
            // If this department was seen before but is not the same as the last one,
            // it means a new group started (e.g., SDO → SDS → SDO again)
            if ($dept !== null && $dept !== $lastDept && in_array($dept, $seenDepts)) {
                $currentBatch++;
                $seenDepts = []; // Reset for the new batch
            }
            
            if ($dept !== null && !in_array($dept, $seenDepts)) {
                $seenDepts[] = $dept;
            }
            $lastDept = $dept;

            $record = LeaveRecord::create([
                'name' => $data['name'],
                'department' => $dept,
                'position' => $data['position'] ?? '-',
                'school' => $data['school'] ?? '-',
                'type_of_leave' => $data['type_of_leave'] ?? '-',
                'inclusive_dates' => $data['inclusive_dates'] ?? '-',
                'remarks' => $data['remarks'] ?? '-',
                'date_of_action' => !empty($data['date_of_action']) && $data['date_of_action'] !== '-' 
                    ? date('Y-m-d', strtotime($data['date_of_action'])) 
                    : null,
                'deduction_remarks' => $data['deduction_remarks'] ?? '-',
                'incharge' => $data['incharge'] ?? '-',
                'batch_id' => $currentBatch,
                'is_processed' => $isFromLeaveRecords,
            ]);

            // Also save to employees table
            Employee::create([
                'name' => $record->name,
                'department' => $record->department,
                'position' => $record->position,
                'school' => $record->school,
                'type_of_leave' => $record->type_of_leave,
                'inclusive_dates' => $record->inclusive_dates,
                'remarks' => $record->remarks,
                'date_of_action' => $record->date_of_action,
                'deduction_remarks' => $record->deduction_remarks,
                'incharge' => $record->incharge,
            ]);

            $this->syncDirectories($record);
            $savedCount++;
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully imported $savedCount records!",
        ]);
    }
}
