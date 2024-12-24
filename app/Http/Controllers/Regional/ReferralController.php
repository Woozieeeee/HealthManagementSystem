<?php

namespace App\Http\Controllers\Regional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referral;
use App\Models\User;
use App\Models\Barangay;
use Illuminate\Support\Facades\Auth;

class ReferralsController extends Controller
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
     * Display a listing of referrals in the region.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $region = Auth::user()->region;

        // Fetch referrals related to the region with pagination
        $referrals = Referral::where('regional_id', $region->id)
            ->with(['user', 'barangay', 'service'])
            ->latest()
            ->paginate(15);

        return view('regional.referrals.index', compact('referrals'));
    }

    /**
     * Show the form for creating a new referral.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch necessary data for the form, e.g., users, barangays, services
        $users = User::where('regional_id', Auth::user()->region_id)->get();
        $barangays = Barangay::where('regional_id', Auth::user()->region_id)->get();
        $services = ['Service A', 'Service B', 'Service C']; // Example services

        return view('regional.referrals.create', compact('users', 'barangays', 'services'));
    }

    /**
     * Store a newly created referral in storage.
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
            'details' => 'nullable|string',
        ]);

        // Ensure the barangay belongs to the region
        if ($validated['barangay_id'] && !Barangay::where('id', $validated['barangay_id'])->where('regional_id', $region->id)->exists()) {
            return back()->withErrors(['barangay_id' => 'Selected barangay does not belong to your region.']);
        }

        // Create the referral
        Referral::create([
            'user_id' => $validated['user_id'],
            'barangay_id' => $validated['barangay_id'],
            'regional_id' => $region->id,
            'service' => $validated['service'],
            'details' => $validated['details'],
        ]);

        return redirect()->route('regional.referrals.index')->with('success', 'Referral created successfully.');
    }

    /**
     * Display the specified referral.
     *
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\View\View
     */
    public function show(Referral $referral)
    {
        // Ensure the referral belongs to the region
        if ($referral->regional_id !== Auth::user()->region_id) {
            abort(403, 'Unauthorized action.');
        }

        $referral->load(['user', 'barangay', 'service']);

        return view('regional.referrals.show', compact('referral'));
    }

    /**
     * Show the form for editing the specified referral.
     *
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\View\View
     */
    public function edit(Referral $referral)
    {
        // Ensure the referral belongs to the region
        if ($referral->regional_id !== Auth::user()->region_id) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch necessary data for the form, e.g., users, barangays, services
        $users = User::where('regional_id', Auth::user()->region_id)->get();
        $barangays = Barangay::where('regional_id', Auth::user()->region_id)->get();
        $services = ['Service A', 'Service B', 'Service C']; // Example services

        return view('regional.referrals.edit', compact('referral', 'users', 'barangays', 'services'));
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
        // Ensure the referral belongs to the region
        if ($referral->regional_id !== Auth::user()->region_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate incoming data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'barangay_id' => 'required|exists:barangays,id',
            'service' => 'required|string|max:255',
            'details'  => 'nullable|string',
        ]);

        if ($validated['barangay_id'] && !Barangay::where('id', $validated['barangay_id'])->where('regional_id', Auth::user()->region_id)->exists()) {
            return back()->withErrors(['barangay_id' => 'Selected barangay does not belong to your region.']);
        }

        $referral->update([
            'user_id' => $validated['user_id'],
            'barangay_id' => $validated['barangay_id'],
            'service' => $validated['service'],
            'details' => $validated['details'],
        ]);

        return redirect()->route('regional.referrals.index')->wtih('success', 'Referral updated successfully');
    }

    /**
     * Remove the specified referral from storage(soft delete).
     * 
     * @param \App\Models\Referral $referral
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Referral $referral) {
        // Ensure the referral belongs to the region
        if($referral->regional_id !== Auth::user()->region_id) {
            abort(403, 'Unauthorized action.');
        }

        $referral->delete(); //Soft delete the referral
        
        return redirect()->route('regional.referrals.index')->with('success', 'Referral deleted successfully.');
    }
}
