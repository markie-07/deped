<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\LeaveRecord;

use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return view('admin.employee');
        }
        return view('user.employee');
    }

    public function getEmployees(Request $request)
    {
        $assigned = $request->query('assigned');
        
        // Get employees with at least one leave record, filtering by creator's assignment
        $query = LeaveRecord::whereNotNull('name')->where('name', '!=', '');

        if ($assigned && $assigned !== 'all') {
            $userIds = User::where('assigned', $assigned)->pluck('id');
            $query->whereIn('user_id', $userIds);
        }
        
        $employees = $query->select('name')
            ->selectRaw('MAX(position) as position')
            ->selectRaw('MAX(school) as school')
            ->selectRaw('COUNT(id) as record_count')
            ->groupBy('name')
            ->orderBy('name')
            ->get();
            
        return response()->json($employees);
    }

    public function getRecordsByEmployee(Request $request)
    {
        $name = $request->input('name');
        $assigned = $request->query('assigned');
        $records = LeaveRecord::leftJoin('users', function($join) {
                $join->on('leave_records.user_id', '=', 'users.id')
                     ->orOn('leave_records.incharge', '=', 'users.name');
            })
            ->select('leave_records.*', 'users.first_name')
            ->where('leave_records.name', $name);

        if ($assigned) {
            $userIds = User::where('assigned', $assigned)->pluck('id');
            $records->whereIn('leave_records.user_id', $userIds);
        }

        if ($request->has('date') && $request->date) {
            $records->whereDate('leave_records.date_of_action', $request->date);
        }

        $result = $records->orderBy('leave_records.date_of_action', 'desc')
            ->orderBy('leave_records.created_at', 'desc')
            ->get();
            
        return response()->json($result);
    }
}
