<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use App\Notifications\SystemNotification;

class NotificationController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * Apply middleware to ensure only authenticated, verified admins can access these methods.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:admin']);
    }

    /**
     * Display a listing of notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = Notification::latest()->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new notification.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch roles or user groups for targeting notifications
        $roles = Role::all();

        return view('notifications.create', compact('roles'));
    }

    /**
     * Store a newly created notification in storage and send it to targeted users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target_role' => 'required|exists:roles,name',
        ]);

        // Create the notification record
        $notification = Notification::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'target_role' => $validated['target_role'],
            'sent_at' => now(),
        ]);

        // Fetch users based on the target role
        $users = User::whereHas('role', function($query) use ($validated) {
            $query->where('name', $validated['target_role']);
        })->get();

        // Send notifications
        FacadesNotification::send($users, new SystemNotification($notification));

        return redirect()->route('notifications.index')->with('success', 'Notification sent successfully.');
    }

    /**
     * Display the specified notification details.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\View\View
     */
    public function show(Notification $notification)
    {
        return view('notifications.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified notification.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\View\View
     */
    public function edit(Notification $notification)
    {
        // Fetch roles or user groups for targeting notifications
        $roles = Role::all();

        return view('notifications.edit', compact('notification', 'roles'));
    }

    /**
     * Update the specified notification in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Notification $notification)
    {
        // Validate incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target_role' => 'required|exists:roles,name',
        ]);

        // Update the notification record
        $notification->update([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'target_role' => $validated['target_role'],
        ]);

        return redirect()->route('notifications.index')->with('success', 'Notification updated successfully.');
    }

    /**
     * Remove the specified notification from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notification deleted successfully.');
    }
}
