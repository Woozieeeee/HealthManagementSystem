<?php

namespace App\Http\Controllers\Regional;

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
     * Apply middleware to ensure only authenticated, verified regional users can access these methods.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:regional']);
    }

    /**
     * Display the Regional dashboard with localized metrics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $region = Auth::user()->region;

        // Total users in this region
        $totalUsers = User::where('regional_id', $region->id)->count();

        // Total referrals in this region
        $totalReferrals = Referral::where('regional_id', $region->id)->count();

        // Total appointments in this region
        $totalAppointments = Appointment::where('regional_id', $region->id)->count();

        // Recent users in this region
        $recentUsers = User::where('regional_id', $region->id)->latest()->take(5)->get();

        // Recent referrals in this region
        $recentReferrals = Referral::where('regional_id', $region->id)->latest()->take(5)->get();

        // Recent appointments in this region
        $recentAppointments = Appointment::where('regional_id', $region->id)->latest()->take(5)->get();

        return view('regional.dashboard', compact(
            'totalUsers',
            'totalReferrals',
            'totalAppointments',
            'recentUsers',
            'recentReferrals',
            'recentAppointments'
        ));
    }
}