<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $employee = auth()->user()->employee;
        
        if (!$employee) {
            return redirect()->route('dashboard')->with('error', 'Employee profile not found.');
        }

        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        $stats = [
            'total_leaves' => Leave::where('employee_id', $employee->id)->count(),
            'pending_leaves' => Leave::where('employee_id', $employee->id)->where('status', 'pending')->count(),
            'approved_leaves' => Leave::where('employee_id', $employee->id)->where('status', 'approved')->count(),
            'total_attendance' => Attendance::where('employee_id', $employee->id)->count(),
            'present_days' => Attendance::where('employee_id', $employee->id)->where('status', 'present')->count(),
            'late_days' => Attendance::where('employee_id', $employee->id)->where('status', 'late')->count(),
        ];

        $recentAttendances = Attendance::where('employee_id', $employee->id)
            ->latest('date')
            ->take(10)
            ->get();

        $recentLeaves = Leave::where('employee_id', $employee->id)
            ->with('leaveType')
            ->latest()
            ->take(5)
            ->get();

        return view('employee.dashboard', compact('employee', 'todayAttendance', 'stats', 'recentAttendances', 'recentLeaves'));
    }
}
