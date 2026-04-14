<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\LeaveRecord;

use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        $user = auth()->user();
        $assigned = $request->query('assigned');
        
        // Admin can see everything if they choose 'all'
        // Regular users must choose one (national or city)
        if ($user->role !== 'admin') {
            if (!$assigned || $assigned === 'all') {
                $assigned = strtolower($user->assigned) ?: 'national';
            }
        }

        // Get employees with at least one leave record, filtering by creator's assignment
        $query = LeaveRecord::whereNotNull('name')->where('name', '!=', '');

        if ($assigned && $assigned !== 'all') {
            $query->where('assigned', $assigned);
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
        $user = auth()->user();
        $name = $request->input('name');
        $assigned = $request->query('assigned');

        if ($user->role !== 'admin') {
            if (!$assigned || $assigned === 'all') {
                $assigned = strtolower($user->assigned) ?: 'national';
            }
        }

        $records = LeaveRecord::leftJoin('users', function($join) {
                $join->on('leave_records.user_id', '=', 'users.id')
                     ->orOn('leave_records.incharge', '=', DB::raw("CONCAT(users.first_name, ' ', users.last_name)"));
            })
            ->select('leave_records.*', 'users.first_name')
            ->where('leave_records.name', $name);

        if ($assigned && $assigned !== 'all') {
            $records->where('leave_records.assigned', $assigned);
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
