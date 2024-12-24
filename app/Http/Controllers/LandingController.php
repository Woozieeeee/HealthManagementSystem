<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Faq;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $testimonials = Testimonial::where('status', 'approved')->latest()->take(5)->get();
        $faqs = Faq::where('status', 'published')->latest()->take(10)->get();

        return view('landing.index', compact('testimonials', 'faqs'));
    }
}