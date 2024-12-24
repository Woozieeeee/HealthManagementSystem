<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Referral;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
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
     * Display analytics dashboard with various charts and statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Users Growth Over Time (Monthly)
        $usersGrowth = User::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Referrals by Type
        $referralsByType = Referral::select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->get();

        // Appointments Scheduled vs Completed
        $appointmentsStatus = Appointment::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Average Appointments per User
        $averageAppointments = Appointment::select(DB::raw('AVG(appointments_count) as average'))
            ->from(function($query) {
                $query->select('user_id', DB::raw('COUNT(*) as appointments_count'))
                    ->from('appointments')
                    ->groupBy('user_id');
            }, 'sub')
            ->value('average');

        // Latest Referrals
        $latestReferrals = Referral::with(['user', 'service'])
            ->latest()
            ->take(10)
            ->get();

        // Latest Appointments
        $latestAppointments = Appointment::with(['user', 'service'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.analytics.index', compact(
            'usersGrowth',
            'referralsByType',
            'appointmentsStatus',
            'averageAppointments',
            'latestReferrals',
            'latestAppointments'
        ));
    }
}