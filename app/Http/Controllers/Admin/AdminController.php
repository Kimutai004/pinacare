<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ImpactMetric;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders       = Order::count();
        $revenue           = Order::whereIn('status', ['paid','shipped','delivered'])->sum('total_amount');
        $activeSubs        = Subscription::where('status','active')->count();
        $lowStockAlerts    = Product::where('is_active', true)->where('stock', '<', 10)->count();

        $recentOrders      = Order::with('customer')->latest()->take(8)->get();
        $inventoryAlerts   = Product::where('stock', '<', 10)->orderBy('stock')->take(8)->get();
        $impactMetrics     = ImpactMetric::latest()->first();
        $testimonials      = Testimonial::with('customer')->where('approved', false)->latest()->take(5)->get();
        $blogPosts         = BlogPost::with('author')->latest()->take(5)->get();

        // Payment gateway breakdown
        $payments          = Payment::selectRaw('payment_gateway, SUM(amount) as total')
                                    ->groupBy('payment_gateway')
                                    ->pluck('total','payment_gateway');

        return view('admin.dashboard.index', [
            'totalOrders'    => $totalOrders,
            'revenue'        => $revenue,
            'activeSubs'     => $activeSubs,
            'lowStockAlerts' => $lowStockAlerts,
            'recentOrders'   => $recentOrders,
            'inventoryAlerts'=> $inventoryAlerts,
            'impactMetrics'  => $impactMetrics,
            'testimonials'   => $testimonials,
            'blogPosts'      => $blogPosts,
'payments'       => $payments,
        ]);
    }

    public function settings()
    {
        return view('admin.settings.index');
    }

    public function updateSettings(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:admins,email,'.$admin->id,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'required|string|min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return back()->with('success','Account settings updated successfully.');
    }
}
