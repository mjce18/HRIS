<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function index()
    {
        $overtimes = Overtime::with(['employee.user', 'approver'])
            ->latest()
            ->paginate(15);
            
        return view('overtimes.index', compact('overtimes'));
    }

    public function approve(Overtime $overtime)
    {
        if ($overtime->status !== 'pending') {
            return back()->with('error', 'Only pending overtime requests can be approved.');
        }

        $overtime->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Overtime request approved successfully.');
    }

    public function reject(Request $request, Overtime $overtime)
    {
        if ($overtime->status !== 'pending') {
            return back()->with('error', 'Only pending overtime requests can be rejected.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $overtime->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('success', 'Overtime request rejected.');
    }
}
