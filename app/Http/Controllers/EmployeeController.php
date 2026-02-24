<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee');
    }

    public function getEmployees()
    {
        // Get unique employees with their latest data and count of records
        $employees = Employee::select('name')
            ->selectRaw('MAX(position) as position')
            ->selectRaw('MAX(school) as school')
            ->selectRaw('COUNT(*) as record_count')
            ->groupBy('name')
            ->orderBy('name')
            ->get();
            
        return response()->json($employees);
    }

    public function getRecordsByEmployee(Request $request)
    {
        $name = $request->input('name');
        $records = Employee::where('name', $name)
            ->orderBy('date_of_action', 'asc')
            ->get();
            
        return response()->json($records);
    }
}
