<?php

namespace App\Http\Controllers\Regional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Referral;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
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
     * Display the map with referrals and appointments data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $region = Auth::user()->region;

        // Fetch referrals within the region with location data
        $referrals = Referral::where('regional_id', $region->id)
            ->with(['barangay'])
            ->get();

        // Fetch appointments within the region with location data
        $appointments = Appointment::where('regional_id', $region->id)
            ->with(['barangay'])
            ->get();

        // Prepare data for the map (e.g., coordinates)
        $mapData = [
            'referrals' => $referrals->map(function($referral) {
                return [
                    'name' => $referral->service,
                    'coordinates' => [
                        $referral->barangay->latitude,
                        $referral->barangay->longitude
                    ],
                    'details' => $referral->details,
                ];
            }),
            'appointments' => $appointments->map(function($appointment) {
                return [
                    'name' => $appointment->service,
                    'coordinates' => [
                        $appointment->barangay->latitude,
                        $appointment->barangay->longitude
                    ],
                    'details' => $appointment->details,
                ];
            }),
        ];

        return view('regional.map.index', compact('mapData'));
    }
}