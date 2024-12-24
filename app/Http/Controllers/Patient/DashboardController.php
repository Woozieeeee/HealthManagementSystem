<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referral;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
     * Display the Patient dashboard with personalized metrics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $patient = Auth::user();

        // Total referrals made by the patient
        $totalReferrals = Referral::where('user_id', $patient->id)->count();

        // Total appointments scheduled by the patient
        $totalAppointments = Appointment::where('user_id', $patient->id)->count();

        // Recent referrals made by the patient
        $recentReferrals = Referral::where('user_id', $patient->id)->latest()->take(5)->get();

        // Recent appointments made by the patient
        $recentAppointments = Appointment::where('user_id', $patient->id)->latest()->take(5)->get();

        return view('patient.dashboard', compact(
            'totalReferrals',
            'totalAppointments',
            'recentReferrals',
            'recentAppointments'
        ));
    }
}
