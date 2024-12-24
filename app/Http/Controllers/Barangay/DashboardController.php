<?php

namespace App\Http\Controllers\Barangay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Referral;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
     * Display the Barangay dashboard with localized metrics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $barangay = Auth::user()->barangay;

        // Total users in this barangay
        $totalUsers = User::where('barangay_id', $barangay->id)->count();

        // Total referrals in this barangay
        $totalReferrals = Referral::where('barangay_id', $barangay->id)->count();

        // Total appointments in this barangay
        $totalAppointments = Appointment::where('barangay_id', $barangay->id)->count();

        // Recent users in this barangay
        $recentUsers = User::where('barangay_id', $barangay->id)->latest()->take(5)->get();

        // Recent referrals in this barangay
        $recentReferrals = Referral::where('barangay_id', $barangay->id)->latest()->take(5)->get();

        // Recent appointments in this barangay
        $recentAppointments = Appointment::where('barangay_id', $barangay->id)->latest()->take(5)->get();

        return view('barangay.dashboard', compact(
            'totalUsers',
            'totalReferrals',
            'totalAppointments',
            'recentUsers',
            'recentReferrals',
            'recentAppointments'
        ));
    }
}
