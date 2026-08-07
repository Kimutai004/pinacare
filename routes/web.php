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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

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
