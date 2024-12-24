<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of testimonials.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $testimonials = Testimonial::where('status', 'approved')->latest()->get();

        return view('landing.testimonials', compact('testimonials'));
    }

    /**
     * Store a new testimonial.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string|max:1000',
        ]);

        Testimonial::create([
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'status' => 'pending', // Default status
        ]);

        return back()->with('success', 'Thank you for your feedback! Your testimonial is under review.');
    }

    /**
     * Approve a testimonial (Admin only).
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['status' => 'approved']);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial approved successfully.');
    }

    /**
     * Delete a testimonial (Admin only).
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted successfully.');
    }
}