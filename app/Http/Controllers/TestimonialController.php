<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $testimonial = Testimonial::create($request->only([
            'customer_id','content','rating'
        ]));

        return response()->json($testimonial, 201);
    }

    public function index()
    {
        return response()->json(Testimonial::where('approved', true)->get());
    }

    public function approve($id)
    {
        // Admin only
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['approved' => true]);
        return response()->json($testimonial);
    }
}
