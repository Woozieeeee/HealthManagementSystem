<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSetting;

class SettingsController extends Controller
{
    /**
     * Toggle the dark mode setting for the authenticated user.
     */
    public function toggleDarkMode(Request $request)
    {
        $user = auth()->user();

        // Check if the user already has a setting
        $setting = $user->setting ?? new UserSetting(['user_id' => $user->id]);

        // Toggle dark mode
        $setting->dark_mode = !$setting->dark_mode;
        $setting->save();

        return back()->with('success', 'Dark mode preference updated!');
    }
}