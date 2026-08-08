<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Show the cart page.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cart as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                $products[] = ['product' => $product, 'qty' => $qty, 'subtotal' => $product->price * $qty];
                $total += $product->price * $qty;
            }
        }

        return view('storefront.cart', compact('products', 'total'));
    }

    /**
     * Add an item to the cart (AJAX-friendly).
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $id = $request->product_id;
        $cart[$id] = ($cart[$id] ?? 0) + $request->qty;
        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'cart_count' => array_sum($cart),
                'message'    => 'Added to cart!',
            ]);
        }

        return redirect()->route('store.cart')->with('success', 'Item added to cart!');
    }

    /**
     * Update quantity.
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if ($request->qty < 1) {
            unset($cart[$id]);
        } else {
            $cart[$id] = $request->qty;
        }
        session()->put('cart', $cart);

        return redirect()->route('store.cart')->with('success', 'Cart updated.');
    }

    /**
     * Remove an item.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return redirect()->route('store.cart')->with('success', 'Item removed.');
    }
}

