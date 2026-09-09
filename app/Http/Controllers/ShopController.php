<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    /**
     * Product listing with category + size filters.
     */
    public function index(Request $request)
    {
        $cacheKey = 'shop.products|'
            . ($request->filled('category') ? $request->string('category') : 'all')
            . '|'
            . ($request->filled('size') ? $request->string('size') : 'all')
            . '|page:' . (string) $request->input('page', 1);

        $products = Cache::remember($cacheKey, 180, function () use ($request) {
            $query = Product::where('is_active', true);

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            if ($request->filled('size')) {
                $query->where('size', $request->size);
            }

            return $query->orderBy('name')->paginate(12)->withQueryString();
        });

        $categories = ['diaper', 'wipe', 'bundle'];

        // SEO: category-aware meta description (var names prefixed so they don't clash with view locals)
        $category    = $request->filled('category') ? (string) $request->category : null;
        $pageTitle   = $category ? ucfirst($category) . 's' : 'Shop All Products';
        $pageDescription = $category
            ? 'Shop our eco-friendly ' . $category . 's - made from biodegradable, plant-based fibres. Gentle on baby, kind to the planet.'
            : 'Browse PINACARE\u2019s full range of biodegradable diapers, organic wipes and starter bundles - baby-safe and 100% compostable.';

        return view('storefront.products.index', compact('products', 'categories', 'pageTitle', 'pageDescription'));
    }

    /**
     * Single product detail (SEO-friendly slug URLs).
     */
    public function show(string $slug)
    {
        $product = Product::where('is_active', true)->where('slug', $slug)->first();

        // Legacy support: redirect old numeric URLs (/shop/12) to /shop/{slug} with 301
        if (! $product && is_numeric($slug)) {
            $legacy = Product::where('is_active', true)->find($slug);

            if ($legacy) {
                // Only redirect if the product now has a slug (migration has been run).
                // Otherwise show the product directly to avoid an infinite redirect loop.
                if (! empty($legacy->slug)) {
                    return redirect()->route('store.product', $legacy, 301);
                }

                $product = $legacy;
            }
        }

        if (! $product) {
            abort(404);
        }

        $related = Product::where('is_active', true)
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('storefront.products.show', compact('product', 'related'))
            ->with('pageJsonLd', Seo::product($product));
    }
}

