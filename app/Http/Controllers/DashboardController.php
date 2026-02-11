<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Redirect employees to their portal
        if (!$user->hasRole(['super-admin', 'admin', 'hr'])) {
            return redirect()->route('employee.dashboard');
        }
        
        $stats = [
            'total_employees' => Employee::where('status', 'active')->count(),
            'total_departments' => Department::where('status', 'active')->count(),
            'pending_leaves' => Leave::where('status', 'pending')->count(),
            'today_attendance' => Attendance::whereDate('date', today())->count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
