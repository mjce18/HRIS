<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get list of users the current user has chatted with
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->map(function ($message) use ($user) {
                return $message->sender_id === $user->id ? $message->receiver : $message->sender;
            })
            ->unique('id')
            ->values();

        // Get all HR users if employee, or all employees if HR
        if ($user->hasRole('employee')) {
            $availableUsers = User::role(['hr', 'admin', 'super-admin'])->get();
        } else {
            $availableUsers = User::role('employee')->get();
        }

        return view('chat.index', compact('conversations', 'availableUsers'));
    }

    public function show($userId)
    {
        $user = auth()->user();
        $otherUser = User::findOrFail($userId);

        // Get messages between these two users
        $messages = Message::where(function ($query) use ($user, $userId) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function ($query) use ($user, $userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('receiver_id', $user->id)
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        // Get list of conversations
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->map(function ($message) use ($user) {
                return $message->sender_id === $user->id ? $message->receiver : $message->sender;
            })
            ->unique('id')
            ->values();

        // Get available users
        if ($user->hasRole('employee')) {
            $availableUsers = User::role(['hr', 'admin', 'super-admin'])->get();
        } else {
            $availableUsers = User::role('employee')->get();
        }

        return view('chat.show', compact('messages', 'otherUser', 'conversations', 'availableUsers'));
    }

    public function store(Request $request, $userId)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Message sent successfully.');
    }

    public function getUnreadCount()
    {
        $count = Message::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
