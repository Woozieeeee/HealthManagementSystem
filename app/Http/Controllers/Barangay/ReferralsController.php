<?php

namespace App\Http\Controllers\Barangay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referral;
use Illuminate\Support\Facades\Auth;

class ReferralsController extends Controller
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
     * Display a listing of referrals in the barangay.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $barangay = Auth::user()->barangay;

        // Fetch referrals related to the barangay with pagination
        $referrals = Referral::where('barangay_id', $barangay->id)
            ->with(['user', 'service'])
            ->latest()
            ->paginate(15);

        return view('barangay.referrals.index', compact('referrals'));
    }

    /**
     * Show the form for creating a new referral.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch necessary data for the form, e.g., services
        $services = ['Service A', 'Service B', 'Service C']; // Example services

        return view('barangay.referrals.create', compact('services'));
    }

    /**
     * Store a newly created referral in storage.
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
            'details' => 'nullable|string',
        ]);

        // Create the referral
        Referral::create([
            'user_id' => $validated['user_id'],
            'barangay_id' => $barangay->id,
            'service' => $validated['service'],
            'details' => $validated['details'],
        ]);

        return redirect()->route('barangay.referrals.index')->with('success', 'Referral created successfully.');
    }

    /**
     * Display the specified referral.
     *
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\View\View
     */
    public function show(Referral $referral)
    {
        // Ensure the referral belongs to the barangay
        if ($referral->barangay_id !== Auth::user()->barangay_id) {
            abort(403, 'Unauthorized action.');
        }

        $referral->load(['user', 'service']);

        return view('barangay.referrals.show', compact('referral'));
    }

    /**
     * Show the form for editing the specified referral.
     *
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\View\View
     */
    public function edit(Referral $referral)
    {
        // Ensure the referral belongs to the barangay
        if ($referral->barangay_id !== Auth::user()->barangay_id) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch necessary data for the form, e.g., services
        $services = ['Service A', 'Service B', 'Service C']; // Example services

        return view('barangay.referrals.edit', compact('referral', 'services'));
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
        // Ensure the referral belongs to the barangay
        if ($referral->barangay_id !== Auth::user()->barangay_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate incoming data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        // Update the referral
        $referral->update([
            'user_id' => $validated['user_id'],
            'service' => $validated['service'],
            'details' => $validated['details'],
        ]);

        return redirect()->route('barangay.referrals.index')->with('success', 'Referral updated successfully.');
    }

    /**
     * Remove the specified referral from storage (soft delete).
     *
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Referral $referral)
    {
        // Ensure the referral belongs to the barangay
        if ($referral->barangay_id !== Auth::user()->barangay_id) {
            abort(403, 'Unauthorized action.');
        }

        $referral->delete(); // Soft delete the referral

        return redirect()->route('barangay.referrals.index')->with('success', 'Referral deleted successfully.');
    }
}