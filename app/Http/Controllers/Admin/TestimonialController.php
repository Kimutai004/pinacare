<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $testimonials = Testimonial::with('customer')
            ->when($request->filled('filter') && $request->filter === 'pending', fn($q) => $q->where('approved', false))
            ->when($request->filled('filter') && $request->filter === 'approved', fn($q) => $q->where('approved', true))
            ->latest()
            ->paginate(10);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['approved' => true]);
        return back()->with('success','Testimonial approved.');
    }

    public function reject(Testimonial $testimonial)
    {
        $testimonial->update(['approved' => false]);
        return back()->with('success','Testimonial marked as pending.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')
            ->with('success','Testimonial deleted.');
    }
}
