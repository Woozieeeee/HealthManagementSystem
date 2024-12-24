<?php

namespace App\Http\Controllers\Regional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Barangay;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * Apply middleware to ensure only authenticated, verified regional users can access these methods.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:regional']);
    }

    /**
     * Display a listing of appointments in the region.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $region = Auth::user()->region;

        // Fetch appointments related to the region with pagination
        $appointments = Appointment::where('regional_id', $region->id)
            ->with(['user', 'barangay', 'service'])
            ->latest()
            ->paginate(15);

        return view('regional.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch necessary data for the form, e.g., users, barangays, services
        $users = User::where('regional_id', Auth::user()->region_id)->get();
        $barangays = Barangay::where('regional_id', Auth::user()->region_id)->get();
        $services = ['Service A', 'Service B', 'Service C']; // Example services

        return view('regional.appointments.create', compact('users', 'barangays', 'services'));
    }

    /**
     * Store a newly created appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $region = Auth::user()->region;

        // Validate incoming data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'barangay_id' => 'required|exists:barangays,id',
            'service' => 'required|string|max:255',
            'scheduled_at' => 'required|date|after:now',
            'details' => 'nullable|string',
        ]);

        // Ensure the barangay belongs to the region
        if ($validated['barangay_id'] && !Barangay::where('id', $validated['barangay_id'])->where('regional_id', $region->id)->exists()) {
            return back()->withErrors(['barangay_id' => 'Selected barangay does not belong to your region.']);
        }

        // Create the appointment
        Appointment::create([
            'user_id' => $validated['user_id'],
            'barangay_id' => $validated['barangay_id'],
            'regional_id' => $region->id,
            'service' => $validated['service'],
            'scheduled_at' => $validated['scheduled_at'],
            'details' => $validated['details'],
            'status' => 'scheduled', // Default status
        ]);

        return redirect()->route('regional.appointments.index')->with('success', 'Appointment scheduled successfully.');
    }

    /**
     * Display the specified appointment.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\View\View
     */
    public function show(Appointment $appointment)
    {
        // Ensure the appointment belongs to the region
        if ($appointment->regional_id !== Auth::user()->region_id) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->load(['user', 'barangay', 'service']);

        return view('regional.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\View\View
     */
    public function edit(Appointment $appointment)
    {
        // Ensure the appointment belongs to the region
        if ($appointment->regional_id !== Auth::user()->region_id) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch necessary data for the form, e.g., users, barangays, services
        $users = User::where('regional_id', Auth::user()->region_id)->get();
        $barangays = Barangay::where('regional_id', Auth::user()->region_id)->get();
        $services = ['Service A', 'Service B', 'Service C']; // Example services

        return view('regional.appointments.edit', compact('appointment', 'users', 'barangays', 'services'));
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
        // Ensure the appointment belongs to the region
        if ($appointment->regional_id !== Auth::user()->region_id) {
            abort(403, 'Unathorized action.');
        }

        $appointment->load(['user', 'barangay', 'service']);

        return view ('regioanl.appointments.show', compact('appointments'));
    }

    /**
     * Show the form for editing the specified appointment.
     * 
     * @param \App\Models\Appointment $appointment
     * @return \Illuminate\View\View
     */
    public function edit(Appointment $appointment)
    {
        if($appointment->regional_id !== Auth::user()->region_id) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::where('regional_id', Auth::user()->region_id)->get();
        $barangays = Barangay::where('regional_id', Auth::user()->region_id)->get();
        $services = ['Service A', 'Service B', 'Service C'];

        return view('regional.appointments.edit', compact('appointment', 'users', 'barangays', 'services'));
    }

    /**
     * Update the specified appointment in storage.
     * 
     * @param \illuminate\Http\Request $request
     * @param \App\Models\Appointment @appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Appointment $appointment)
    {
        if($appointment->regional_id !== Auth::user()->region_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'barangay_id' => 'required | exists:barangays,id',
            'service' => 'required|string|max:255',
            'scheduled_at' => 'required|date|after:now',
            'details' => 'nullable|string',
            'status' => 'required|in:schedule,completed,cancelled',
        ]);
        
        // Ensure the barangay belong to the region
        if ($validated['barangay_id'] &&!Barangay::where('id', $validated['barangay_id'])->where('regional_id', Auth::user()->region_id)->exists()) {
            return back()->withErrors(['barangay_id' => 'Selected barangay does not belong to your region.']);
        }

        $appointment->update([
            'user_id' => $validated['user_id'],
            'barangay_id' => $validated['barangay_id'],
            'service' => $validated['service'],
            'scheduled_at' => $validated['scheduled_at'],
            'details' => $validated['details'],
            'status' => $validated['status'],
        ]);
        
        return redirect()->route('regional.appointments.index')->with('success', 'Appointment updated successfully.');
    }
    
    /**
     * Remove the specified appointment from storage (soft delete).
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Appointment $appointment) {
    // Ensure the appointment belongs to the region
    if($appointment->regional_id!== Auth::user()->region_id) {
        abort(403, 'Unauthorized action.');
    }
    
    $appointment->delete();
    
    return redirect()->route('regional.appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}