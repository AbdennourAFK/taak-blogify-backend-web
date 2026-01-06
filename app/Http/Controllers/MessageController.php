<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Display the inbox for the authenticated user.
     */
    public function index(): View
    {
        $user = auth()->user();

        // Get all unique users the current user has conversations with
        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })
        ->with(['sender', 'receiver'])
        ->latest()
        ->get();

        $conversations = collect();

        if ($messages->count() > 0) {
            $conversations = $messages
                ->groupBy(function ($message) use ($user) {
                    return $message->sender_id === $user->id 
                        ? $message->receiver_id 
                        : $message->sender_id;
                })
                ->map(function ($messageGroup) use ($user) {
                    $firstMessage = $messageGroup->first();
                    
                    if (!$firstMessage) {
                        return null;
                    }
                    
                    $otherUserId = $firstMessage->sender_id === $user->id 
                        ? $firstMessage->receiver_id 
                        : $firstMessage->sender_id;
                    
                    $otherUser = User::find($otherUserId);
                    
                    if (!$otherUser) {
                        return null;
                    }
                    
                    return [
                        'user' => $otherUser,
                        'last_message' => $firstMessage,
                        'unread_count' => $messageGroup->where('receiver_id', $user->id)->count(),
                    ];
                })
                ->filter() // Remove null entries
                ->sortByDesc(function ($conversation) {
                    return $conversation['last_message']->created_at;
                })
                ->values();
        }

        return view('messages.index', compact('conversations'));
    }

    /**
     * Display conversation with a specific user.
     */
    public function show(User $user): View
    {
        $currentUser = auth()->user();

        if ($currentUser->id === $user->id) {
            abort(403, 'You cannot message yourself.');
        }

        $messages = Message::where(function ($query) use ($currentUser, $user) {
            $query->where(function ($q) use ($currentUser, $user) {
                $q->where('sender_id', $currentUser->id)
                  ->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($currentUser, $user) {
                $q->where('sender_id', $user->id)
                  ->where('receiver_id', $currentUser->id);
            });
        })
        ->with(['sender', 'receiver'])
        ->latest()
        ->paginate(20);

        return view('messages.show', compact('user', 'messages'));
    }

    /**
     * Store a new message.
     */
    public function store(StoreMessageRequest $request, User $user): RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser->id === $user->id) {
            return redirect()->back()->withErrors(['message' => 'You cannot message yourself.']);
        }

        Message::create([
            'sender_id' => $currentUser->id,
            'receiver_id' => $user->id,
            'content' => $request->validated()['content'],
        ]);

        return redirect()->back()->with('status', 'Message sent successfully.');
    }
}
