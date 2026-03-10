<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRecord;

class EmployeeController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return view('admin.employee');
        }
        return view('user.employee');
    }

    public function getEmployees()
    {
        // Get unique employees from LeaveRecord table
        $employees = LeaveRecord::whereNotNull('name')
            ->where('name', '!=', '')
            ->select('name')
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
        $query = LeaveRecord::where('name', $name);

        if ($request->has('date') && $request->date) {
            $query->whereDate('date_of_action', $request->date);
        }

        $records = $query->orderBy('date_of_action', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($records);
    }
}
