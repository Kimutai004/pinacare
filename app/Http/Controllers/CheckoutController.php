<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ImpactMetric;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Subscription;
use App\Services\PaymentService;
use App\Services\MpesaPaymentService;
use App\Services\StripePaymentService;
use App\Services\PayPalPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    private $paymentService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
    }

    /**
     * Show checkout page.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                $total += $product->price * $qty;
            }
        }

        if (empty($cart)) {
            return redirect()->route('store.cart')->with('error', 'Your cart is empty.');
        }

        return view('storefront.checkout', compact('total'));
    }

    /**
     * Place the order and initiate payment processing.
     * 
     * IMPORTANT: Stock is NOT deducted at this stage.
     * Stock will only be deducted after payment confirmation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'email'          => 'required|email',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string',
            'payment_method' => 'required|in:mpesa,card,paypal',
            'subscribe'      => 'nullable|boolean',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Verify stock availability BEFORE creating order
        $items = [];
        $total = 0;
        foreach ($cart as $id => $qty) {
            $product = Product::find($id);
            if (!$product) {
                return back()->with('error', 'Product no longer available.');
            }
            
            // Check stock
            if ($product->stock < $qty) {
                return back()->with('error', "Insufficient stock for {$product->name}. Available: {$product->stock}, Requested: {$qty}");
            }

            $items[] = ['product' => $product, 'qty' => $qty];
            $total += $product->price * $qty;
        }

        // Create or find customer
        $customer = Customer::firstOrCreate(
            ['email' => $request->email],
            ['name' => $request->name, 'phone' => $request->phone, 'address' => $request->address]
        );

        // Create order with PENDING_PAYMENT status (NOT 'paid')
        // Stock will be deducted ONLY after payment confirmation
        $order = Order::create([
            'customer_id'    => $customer->id,
            'total_amount'   => $total,
            'status'         => 'pending_payment',  // IMPORTANT: Not 'paid' yet!
            'payment_method' => $request->payment_method,
        ]);

        // Create order items (but don't deduct stock yet)
        foreach ($items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product']->id,
                'quantity'   => $item['qty'],
                'price'      => $item['product']->price,
            ]);
        }

        // Store subscription preference
        $shouldSubscribe = $request->boolean('subscribe') && count($items) > 0;
        session()->put("pending_subscription.{$order->id}", [
            'customer_id' => $customer->id,
            'product_id' => $items[0]['product']->id,
        ]);

        // Store customer data for payment processor
        session()->put("pending_order_customer.{$order->id}", [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Redirect to appropriate payment processor
        return $this->initiatePayment($order, $request->payment_method, $request);
    }

    /**
     * Initiate payment based on selected method
     */
    private function initiatePayment(Order $order, string $paymentMethod, Request $request)
    {
        $customerData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        try {
            if ($paymentMethod === 'mpesa') {
                return $this->initiateMpesa($order, $customerData);
            } elseif ($paymentMethod === 'card') {
                return $this->initiateStripe($order, $customerData);
            } elseif ($paymentMethod === 'paypal') {
                return $this->initiatePaypal($order, $customerData);
            }

            return back()->with('error', 'Unsupported payment method');
        } catch (\Exception $e) {
            Log::error('Payment initiation failed', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ]);

            $order->delete(); // Clean up failed order
            return back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }

    /**
     * Initiate M-Pesa payment
     */
    private function initiateMpesa(Order $order, array $customerData)
    {
        $mpesaService = new MpesaPaymentService();
        $result = $mpesaService->initiatePayment($order, $customerData['phone']);

        if ($result['success']) {
            // Store the checkout request ID for callback lookup
            Log::info('Storing M-Pesa checkout request ID in order', [
                'order_id' => $order->id,
                'checkout_request_id' => $result['checkout_request_id']
            ]);
            
            $updateResult = $order->update(['mpesa_checkout_request_id' => $result['checkout_request_id']]);
            
            Log::info('Order updated with checkout request ID', [
                'order_id' => $order->id,
                'update_result' => $updateResult,
                'stored_value' => $order->refresh()->mpesa_checkout_request_id
            ]);
            
            return view('storefront.payment.mpesa', [
                'order' => $order,
                'checkoutRequestId' => $result['checkout_request_id'],
                'message' => $result['message'],
                'phoneNumber' => $customerData['phone'],
            ]);
        }

        $order->delete();
        return back()->with('error', $result['message']);
    }

    /**
     * Initiate Stripe payment
     */
    private function initiateStripe(Order $order, array $customerData)
    {
        $stripeService = new StripePaymentService();
        $result = $stripeService->createPaymentIntent($order, $customerData);

        if ($result['success']) {
            // Store Stripe payment intent ID for later verification
            $order->update(['stripe_payment_intent_id' => $result['payment_intent_id']]);

            return view('storefront.payment.stripe', [
                'order' => $order,
                'clientSecret' => $result['client_secret'],
                'amount' => $result['amount'],
                'stripePublicKey' => config('services.stripe.public'),
            ]);
        }

        $order->delete();
        return back()->with('error', $result['message']);
    }

    /**
     * Initiate PayPal payment
     */
    private function initiatePaypal(Order $order, array $customerData)
    {
        $paypalService = new PayPalPaymentService();
        $result = $paypalService->createOrder($order, $customerData);

        if ($result['success']) {
            // Store PayPal order ID for later verification
            $order->update(['paypal_order_id' => $result['order_id']]);

            return view('storefront.payment.paypal', [
                'order' => $order,
                'paypalOrderId' => $result['order_id'],
                'approvalUrl' => $result['approval_url'],
                'paypalClientId' => config('services.paypal.client_id'),
            ]);
        }

        $order->delete();
        return back()->with('error', $result['message']);
    }

    /**
     * Verify M-Pesa payment callback
     * Called by Safaricom after customer completes/cancels STK push
     */
    public function mpesaCallback(Request $request)
    {
        try {
            $callbackData = $request->json()->all();
            
            Log::info('M-Pesa callback received', $callbackData);

            $mpesaService = new MpesaPaymentService();
            $paymentData = $mpesaService->handleCallback($callbackData);

            // Extract order reference from callback
            $orderId = $this->extractOrderIdFromMpesaCallback($callbackData);
            
            if (!$orderId) {
                Log::error('Could not extract order ID from M-Pesa callback', [
                    'checkout_request_id' => $callbackData['Body']['stkCallback']['CheckoutRequestID'] ?? null,
                    'all_data' => $callbackData
                ]);
                return response()->json(['error' => 'Invalid callback'], 400);
            }

            Log::info('Extracted order ID from callback', ['order_id' => $orderId]);

            $order = Order::findOrFail($orderId);
            Log::info('Found order from database', ['order_id' => $order->id, 'status' => $order->status]);

            if ($paymentData['status'] === 'success') {
                // Payment successful - deduct stock and complete order
                Log::info('Payment confirmed as success, confirming payment in system', ['order_id' => $orderId]);
                
                if ($this->paymentService->confirmPayment($order, $paymentData)) {
                    $this->createSubscriptionIfNeeded($order);
                    session()->forget('cart');
                    
                    Log::info('Payment successfully confirmed and stock deducted', ['order_id' => $order->id]);
                    return response()->json(['status' => 'success', 'order_id' => $order->id]);
                }
            } else {
                // Payment failed
                Log::warning('Payment failed from callback', ['order_id' => $orderId, 'reason' => $paymentData['reason'] ?? 'Unknown']);
                $this->paymentService->handlePaymentFailure($order, $paymentData['reason'] ?? 'Payment failed');
            }

            return response()->json(['status' => 'failed']);
        } catch (\Exception $e) {
            Log::error('Exception in mpesaCallback', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Callback processing error'], 500);
        }
    }

    /**
     * Check M-Pesa payment status
     * Called via AJAX polling from frontend
     */
    public function mpesaStatus($checkoutRequestId)
    {
        Log::info('M-Pesa status check', ['checkout_request_id' => $checkoutRequestId]);
        
        // Find order by checkout request ID
        $order = Order::where('mpesa_checkout_request_id', $checkoutRequestId)->first();
        
        if (!$order) {
            Log::warning('Order not found for checkout request ID', ['checkout_request_id' => $checkoutRequestId]);
            return response()->json(['status' => 'failed', 'message' => 'Order not found']);
        }
        
        Log::info('Order found for status check', ['order_id' => $order->id, 'status' => $order->status]);
        
        // Check order status
        if ($order->status === 'paid') {
            Log::info('Payment confirmed - order is paid', ['order_id' => $order->id]);
            return response()->json(['status' => 'success', 'order_id' => $order->id]);
        } elseif ($order->status === 'payment_failed') {
            Log::warning('Payment failed', ['order_id' => $order->id]);
            return response()->json(['status' => 'failed', 'message' => 'Payment failed']);
        }
        
        // Still pending
        Log::info('Payment still pending', ['order_id' => $order->id, 'current_status' => $order->status]);
        return response()->json(['status' => 'pending', 'order_id' => $order->id]);
    }

    /**
     * Verify Stripe payment
     * Called from frontend after payment processing
     */
    public function stripeCallback(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'order_id' => 'required|integer',
        ]);

        $order = Order::findOrFail($request->order_id);
        
        $stripeService = new StripePaymentService();
        $paymentData = $stripeService->verifyPayment($request->payment_intent_id);

        if ($paymentData['status'] === 'success') {
            // Payment successful - deduct stock and complete order
            if ($this->paymentService->confirmPayment($order, $paymentData)) {
                $this->createSubscriptionIfNeeded($order);
                session()->forget('cart');
                
                return redirect()->route('store.checkout.success', $order->id)
                    ->with('success', 'Payment successful!');
            }
        }

        return back()->with('error', 'Payment verification failed');
    }

    /**
     * Handle PayPal return (after customer approves on PayPal)
     */
    public function paypalReturn(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        // Find order by PayPal order ID
        $order = Order::where('paypal_order_id', $request->token)->firstOrFail();

        $paypalService = new PayPalPaymentService();
        $paymentData = $paypalService->captureOrder($request->token);

        if ($paymentData['status'] === 'success') {
            // Payment successful - deduct stock and complete order
            if ($this->paymentService->confirmPayment($order, $paymentData)) {
                $this->createSubscriptionIfNeeded($order);
                session()->forget('cart');
                
                return redirect()->route('store.checkout.success', $order->id)
                    ->with('success', 'Payment successful!');
            }
        }

        return redirect()->route('store.checkout.paypal.cancel')->with('error', 'Payment failed');
    }

    /**
     * Handle PayPal cancellation
     */
    public function paypalCancel(Request $request)
    {
        // User cancelled on PayPal - order remains in pending_payment status
        // User can retry or abandon the order
        
        return view('storefront.payment.paypal-cancelled', [
            'message' => 'You cancelled the PayPal payment. You can return to checkout to try again.',
        ]);
    }

    /**
     * Order confirmation page
     * Only shown after successful payment
     */
    public function success($id)
    {
        $order = Order::with('customer', 'items.product', 'payment')->findOrFail($id);

        // Verify order is actually paid
        if (!$order->isPaid()) {
            return redirect()->route('store.cart')->with('error', 'Order not paid');
        }

        return view('storefront.checkout-success', compact('order'));
    }

    /**
     * Helper: Extract order ID from M-Pesa callback
     */
    private function extractOrderIdFromMpesaCallback($callbackData)
    {
        // Extract CheckoutRequestID from callback
        $checkoutRequestId = $callbackData['Body']['stkCallback']['CheckoutRequestID'] ?? null;
        
        Log::info('Attempting to extract order ID from callback', ['checkout_request_id' => $checkoutRequestId]);
        
        if (!$checkoutRequestId) {
            Log::error('No CheckoutRequestID in M-Pesa callback');
            return null;
        }
        
        // Look up order by checkpoint request ID
        $order = Order::where('mpesa_checkout_request_id', $checkoutRequestId)->first();
        
        if ($order) {
            Log::info('Found order by checkout request ID', ['order_id' => $order->id, 'checkout_request_id' => $checkoutRequestId]);
            return $order->id;
        } else {
            Log::error('Order not found by checkout request ID', ['checkout_request_id' => $checkoutRequestId]);
            // Debug: list all orders with their checkout request IDs
            $allOrders = Order::where('mpesa_checkout_request_id', '!=', null)->limit(5)->get(['id', 'mpesa_checkout_request_id']);
            Log::debug('Recent orders with checkout IDs', $allOrders->toArray());
            return null;
        }
    }

    /**
     * Create subscription if customer opted in
     */
    private function createSubscriptionIfNeeded(Order $order)
    {
        $subscriptionData = session()->get("pending_subscription.{$order->id}");
        
        if ($subscriptionData) {
            Subscription::create([
                'customer_id' => $subscriptionData['customer_id'],
                'product_id' => $subscriptionData['product_id'],
                'frequency' => 'monthly',
                'next_delivery_date' => now()->addMonth(),
                'status' => 'active',
            ]);

            session()->forget("pending_subscription.{$order->id}");
        }
    }
}

