<?php

namespace App\Http\Controllers\Barangay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * Apply middleware to ensure only authenticated, verified barangay users can access these methods.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:barangay']);
    }

    /**
     * Display a listing of appointments in the barangay.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $barangay = Auth::user()->barangay;

        // Fetch appointments related to the barangay with pagination
        $appointments = Appointment::where('barangay_id', $barangay->id)
            ->with(['user', 'service'])
            ->latest()
            ->paginate(15);

        return view('barangay.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch necessary data for the form, e.g., users, services
        $users = User::where('barangay_id', Auth::user()->barangay_id)->get();
        $services = ['Service A', 'Service B', 'Service C']; // Example services

        return view('barangay.appointments.create', compact('users', 'services'));
    }

    /**
     * Store a newly created appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $barangay = Auth::user()->barangay;

        // Validate incoming data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service' => 'required|string|max:255',
            'scheduled_at' => 'required|date|after:now',
            'details' => 'nullable|string',
        ]);

        // Create the appointment
        Appointment::create([
            'user_id' => $validated['user_id'],
            'barangay_id' => $barangay->id,
            'service' => $validated['service'],
            'scheduled_at' => $validated['scheduled_at'],
            'details' => $validated['details'],
            'status' => 'scheduled', // Default status
        ]);

        return redirect()->route('barangay.appointments.index')->with('success', 'Appointment scheduled successfully.');
    }

    /**
     * Display the specified appointment.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\View\View
     */
    public function show(Appointment $appointment)
    {
        // Ensure the appointment belongs to the barangay
        if ($appointment->barangay_id !== Auth::user()->barangay_id) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->load(['user', 'service']);

        return view('barangay.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\View\View
     */
    public function edit(Appointment $appointment)
    {
        // Ensure the appointment belongs to the barangay
        if ($appointment->barangay_id !== Auth::user()->barangay_id) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch necessary data for the form, e.g., users, services
        $users = User::where('barangay_id', Auth::user()->barangay_id)->get();
        $services = ['Service A', 'Service B', 'Service C']; // Example services

        return view('barangay.appointments.edit', compact('appointment', 'users', 'services'));
    }

    /**
     * Update the specified appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Appointment $appointment)
    {
        // Ensure the appointment belongs to the barangay
        if ($appointment->barangay_id !== Auth::user()->barangay_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate incoming data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service' => 'required|string|max:255',
            'scheduled_at' => 'required|date|after:now',
            'details' => 'nullable|string',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        // Update the appointment
        $appointment->update([
            'user_id' => $validated['user_id'],
            'service' => $validated['service'],
            'scheduled_at' => $validated['scheduled_at'],
            'details' => $validated['details'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('barangay.appointments.index')->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified appointment from storage(soft delete).
     * 
     * @param \App\Models\Appointment $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Appointment $appointment){
        if ($appointment->barangay_id) {
            abort(403, 'Unauthorized action.');
        }
        $appointment->delete();

        return redirect()->route('barangay.appointment.index')->with('success', 'Appointment deleted successfully.');
    }
}