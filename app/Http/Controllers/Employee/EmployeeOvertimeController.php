<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Overtime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeOvertimeController extends Controller
{
    public function index()
    {
        $employee = auth()->user()->employee;
        
        $overtimes = Overtime::where('employee_id', $employee->id)
            ->with('approver')
            ->latest()
            ->paginate(15);

        return view('employee.overtimes.index', compact('overtimes'));
    }

    public function create()
    {
        return view('employee.overtimes.create');
    }

    public function store(Request $request)
    {
        $employee = auth()->user()->employee;

        $validated = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'required|string|max:500',
        ]);

        // Calculate hours
        $start = Carbon::createFromFormat('H:i', $validated['start_time']);
        $end = Carbon::createFromFormat('H:i', $validated['end_time']);
        $hours = $start->diffInHours($end, true);

        $overtime = Overtime::create([
            'employee_id' => $employee->id,
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'hours' => $hours,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        // Create notification for HR users
        $hrUsers = \App\Models\User::role(['hr', 'admin', 'super-admin'])->get();
        foreach ($hrUsers as $hrUser) {
            \App\Models\Notification::create([
                'user_id' => $hrUser->id,
                'type' => 'overtime_request',
                'title' => 'New Overtime Request',
                'message' => auth()->user()->name . ' has submitted an overtime request for ' . number_format($hours, 2) . ' hour(s).',
                'link' => route('overtimes.index'),
            ]);
        }

        return redirect()->route('employee.overtimes.index')
            ->with('success', 'Overtime request submitted successfully.');
    }

    public function cancel(Overtime $overtime)
    {
        $employee = auth()->user()->employee;

        if ($overtime->employee_id !== $employee->id) {
            abort(403);
        }

        if ($overtime->status !== 'pending') {
            return back()->with('error', 'Only pending overtime requests can be cancelled.');
        }

        $overtime->update(['status' => 'cancelled']);

        return back()->with('success', 'Overtime request cancelled successfully.');
    }
}
