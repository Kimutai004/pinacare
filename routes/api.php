<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Customers
Route::post('/customers', [CustomerController::class, 'store']);

// Orders
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']); // admin only

// Subscriptions
Route::post('/subscriptions', [SubscriptionController::class, 'store']);
Route::put('/subscriptions/{id}', [SubscriptionController::class, 'update']);

// Testimonials
Route::post('/testimonials', [TestimonialController::class, 'store']);
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::put('/testimonials/{id}/approve', [TestimonialController::class, 'approve']); // admin only

// Blog
Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{slug}', [BlogController::class, 'show']);
Route::post('/blog', [BlogController::class, 'store']); // admin only


// Payments
Route::post('/payments/mpesa', [PaymentController::class, 'mpesa']);
Route::post('/payments/stripe', [PaymentController::class, 'stripe']);
Route::post('/payments/paypal', [PaymentController::class, 'paypal']);
Route::get('/payments/status/{transaction_id}', [PaymentController::class, 'status']);
