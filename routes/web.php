<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use app\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use app\Http\Controllers\Auth\ResetPasswordController;
use app\Http\Controllers\Auth\VerificationController;
use app\Http\Controllers\Admin\ActivityLogsController;
use app\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController;
use app\Http\Controllers\Admin\ManageUsersController;
use app\Http\Controllers\Barangay\AppointmentsController as BarangayAppointmentsController;
use app\Http\Controllers\Barangay\DashboardController as BarangayDashboardController;
use app\Http\Controllers\Barangay\ReferralsController as BarangayReferralsController;
use app\Http\Controllers\Patient\AppointmentsController as PatientAppointmentsController;
use app\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use app\Http\Controllers\Patient\ReferralsController as PatientReferralsController;
use app\Http\Controllers\Regional\AppointmentsController as RegionalAppointmentsController;
use app\Http\Controllers\Regional\DashboardController as RegionalDashboardController;
use app\Http\Controllers\Regional\MapController as RegionalMapController;
use app\http\Controllers\Regional\ReferralsController as RegionalReferralsController;
use App\Http\Controllers\FAQController;
use app\http\Controllers\NotificationController;
use app\Http\Controllers\PaymentController;
use app\http\Controllers\SettingsController;
use Illuminate\Support\Facades\Mail;

// =====================================
// Public Routes
// =====================================
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');

// =====================================
// Authentication Routes
// =====================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/email/verify', [VerificationController::class, 'show'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->middleware('auth')->name('verification.resend');

// =====================================
// Localization
// =====================================
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'tl'])) {
        session(['locale' => $locale]);
        App::setLocale($locale);
    }
    return back();
})->name('lang.switch');

// =====================================
// Admin Routes
// =====================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/users', ManageUsersController::class);
    Route::get('/admin/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics');
    Route::get('/admin/logs', [ActivityLogsController::class, 'index'])->name('admin.logs');
});

// =====================================
// Barangay Routes
// =====================================
Route::middleware(['auth', 'role:barangay_staff'])->group(function () {
    Route::get('/barangay/dashboard', [BarangayDashboardController::class, 'index'])->name('barangay.dashboard');
    Route::resource('/barangay/referrals', BarangayReferralsController::class);
    Route::resource('/barangay/appointments', BarangayAppointmentsController::class);
});

// =====================================
// Regional Routes
// =====================================
Route::middleware(['auth', 'role:regional_staff'])->group(function () {
    Route::get('/regional/dashboard', [RegionalDashboardController::class, 'index'])->name('regional.dashboard');
    Route::resource('/regional/referrals', RegionalReferralsController::class);
    Route::get('/regional/map', [RegionalMapController::class, 'index'])->name('regional.map');
    Route::resource('/regional/appointments', RegionalAppointmentsController::class);
});

// =====================================
// Patient Routes
// =====================================

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
    Route::resource('/patient/referrals', PatientReferralsController::class);
    Route::resource('/patient/appointments', PatientAppointmentsController::class);
});

// =====================================
// Additional Features
// =====================================
Route::middleware('auth')->group(function () {

    // Testimonials (Submission and Approval)
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::post('/testimonials/{id}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');

    // Settings (Dark Mode)
    Route::post('/settings/dark-mode', [SettingsController::class, 'toggleDarkMode'])->name('settings.toggleDarkMode');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Payments
    Route::get('/payments/process/{referral}', [PaymentController::class, 'process'])->name('payments.process');
    Route::post('/payments/process/{referral', [PaymentController::class, 'complete'])->name('payments.complete');

});



Route::get('/test-mail', function () {
    try {
        // Send a test email
        Mail::raw('This is a test email from HealthLink.', function ($message) {
            $message->to('mechtitan23@gmail.com') // Replace with your email address
                    ->subject('Test Email from HealthLink');
        });

        return response()->json(['message' => 'Test email sent successfully!']);
    } catch (\Exception $e) {
        // Catch and display errors
        return response()->json(['error' => 'Error sending email: ' . $e->getMessage()], 500);
    }
});