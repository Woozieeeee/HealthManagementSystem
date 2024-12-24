<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referral;
use Illuminate\Support\Facades\Auth;

class ReferralsController extends Controller
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
     * Display a listing of the patient's referrals.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $patient = Auth::user();

        // Fetch referrals made by the patient with pagination
        $referrals = Referral::where('user_id', $patient->id)
            ->with(['barangay', 'service'])
            ->latest()
            ->paginate(15);

        return view('patient.referrals.index', compact('referrals'));
    }

    /**
     * Show the form for creating a new referral.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch necessary data for the form, e.g., barangays, services
        $barangays = Auth::user()->barangay ? [Auth::user()->barangay] : [];
        $services = ['Service A', 'Service B', 'Service C']; // Example services

        return view('patient.referrals.create', compact('barangays', 'services'));
    }

    /**
     * Store a newly created referral in storage.
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
            'service' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        // Create the referral
        Referral::create([
            'user_id' => $patient->id,
            'barangay_id' => $validated['barangay_id'],
            'service' => $validated['service'],
            'details' => $validated['details'],
        ]);

        return redirect()->route('patient.referrals.index')->with('success', 'Referral created successfully.');
    }

    /**
     * Display the specified referral.
     *
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\View\View
     */
    public function show(Referral $referral)
    {
        $patient = Auth::user();

        // Ensure the referral belongs to the patient
        if ($referral->user_id !== $patient->id) {
            abort(403, 'Unauthorized action.');
        }

        $referral->load(['barangay', 'service']);

        return view('patient.referrals.show', compact('referral'));
    }

    /**
     * Show the form for editing the specified referral.
     *
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\View\View
     */
    public function edit(Referral $referral)
    {
        $patient = Auth::user();

        // Ensure the referral belongs to the patient
        if ($referral->user_id !== $patient->id) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch necessary data for the form, e.g., barangays, services
        $barangays = Auth::user()->barangay ? [Auth::user()->barangay] : [];
        $services = ['Service A', 'Service B', 'Service C']; // Example services

        return view('patient.referrals.edit', compact('referral', 'barangays', 'services'));
    }

    /**
     * Update the specified referral in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Referral $referral)
    {
        $patient = Auth::user();

        // Ensure the referral belongs to the patient
        if ($referral->user_id !== $patient->id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate incoming data
        $validated = $request->validate([
            'barangay_id' => 'required|exists:barangays,id',
            'service' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        // Update the referral
        $referral->update([
            'barangay_id' => $validated['barangay_id'],
            'service' => $validated['service'],
            'details' => $validated['details'],
        ]);

        return redirect()->route('patient.referrals.index')->with('success', 'Referral updated successfully.');
    }

    /**
     * Remove the specified referral from storage (soft delete).
     *
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Referral $referral)
    {
        $patient = Auth::user();

        // Ensure the referral belongs to the patient
        if ($referral->user_id!== $patient->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $referral->delete();// Soft delete the referral

        return redirect()->route('patient.referrals.index')->with('success', 'Referral deleted successfully.');
    }
}