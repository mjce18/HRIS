<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class EmployeeLeaveController extends Controller
{
    public function index()
    {
        $employee = auth()->user()->employee;
        
        $leaves = Leave::where('employee_id', $employee->id)
            ->with(['leaveType', 'approver'])
            ->latest()
            ->paginate(15);

        return view('employee.leaves.index', compact('leaves'));
    }

    public function create()
    {
        $leaveTypes = LeaveType::where('status', 'active')->get();
        
        return view('employee.leaves.create', compact('leaveTypes'));
    }

    public function store(Request $request)
    {
        $employee = auth()->user()->employee;

        $validated = $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:500',
        ]);

        $days = now()->parse($validated['start_date'])
            ->diffInDays(now()->parse($validated['end_date'])) + 1;

        $leave = Leave::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $validated['leave_type_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'days' => $days,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        // Create notification for HR users
        $hrUsers = \App\Models\User::role(['hr', 'admin', 'super-admin'])->get();
        foreach ($hrUsers as $hrUser) {
            \App\Models\Notification::create([
                'user_id' => $hrUser->id,
                'type' => 'leave_request',
                'title' => 'New Leave Request',
                'message' => auth()->user()->name . ' has submitted a leave request for ' . $days . ' day(s).',
                'link' => route('leaves.index'),
            ]);
        }

        return redirect()->route('employee.leaves.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function cancel(Leave $leave)
    {
        $employee = auth()->user()->employee;

        if ($leave->employee_id !== $employee->id) {
            abort(403);
        }

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Only pending leaves can be cancelled.');
        }

        $leave->update(['status' => 'cancelled']);

        return back()->with('success', 'Leave request cancelled successfully.');
    }
}
