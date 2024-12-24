<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * Apply middleware to ensure only authenticated and verified users can access these methods.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the payment form for a specific appointment.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\View\View
     */
    public function showPaymentForm(Appointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated user
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the appointment already has a payment
        if ($appointment->payment) {
            return redirect()->route('payments.status', $appointment->payment->id)->with('info', 'Payment already made for this appointment.');
        }

        return view('payments.form', compact('appointment'));
    }

    /**
     * Process the payment for a specific appointment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processPayment(Request $request, Appointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated user
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the appointment already has a payment
        if ($appointment->payment) {
            return redirect()->route('payments.status', $appointment->payment->id)->with('info', 'Payment already made for this appointment.');
        }

        // Validate payment data
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
            'transaction_id' => 'required|string|max:255|unique:payments,transaction_id',
        ]);

        // Process the payment (This is a placeholder. Integrate with payment gateways as needed.)
        try {
            // Simulate payment processing logic
            // In real implementation, integrate with a payment gateway API here

            // Create the payment record
            $payment = Payment::create([
                'appointment_id' => $appointment->id,
                'user_id' => Auth::id(),
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'transaction_id' => $validated['transaction_id'],
                'status' => 'completed', // Assuming payment is successful
            ]);

            // Update appointment status if necessary
            $appointment->update(['status' => 'paid']);

            return redirect()->route('payments.status', $payment->id)->with('success', 'Payment processed successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Payment Processing Error: ' . $e->getMessage());

            return back()->withErrors(['payment_error' => 'There was an error processing your payment. Please try again.']);
        }
    }

    /**
     * Display the payment status and details.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\View\View
     */
    public function paymentStatus(Payment $payment)
    {
        // Ensure the payment belongs to the authenticated user
        if ($payment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $payment->load(['appointment']);

        return view('payments.status', compact('payment'));
    }
}
