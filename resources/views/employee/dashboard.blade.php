@extends('layouts.employee')

@section('title', 'My Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome back, {{ $employee->first_name }}!</h2>
    <p class="text-gray-600 dark:text-gray-400">{{ now()->format('l, F j, Y') }}</p>
</div>

<!-- Quick Actions - Check In/Out -->
<div class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="text-white">
            <h3 class="text-xl font-semibold mb-2">Today's Attendance</h3>
            @if($todayAttendance)
                <p class="text-blue-100">Check In: {{ $todayAttendance->check_in->format('h:i A') }}</p>
                @if($todayAttendance->check_out)
                    <p class="text-blue-100">Check Out: {{ $todayAttendance->check_out->format('h:i A') }}</p>
                @else
                    <p class="text-blue-100">Currently working...</p>
                @endif
            @else
                <p class="text-blue-100">You haven't checked in today</p>
            @endif
        </div>
        <div class="flex gap-3">
            @if(!$todayAttendance)
                <form method="POST" action="{{ route('employee.attendance.check-in') }}">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors shadow-md">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Check In
                    </button>
                </form>
            @elseif(!$todayAttendance->check_out)
                <form method="POST" action="{{ route('employee.attendance.check-out') }}">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-white text-red-600 font-semibold rounded-lg hover:bg-red-50 transition-colors shadow-md">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Check Out
                    </button>
                </form>
            @else
                <div class="px-6 py-3 bg-white text-green-600 font-semibold rounded-lg shadow-md">
                    ✓ Completed for today
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500 dark:bg-green-600 rounded-lg p-3">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Present Days</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['present_days'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-500 dark:bg-yellow-600 rounded-lg p-3">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Late Days</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['late_days'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-500 dark:bg-blue-600 rounded-lg p-3">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Leaves</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_leaves'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-purple-500 dark:bg-purple-600 rounded-lg p-3">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Leaves</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_leaves'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Attendance -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Attendance</h3>
        </div>
        <div class="p-6">
            @if($recentAttendances->count() > 0)
                <div class="space-y-3">
                    @foreach($recentAttendances as $attendance)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $attendance->date->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $attendance->check_in->format('h:i A') }} - {{ $attendance->check_out ? $attendance->check_out->format('h:i A') : 'Working' }}
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $attendance->status === 'present' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400' }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">No attendance records yet.</p>
            @endif
        </div>
    </div>

    <!-- Recent Leaves -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Leaves</h3>
            <a href="{{ route('employee.leaves.create') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                + Request Leave
            </a>
        </div>
        <div class="p-6">
            @if($recentLeaves->count() > 0)
                <div class="space-y-3">
                    @foreach($recentLeaves as $leave)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $leave->leaveType->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d, Y') }} ({{ $leave->days }} days)
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($leave->status === 'approved') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                                @elseif($leave->status === 'rejected') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400
                                @else bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 @endif">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">No leave requests yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
