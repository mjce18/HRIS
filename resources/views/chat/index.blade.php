@extends(auth()->user()->hasRole('employee') ? 'layouts.employee' : 'layouts.app')

@section('title', 'Messages')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Messages</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Chat with {{ auth()->user()->hasRole('employee') ? 'HR team' : 'employees' }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Conversations -->
        @if($conversations->count() > 0)
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                <h3 class="font-semibold text-gray-900 dark:text-white">Recent Conversations</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($conversations as $user)
                    <a href="{{ route('chat.show', $user->id) }}" 
                       class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-semibold text-lg">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <!-- Online Status Indicator -->
                                @if($user->isOnline())
                                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                @elseif($user->getOnlineStatus() === 'away')
                                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-yellow-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                @else
                                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-gray-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $user->name }}
                                    </p>
                                    @if($user->isOnline())
                                        <span class="text-xs text-green-600 dark:text-green-400 font-medium">Online</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {{ $user->email }}
                                </p>
                                @if($user->employee_id)
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        ID: {{ $user->employee_id }}
                                    </p>
                                @endif
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Available Users to Chat -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                <h3 class="font-semibold text-gray-900 dark:text-white">
                    {{ auth()->user()->hasRole('employee') ? 'HR Team' : 'Employees' }}
                </h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-96 overflow-y-auto">
                @forelse($availableUsers as $user)
                    <a href="{{ route('chat.show', $user->id) }}" 
                       class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center text-white font-semibold text-lg">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <!-- Online Status Indicator -->
                                @if($user->isOnline())
                                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                @elseif($user->getOnlineStatus() === 'away')
                                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-yellow-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                @else
                                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-gray-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $user->name }}
                                    </p>
                                    @if($user->isOnline())
                                        <span class="text-xs text-green-600 dark:text-green-400 font-medium">Online</span>
                                    @elseif($user->getOnlineStatus() === 'away')
                                        <span class="text-xs text-yellow-600 dark:text-yellow-400 font-medium">Away</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {{ $user->email }}
                                </p>
                                @if($user->employee_id)
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        ID: {{ $user->employee_id }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Chat</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No users available</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">There are no users to chat with at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Empty State if no conversations -->
    @if($conversations->count() == 0)
    <div class="mt-6 bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
        <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No conversations yet</h3>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Start a conversation by selecting a user from the {{ auth()->user()->hasRole('employee') ? 'HR Team' : 'Employees' }} list.
        </p>
    </div>
    @endif
</div>
@endsection
