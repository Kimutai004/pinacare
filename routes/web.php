<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ImpactController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BlogController as PublicBlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

// ===== Storefront (Public) =====
Route::get('/', [StorefrontController::class, 'index'])->name('store.home');
Route::get('/shop', [ShopController::class, 'index'])->name('store.shop');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('store.product');
Route::get('/about', [StorefrontController::class, 'about'])->name('store.about');
Route::get('/impact', [StorefrontController::class, 'impact'])->name('store.impact');
Route::get('/community', [StorefrontController::class, 'community'])->name('store.community');
Route::get('/community/blog/{slug}', [PublicBlogController::class, 'show'])->name('store.blog');
Route::get('/healthcare', [StorefrontController::class, 'partners'])->name('store.partners');
Route::get('/contact', [StorefrontController::class, 'contact'])->name('store.contact');
Route::post('/contact/newsletter', [StorefrontController::class, 'newsletter'])->name('store.newsletter');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('store.cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('store.cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('store.cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('store.cart.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('store.checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('store.checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('store.checkout.success');


// ===== Admin Authentication =====
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// ===== Admin Protected Routes =====
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Products
    Route::resource('products', ProductController::class)->except(['show']);

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('orders/{order}/payment', [OrderController::class, 'addPayment'])->name('orders.payment');

    // Subscriptions
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::put('subscriptions/{subscription}', [SubscriptionController::class, 'update'])->name('subscriptions.update');

    // Customers
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');

    // Impact
    Route::get('impact', [ImpactController::class, 'index'])->name('impact.index');
    Route::post('impact', [ImpactController::class, 'update'])->name('impact.update');

    // Blog
    Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('blog/{post}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('blog/{post}', [BlogController::class, 'update'])->name('blog.update');
    Route::put('blog/{post}/publish', [BlogController::class, 'publish'])->name('blog.publish');
    Route::put('blog/{post}/unpublish', [BlogController::class, 'unpublish'])->name('blog.unpublish');
    Route::delete('blog/{post}', [BlogController::class, 'destroy'])->name('blog.destroy');

    // Testimonials
    Route::get('testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::put('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::put('testimonials/{testimonial}/reject', [TestimonialController::class, 'reject'])->name('testimonials.reject');
    Route::delete('testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Settings
    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});
