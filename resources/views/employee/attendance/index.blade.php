@extends('layouts.employee')

@section('title', 'My Attendance')

@section('content')
<!-- Today's Status Card -->
@if($todayAttendance)
<div class="mb-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold mb-2">Today's Attendance</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-blue-100 text-sm">Check In</p>
                    <p class="text-xl font-bold">{{ $todayAttendance->check_in ? $todayAttendance->check_in->format('h:i A') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-blue-100 text-sm">Check Out</p>
                    <p class="text-xl font-bold">{{ $todayAttendance->check_out ? $todayAttendance->check_out->format('h:i A') : 'Not yet' }}</p>
                </div>
                <div>
                    <p class="text-blue-100 text-sm">Hours Worked</p>
                    <p class="text-xl font-bold">
                        @if($todayAttendance->check_in && $todayAttendance->check_out)
                            @php
                                $totalMinutes = abs($todayAttendance->check_out->diffInMinutes($todayAttendance->check_in));
                                $hours = floor($totalMinutes / 60);
                                $minutes = $totalMinutes % 60;
                            @endphp
                            {{ $hours }}h {{ $minutes }}m
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-blue-100 text-sm">Required Hours</p>
                    <p class="text-xl font-bold">8h 0m</p>
                </div>
            </div>
        </div>
        <div>
            <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg text-sm font-semibold">
                {{ ucfirst($todayAttendance->status) }}
            </span>
        </div>
    </div>
</div>
@endif

<div class="mb-6 flex justify-between items-center">
    <div>
        <p class="text-gray-600 dark:text-gray-400">Track your daily attendance</p>
    </div>
    <div class="flex gap-3">
        @if(!$todayAttendance)
            <form method="POST" action="{{ route('employee.attendance.check-in') }}">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Check In
                </button>
            </form>
        @elseif(!$todayAttendance->check_out)
            <form method="POST" action="{{ route('employee.attendance.check-out') }}">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Check Out
                </button>
            </form>
        @else
            <div class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg">
                ✓ Completed for today
            </div>
        @endif
    </div>
</div>

<div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Check In</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Check Out</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Hours Worked</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Required</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($attendances as $attendance)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ $attendance->date->format('M d, Y') }}
                        @if($attendance->date->isToday())
                            <span class="ml-2 px-2 py-1 text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 rounded-full">Today</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                        {{ $attendance->check_in ? $attendance->check_in->format('h:i A') : 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                        {{ $attendance->check_out ? $attendance->check_out->format('h:i A') : 'Working...' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                        @if($attendance->check_in && $attendance->check_out)
                            @php
                                $totalMinutes = abs($attendance->check_out->diffInMinutes($attendance->check_in));
                                $hours = floor($totalMinutes / 60);
                                $minutes = $totalMinutes % 60;
                            @endphp
                            {{ $hours }}h {{ $minutes }}m
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                        8h 0m
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $attendance->status === 'present' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400' }}">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        {{ $attendances->links() }}
    </div>
</div>
@endsection
