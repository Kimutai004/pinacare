<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Product listing with category + size filters.
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        $products = $query->orderBy('name')->paginate(12)->withQueryString();
        $categories = ['diaper', 'wipe', 'bundle'];

        return view('storefront.products.index', compact('products', 'categories'));
    }

    /**
     * Single product detail.
     */
    public function show($id)
    {
        $product = Product::where('is_active', true)->findOrFail($id);
        $related = Product::where('is_active', true)
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('storefront.products.show', compact('product', 'related'));
    }
}

