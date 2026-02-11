<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('employee');
        
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', today());
        }
        
        $attendances = $query->latest()->paginate(20);
        
        return view('attendances.index', compact('attendances'));
    }

    public function checkIn(Request $request)
    {
        $employee = auth()->user()->employee;
        
        $attendance = Attendance::firstOrCreate(
            [
                'employee_id' => $employee->id,
                'date' => today(),
            ],
            [
                'check_in' => now(),
                'status' => 'present',
            ]
        );

        return back()->with('success', 'Checked in successfully.');
    }

    public function checkOut(Request $request)
    {
        $employee = auth()->user()->employee;
        
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        if ($attendance) {
            $attendance->update(['check_out' => now()]);
            return back()->with('success', 'Checked out successfully.');
        }

        return back()->with('error', 'No check-in record found.');
    }
}
