<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeAttendanceController extends Controller
{
    public function index()
    {
        $employee = auth()->user()->employee;
        
        $attendances = Attendance::where('employee_id', $employee->id)
            ->latest('date')
            ->paginate(20);

        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        return view('employee.attendance.index', compact('attendances', 'todayAttendance'));
    }

    public function checkIn(Request $request)
    {
        $employee = auth()->user()->employee;
        
        $existingAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        if ($existingAttendance) {
            return back()->with('error', 'You have already checked in today.');
        }

        $checkInTime = now();
        $workStartTime = Carbon::today()->setTime(9, 0, 0); // 9:00 AM
        
        $status = 'present';
        if ($checkInTime->greaterThan($workStartTime)) {
            $status = 'late';
        }

        Attendance::create([
            'employee_id' => $employee->id,
            'date' => today(),
            'check_in' => $checkInTime,
            'status' => $status,
        ]);

        return back()->with('success', 'Checked in successfully at ' . $checkInTime->format('h:i A'));
    }

    public function checkOut(Request $request)
    {
        $employee = auth()->user()->employee;
        
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        if (!$attendance) {
            return back()->with('error', 'No check-in record found for today.');
        }

        if ($attendance->check_out) {
            return back()->with('error', 'You have already checked out today.');
        }

        $attendance->update(['check_out' => now()]);

        return back()->with('success', 'Checked out successfully at ' . now()->format('h:i A'));
    }
}
