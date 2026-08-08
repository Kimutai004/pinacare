<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\ImpactMetric;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    /**
     * Homepage: hero, highlights, featured products, impact counter, testimonials.
     */
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)->take(8)->get();
        $impact = ImpactMetric::latest()->first();
        $testimonials = Testimonial::where('approved', true)->with('customer')->latest()->take(3)->get();
        $posts = BlogPost::whereNotNull('published_at')->latest()->take(3)->get();
        $productsByCat = [
            'diaper' => Product::where('is_active', true)->where('category', 'diaper')->count(),
            'wipe' => Product::where('is_active', true)->where('category', 'wipe')->count(),
            'bundle' => Product::where('is_active', true)->where('category', 'bundle')->count(),
        ];

        return view('storefront.index', compact('featuredProducts', 'impact', 'testimonials', 'posts', 'productsByCat'));
    }

    /**
     * About Us page.
     */
    public function about()
    {
        return view('storefront.about');
    }

    /**
     * Impact page.
     */
    public function impact()
    {
        $impact = ImpactMetric::latest()->first();
        $metrics = ImpactMetric::latest()->take(6)->get();

        return view('storefront.impact', compact('impact', 'metrics'));
    }

    /**
     * Community page: blog posts, testimonials, newsletter.
     */
    public function community()
    {
        $posts = BlogPost::whereNotNull('published_at')->with('author')->latest()->get();
        $testimonials = Testimonial::where('approved', true)->with('customer')->latest()->get();

        return view('storefront.community', compact('posts', 'testimonials'));
    }

    /**
     * Healthcare Partnerships page.
     */
    public function partners()
    {
        return view('storefront.partners');
    }

    /**
     * Contact page.
     */
    public function contact()
    {
        return view('storefront.contact');
    }

    /**
     * Newsletter signup (simple).
     */
    public function newsletter(Request $request)
    {
        $request->validate(['email' => 'required|email']);

return back()->with('success', 'Thank you for subscribing to the PINACARE newsletter!');
    }
}

