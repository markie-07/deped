<?php

namespace App\Http\Controllers;

use App\Models\LeaveRecord;
use Illuminate\Http\Request;

class LeaveRecordController extends Controller
{
    /**
     * Get all leave records.
     */
    public function index(Request $request)
    {
        $query = LeaveRecord::orderBy('created_at', 'desc');

        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        $records = $query->get();
        return response()->json($records);
    }

    /**
     * Store a new leave record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'type_of_leave' => 'required|string|max:255',
            'inclusive_dates' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'date_of_action' => 'nullable|date',
            'deduction_remarks' => 'nullable|string|max:255',
        ]);

        $record = LeaveRecord::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Leave record saved successfully!',
            'record' => $record,
        ], 201);
    }

    /**
     * Get unique values for combobox dropdowns.
     */
    public function dropdownData()
    {
        $names = LeaveRecord::distinct()->pluck('name')->filter()->values();
        $positions = LeaveRecord::distinct()->pluck('position')->filter()->values();
        $schools = LeaveRecord::distinct()->pluck('school')->filter()->values();

        // Group schools by type based on name keywords
        $schoolGroups = [];
        foreach ($schools as $school) {
            $lower = strtolower($school);
            if (str_contains($lower, 'high school') || str_contains($lower, 'secondary') || preg_match('/\bhs\b/', $lower)) {
                $schoolGroups['High School'][] = $school;
            } elseif (str_contains($lower, 'integrated')) {
                $schoolGroups['Integrated'][] = $school;
            } elseif (str_contains($lower, 'elementary') || preg_match('/\bes\b/', $lower)) {
                $schoolGroups['Elementary'][] = $school;
            } else {
                $schoolGroups['Other'][] = $school;
            }
        }

        $leaveTypes = LeaveRecord::distinct()->pluck('type_of_leave')->filter()->values();
        $remarks = LeaveRecord::distinct()->pluck('remarks')->filter()->values();

        // Get latest position and school for each employee to auto-fill form
        $employeeMap = LeaveRecord::orderBy('created_at', 'desc')
            ->get(['name', 'position', 'school'])
            ->unique('name')
            ->mapWithKeys(function ($record) {
                return [$record->name => [
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
            'employee_map' => $employeeMap,
        ]);
    }

    /**
     * Get records for a specific school.
     */
    public function getBySchool(Request $request)
    {
        $school = $request->input('school');
        $records = LeaveRecord::where('school', $school)->orderBy('created_at', 'desc')->get();
        return response()->json($records);
    }
    
    /**
     * Get list of all schools with stats.
     */
    public function getSchools() 
    {
        $schools = LeaveRecord::select('school')
            ->selectRaw('count(*) as leave_count')
            ->groupBy('school')
            ->orderBy('school')
            ->get();
            
        return response()->json($schools);
    }

    /**
     * Get total record count.
     */
    public function count()
    {
        return response()->json([
            'count' => LeaveRecord::count(),
        ]);
    }
}
