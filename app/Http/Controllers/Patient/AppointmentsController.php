<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Barangay;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentsController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * Apply middleware to ensure only authenticated, verified patients can access these methods.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:patient']);
    }

    /**
     * Display a listing of the patient's appointments.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $patient = Auth::user();

        // Fetch appointments made by the patient with related barangay and service data
        $appointments = Appointment::where('user_id', $patient->id)
            ->with(['barangay', 'service'])
            ->latest()
            ->paginate(15);

        return view('patient.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $patient = Auth::user();

        // Fetch barangays associated with the patient's region
        $barangays = Barangay::where('region_id', $patient->region_id)->get();

        // Fetch available services
        $services = Service::all();

        return view('patient.appointments.create', compact('barangays', 'services'));
    }

    /**
     * Store a newly created appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $patient = Auth::user();

        // Validate incoming data
        $validated = $request->validate([
            'barangay_id' => 'required|exists:barangays,id',
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => 'required|date|after:now',
            'details' => 'nullable|string|max:1000',
        ]);

        // Ensure the barangay belongs to the patient's region
        if (!Barangay::where('id', $validated['barangay_id'])->where('region_id', $patient->region_id)->exists()) {
            return back()->withErrors(['barangay_id' => 'Selected barangay does not belong to your region.']);
        }

        try {
            // Create the appointment
            Appointment::create([
                'user_id' => $patient->id,
                'barangay_id' => $validated['barangay_id'],
                'service_id' => $validated['service_id'],
                'scheduled_at' => $validated['scheduled_at'],
                'details' => $validated['details'],
                'status' => 'scheduled', // Default status
            ]);

            return redirect()->route('patient.appointments.index')->with('success', 'Appointment scheduled successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Appointment Scheduling Error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'There was an error scheduling your appointment. Please try again.']);
        }
    }

    /**
     * Display the specified appointment details.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\View\View
     */
    public function show(Appointment $appointment)
    {
        $patient = Auth::user();

        // Ensure the appointment belongs to the patient
        if ($appointment->user_id !== $patient->id) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->load(['barangay', 'service']);

        return view('patient.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\View\View
     */
    public function edit(Appointment $appointment)
    {
        $patient = Auth::user();

        // Ensure the appointment belongs to the patient and is not already completed or cancelled
        if ($appointment->user_id !== $patient->id || in_array($appointment->status, ['completed', 'cancelled'])) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch barangays associated with the patient's region
        $barangays = Barangay::where('region_id', $patient->region_id)->get();

        // Fetch available services
        $services = Service::all();

        return view('patient.appointments.edit', compact('appointment', 'barangays', 'services'));
    }

    /**
     * Update the specified appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Appointment $appointment) {
        $patient = Auth::user();

        // Ensure the appointment belongs to the patient and is not already completed or cancelled
        if ($appointment->user_id!== $patient->id || in_array($appointment->status, ['completed', 'cancelled'])) {
            abort(403, 'Unauthorized action.');
        }

        // Validate incoming data
        $validated = $request->validate([
            'barangay_id' => 'required|exists:barangays,id',
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => 'required|date|after:now',
            'details' => 'nullable|string|max:1000',
        ]);

        // Ensure the barangay belongs to the patient's region
        if (!Barangay::where('id', $validated['barangay_id'])->where('region_id', $patient->region_id)->exists()) {
            return back()->withErrors(['barangay_id' => 'Selected barangay does not belong to your region.']);
        }

        try {
            // Update the appointment
            $appointment->update([
                'barangay_id' => $validated['barangay_id'],
                'service_id' => $validated['service_id'],
                'scheduled_at' => $validated['scheduled_at'],
                'details' => $validated['details'], //remains unchanged unless specially updared elsewhere
            ]);

        return redirect()->route('patient.appointments.index')->with('success', 'Appointment updated successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Appointment Update Error: '. $e->getMessage());
        
        return back()->withErrors(['error' => 'There was an error updating your appointment. Please try again.']);
        }
    }

    /**
     * Cancel the specified appointment.
     *  
     * @param App\Models\Appointment $appointment
     * @return \Illuminate\Http\RedirectResponse
     */ 
    public function cancel(Appointment $appointment) {
        $patient = Auth::user();
        // Ensure the appointment belongs to the patient and is not already completed or cancelled
        if ($appointment->user_id!== $patient->id || in_array($appointment->status, ['completed', 'cancelled'])) {
            abort(403, 'Unauthorized action.');
        }
        
        try {
            // Update the appointment status to cancelled
            $appointment->update(['status' => 'cancelled']);
            
            return redirect()->route('patient.appointments.index')->with('success', 'Appointment cancelled successfully.');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Appointment Cancel Error: '. $e->getMessage());
            
            return back()->withErrors(['error' => 'There was an error cancelling your appointment. Please try again.']);
        }
    }
}