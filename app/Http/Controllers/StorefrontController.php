<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\ImpactMetric;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StorefrontController extends Controller
{
    /**
     * Homepage: hero, highlights, featured products, impact counter, testimonials.
     */
    public function index()
    {
        $featuredProducts = Cache::remember('storefront.home.featured_products', 300, function () {
            return Product::where('is_active', true)->latest()->take(8)->get();
        });

        $productsByCat = Cache::remember('storefront.home.products_by_cat', 300, function () {
            return [
                'diaper' => Product::where('is_active', true)->where('category', 'diaper')->count(),
                'wipe'   => Product::where('is_active', true)->where('category', 'wipe')->count(),
                'bundle' => Product::where('is_active', true)->where('category', 'bundle')->count(),
            ];
        });

        $impact = Cache::remember('storefront.home.impact', 900, function () {
            return ImpactMetric::latest()->first();
        });

        $testimonials = Cache::remember('storefront.home.testimonials', 600, function () {
            return Testimonial::where('approved', true)->with('customer')->latest()->take(3)->get();
        });

        $posts = Cache::remember('storefront.home.posts', 600, function () {
            return BlogPost::whereNotNull('published_at')->latest()->take(3)->get();
        });

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
        $impact = Cache::remember('storefront.impact.latest', 900, function () {
            return ImpactMetric::latest()->first();
        });

        $metrics = Cache::remember('storefront.impact.metrics', 900, function () {
            return ImpactMetric::latest()->take(6)->get();
        });

        return view('storefront.impact', compact('impact', 'metrics'));
    }

    /**
     * Community page: blog posts, testimonials, newsletter (paginated).
     */
    public function community(Request $request)
    {
        $posts = BlogPost::whereNotNull('published_at')
            ->with('author')
            ->latest()
            ->paginate(9)
            ->withQueryString();

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

