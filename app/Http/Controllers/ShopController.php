<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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

    /**
     * Serve an uploaded product photo straight from the storage disk.
     *
     * Uploaded images live in storage/app/public/products, but whether that
     * folder is reachable over the web depends entirely on how the site is
     * hosted: Laravel's `storage:link` symlink makes `/storage/...` work,
     * while hosts whose document root is the project folder (e.g. cPanel's
     * public_html) expose no such alias and every /storage/... request 404s.
     *
     * Routing the request through PHP removes that dependency - Laravel always
     * knows its own storage path - so the same stored path works on every host.
     *
     * @param  string  $filename  Stored filename, e.g. "abc123.png"
     */
    public function productImage(string $filename)
    {
        // Strip any directory components: only ever serve from the products
        // folder, never let a crafted name traverse out of it.
        $filename = basename($filename);

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (! in_array($extension, $allowed, true)) {
            abort(404);
        }

        $disk = Storage::disk('public');
        $path = 'products/'.$filename;

        if (! $disk->exists($path)) {
            abort(404);
        }

        $mime = $disk->mimeType($path) ?: 'application/octet-stream';

        $response = new BinaryFileResponse(
            $disk->path($path),
            200,
            ['Content-Type' => $mime]
        );

        // Filenames are content-hashed on upload, so they are safe to cache hard.
        $response->setPublic();
        $response->setMaxAge(31536000);
        $response->setImmutable();
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, '', basename($path));

        return $response;
    }
}

