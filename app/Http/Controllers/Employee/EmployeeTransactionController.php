<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeTransactionController extends Controller
{
    public function timeEntries()
    {
        $employee = auth()->user()->employee;
        
        $attendances = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        return view('employee.transactions.time-entries', compact('attendances'));
    }

    public function absences()
    {
        $employee = auth()->user()->employee;
        
        // Get all dates in current month
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        // Get all attendance records for current month
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->pluck('date')
            ->map(function($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();
        
        // Get all working days (excluding weekends)
        $absences = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate && $currentDate <= Carbon::now()) {
            // Skip weekends (Saturday = 6, Sunday = 0)
            if ($currentDate->dayOfWeek != 0 && $currentDate->dayOfWeek != 6) {
                $dateStr = $currentDate->format('Y-m-d');
                if (!in_array($dateStr, $attendances)) {
                    $absences[] = [
                        'date' => $currentDate->copy(),
                        'day' => $currentDate->format('l'),
                    ];
                }
            }
            $currentDate->addDay();
        }
        
        return view('employee.transactions.absences', compact('absences'));
    }

    public function daysPresent()
    {
        $employee = auth()->user()->employee;
        
        // Get current month stats
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $presentDays = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();
        
        $totalPresent = $presentDays->count();
        $onTime = $presentDays->where('status', 'present')->count();
        $late = $presentDays->where('status', 'late')->count();
        
        // Calculate working days (excluding weekends)
        $workingDays = 0;
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate && $currentDate <= Carbon::now()) {
            if ($currentDate->dayOfWeek != 0 && $currentDate->dayOfWeek != 6) {
                $workingDays++;
            }
            $currentDate->addDay();
        }
        
        return view('employee.transactions.days-present', compact('presentDays', 'totalPresent', 'onTime', 'late', 'workingDays'));
    }
}
