<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQ;
use Illuminate\Support\Facades\Auth;

class FAQController extends Controller
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
     * Display a listing of FAQs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $faqs = FAQ::latest()->paginate(15);

        return view('faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new FAQ.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('faqs.create');
    }

    /**
     * Store a newly created FAQ in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        // Create the FAQ
        FAQ::create($validated);

        return redirect()->route('faqs.index')->with('success', 'FAQ created successfully.');
    }

    /**
     * Display the specified FAQ.
     *
     * @param  \App\Models\FAQ  $faq
     * @return \Illuminate\View\View
     */
    public function show(FAQ $faq)
    {
        return view('faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified FAQ.
     *
     * @param  \App\Models\FAQ  $faq
     * @return \Illuminate\View\View
     */
    public function edit(FAQ $faq)
    {
        return view('faqs.edit', compact('faq'));
    }

    /**
     * Update the specified FAQ in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FAQ  $faq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, FAQ $faq)
    {
        // Validate incoming data
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        // Update the FAQ
        $faq->update($validated);

        return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified FAQ from storage.
     *
     * @param  \App\Models\FAQ  $faq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(FAQ $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')->with('success', 'FAQ deleted successfully.');
    }
}
