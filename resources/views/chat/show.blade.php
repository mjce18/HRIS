@extends(auth()->user()->hasRole('employee') ? 'layouts.employee' : 'layouts.app')

@section('title', 'Chat with ' . $otherUser->name)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden" style="height: calc(100vh - 200px);">
        <div class="flex h-full">
            <!-- Conversations List -->
            <div class="w-1/3 border-r border-gray-200 dark:border-gray-700 overflow-y-auto">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Messages</h3>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($conversations as $conv)
                        <a href="{{ route('chat.show', $conv->id) }}" 
                           class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ $conv->id == $otherUser->id ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    @if($conv->profile_picture)
                                        <img src="{{ asset('storage/' . $conv->profile_picture) }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                            {{ substr($conv->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <!-- Online Status Indicator -->
                                    @if($conv->isOnline())
                                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $conv->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        @if($conv->isOnline())
                                            <span class="text-green-600 dark:text-green-400">Online</span>
                                        @else
                                            {{ $conv->email }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="p-4 text-sm text-gray-500 dark:text-gray-400">No conversations yet</p>
                    @endforelse
                </div>
                
                <!-- Available Users -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Start New Chat</h4>
                    <div class="space-y-2">
                        @foreach($availableUsers as $user)
                            @if(!$conversations->contains('id', $user->id))
                                <a href="{{ route('chat.show', $user->id) }}" class="block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $user->name }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="flex-1 flex flex-col">
                <!-- Chat Header -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            @if($otherUser->profile_picture)
                                <img src="{{ asset('storage/' . $otherUser->profile_picture) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ substr($otherUser->name, 0, 1) }}
                                </div>
                            @endif
                            <!-- Online Status Indicator -->
                            @if($otherUser->isOnline())
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full"></span>
                            @elseif($otherUser->getOnlineStatus() === 'away')
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-yellow-500 border-2 border-white dark:border-gray-900 rounded-full"></span>
                            @else
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-gray-400 border-2 border-white dark:border-gray-900 rounded-full"></span>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $otherUser->name }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                @if($otherUser->isOnline())
                                    <span class="text-green-600 dark:text-green-400">● Online</span>
                                @elseif($otherUser->getOnlineStatus() === 'away')
                                    <span class="text-yellow-600 dark:text-yellow-400">● Away</span>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">Last seen {{ $otherUser->getLastSeenFormatted() }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
                    @forelse($messages as $message)
                        <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="flex items-end space-x-2 {{ $message->sender_id == auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                                    @if($message->sender->profile_picture)
                                        <img src="{{ asset('storage/' . $message->sender->profile_picture) }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center text-white text-xs font-semibold">
                                            {{ substr($message->sender->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="px-4 py-2 rounded-lg {{ $message->sender_id == auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' }}">
                                            <p class="text-sm">{{ $message->message }}</p>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 {{ $message->sender_id == auth()->id() ? 'text-right' : '' }}">
                                            {{ $message->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400">No messages yet. Start the conversation!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Message Input -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                    <form method="POST" action="{{ route('chat.store', $otherUser->id) }}" class="flex space-x-3">
                        @csrf
                        <input type="text" name="message" placeholder="Type your message..." required
                               class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-scroll to bottom of messages
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('messages-container');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
});
</script>
@endsection
