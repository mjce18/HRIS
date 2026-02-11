@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('employees.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Employees
    </a>
</div>

<div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $employee->first_name }} {{ $employee->last_name }}</h2>
            <a href="{{ route('employees.edit', $employee) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Employee
            </a>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Personal Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Employe ID</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->employee_code }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->date_of_birth ? $employee->date_of_birth->format('M d, Y') : 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gender</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->gender ? ucfirst($employee->gender) : 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Marital Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->marital_status ? ucfirst($employee->marital_status) : 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Employment Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Employment Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Department</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->department->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Position</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->position->title ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Hire Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->hire_date->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Employment Type</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst($employee->employment_type) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Salary</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->salary ? '$' . number_format($employee->salary, 2) : 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $employee->status === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Contact Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->address ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">City</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->city ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">State</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->state ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Country</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->country ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Emergency Contact -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Emergency Contact</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->emergency_contact_name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $employee->emergency_contact_phone ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Attendance</h3>
        @if($employee->attendances->count() > 0)
            <div class="space-y-2">
                @foreach($employee->attendances->take(5) as $attendance)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-400">{{ $attendance->date->format('M d, Y') }}</span>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $attendance->status === 'present' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400' }}">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 dark:text-gray-400">No attendance records found.</p>
        @endif
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Leaves</h3>
        @if($employee->leaves->count() > 0)
            <div class="space-y-2">
                @foreach($employee->leaves->take(5) as $leave)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-400">{{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d') }}</span>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            @if($leave->status === 'approved') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                            @elseif($leave->status === 'rejected') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400
                            @else bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 @endif">
                            {{ ucfirst($leave->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 dark:text-gray-400">No leave records found.</p>
        @endif
    </div>
</div>
@endsection
