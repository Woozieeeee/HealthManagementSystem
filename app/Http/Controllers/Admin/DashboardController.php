<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Referral;
use App\Models\Appointment;

class DashboardController extends Controller
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
     * Display the admin dashboard with key metrics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Total number of users
        $totalUsers = User::count();

        // Total number of referrals
        $totalReferrals = Referral::count();

        // Total number of appointments
        $totalAppointments = Appointment::count();

        // Recent user registrations (last 5)
        $recentUsers = User::latest()->take(5)->get();

        // Recent referrals (last 5)
        $recentReferrals = Referral::latest()->take(5)->get();

        // Recent appointments (last 5)
        $recentAppointments = Appointment::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalReferrals',
            'totalAppointments',
            'recentUsers',
            'recentReferrals',
            'recentAppointments'
        ));
    }
}