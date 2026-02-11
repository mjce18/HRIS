<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Notifications\EmployeeAccountActivation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['user', 'department', 'position']);
        
        // Filter by department if provided
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }
        
        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by name or employee code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%");
            });
        }
        
        $employees = $query->latest()->paginate(15)->withQueryString();
        $departments = Department::where('status', 'active')->get();
            
        return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('status', 'active')->get();
        $positions = Position::where('status', 'active')->get();
        
        return view('employees.create', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'employee_id' => 'required|string|unique:employees,employee_code',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'hire_date' => 'required|date',
            'employment_type' => 'required|in:full-time,part-time,contract,intern',
            'salary' => 'nullable|numeric|min:0',
        ]);

        // Generate activation token
        $activationToken = Str::random(64);
        $activationExpiry = Carbon::now()->addHours(48);

        // Create user account (inactive until activated)
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make(Str::random(32)), // Temporary random password
            'employee_id' => $validated['employee_id'],
            'status' => 'inactive',
            'account_activated' => false,
            'activation_token' => $activationToken,
            'activation_token_expires_at' => $activationExpiry,
        ]);

        // Assign employee role
        $user->assignRole('employee');

        // Create employee record
        $employee = Employee::create([
            'user_id' => $user->id,
            'employee_code' => $validated['employee_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'department_id' => $validated['department_id'],
            'position_id' => $validated['position_id'],
            'hire_date' => $validated['hire_date'],
            'employment_type' => $validated['employment_type'],
            'salary' => $validated['salary'],
            'status' => 'active',
        ]);

        // Generate activation URL
        $activationUrl = route('account.activate.form', ['token' => $activationToken]);

        // Send activation email
        try {
            $user->notify(new EmployeeAccountActivation($activationUrl, $validated['employee_id']));
            $message = 'Employee registered successfully. Activation email sent to ' . $user->email;
        } catch (\Exception $e) {
            $message = 'Employee registered successfully. However, activation email could not be sent. Please configure email settings.';
        }

        return redirect()->route('employees.index')
            ->with('success', $message);
    }

    public function show(Employee $employee)
    {
        $employee->load(['user', 'department', 'position', 'attendances', 'leaves']);
        
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::where('status', 'active')->get();
        $positions = Position::where('status', 'active')->get();
        
        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'employment_type' => 'required|in:full-time,part-time,contract,intern',
            'salary' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive,terminated',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        // Update employee record
        $employee->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'department_id' => $validated['department_id'],
            'position_id' => $validated['position_id'],
            'employment_type' => $validated['employment_type'],
            'salary' => $validated['salary'],
            'status' => $validated['status'],
            'address' => $validated['address'],
        ]);
        
        // Update user record
        $employee->user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        try {
            // Store employee name for success message
            $employeeName = $employee->first_name . ' ' . $employee->last_name;
            
            // Delete related user account (this will cascade delete the employee due to foreign key)
            $employee->user->delete();
            
            return redirect()->route('employees.index')
                ->with('success', "Employee {$employeeName} has been deleted successfully.");
        } catch (\Exception $e) {
            return redirect()->route('employees.index')
                ->with('error', 'Failed to delete employee. Error: ' . $e->getMessage());
        }
    }

    public function resendActivation(Employee $employee)
    {
        $user = $employee->user;

        // Check if already activated
        if ($user->account_activated) {
            return back()->with('error', 'This account is already activated.');
        }

        // Generate new activation token
        $activationToken = Str::random(64);
        $activationExpiry = Carbon::now()->addHours(48);

        $user->update([
            'activation_token' => $activationToken,
            'activation_token_expires_at' => $activationExpiry,
        ]);

        // Generate activation URL
        $activationUrl = route('account.activate.form', ['token' => $activationToken]);

        // Send activation email
        try {
            $user->notify(new EmployeeAccountActivation($activationUrl, $employee->employee_code));
            return back()->with('success', 'Activation email resent successfully to ' . $user->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send activation email. Please check email configuration.');
        }
    }
}
