<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * Apply middleware to ensure only authenticated and verified users can access these methods.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of received messages.
     *
     * @return \Illuminate\View\View
     */
    public function inbox()
    {
        $user = Auth::user();

        // Fetch received messages with sender data
        $messages = Message::where('receiver_id', $user->id)
            ->with('sender')
            ->latest()
            ->paginate(15);

        return view('messages.inbox', compact('messages'));
    }

    /**
     * Display a listing of sent messages.
     *
     * @return \Illuminate\View\View
     */
    public function sent()
    {
        $user = Auth::user();

        // Fetch sent messages with receiver data
        $messages = Message::where('sender_id', $user->id)
            ->with('receiver')
            ->latest()
            ->paginate(15);

        return view('messages.sent', compact('messages'));
    }

    /**
     * Show the form for composing a new message.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch all users to select the receiver
        $users = User::where('id', '!=', Auth::id())->get();

        return view('messages.create', compact('users'));
    }

    /**
     * Store a newly composed message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $sender = Auth::user();

        // Validate incoming data
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Prevent sending messages to self
        if ($validated['receiver_id'] == $sender->id) {
            return back()->withErrors(['receiver_id' => 'You cannot send messages to yourself.']);
        }

        // Create the message
        Message::create([
            'sender_id' => $sender->id,
            'receiver_id' => $validated['receiver_id'],
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'read_at' => null,
        ]);

        return redirect()->route('messages.sent')->with('success', 'Message sent successfully.');
    }

    /**
     * Display the specified message.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\View\View
     */
    public function show(Message $message)
    {
        $user = Auth::user();

        // Ensure the user is either the sender or receiver
        if ($message->sender_id !== $user->id && $message->receiver_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Mark the message as read if the user is the receiver and it hasn't been read yet
        if ($message->receiver_id === $user->id && is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
        }

        $message->load(['sender', 'receiver']);

        return view('messages.show', compact('message'));
    }

    /**
     * Remove the specified message from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Message $message)
    {
        $user = Auth::user();

        // Ensure the user is either the sender or receiver
        if ($message->sender_id !== $user->id && $message->receiver_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $message->delete();

        return back()->with('success', 'Message deleted successfully.');
    }
}
