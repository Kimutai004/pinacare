<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id','total_amount','status','payment_method','payment_notes','paypal_order_id','stripe_payment_intent_id','mpesa_checkout_request_id'];

    /**
     * Status values:
     * - pending: Order created, awaiting payment
     * - pending_payment: Payment in progress
     * - payment_failed: Payment failed, customer can retry
     * - paid: Payment successful, items ready to fulfill
     * - shipped: Order shipped
     * - delivered: Order delivered
     * - refunded: Order refunded
     */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if payment is pending
     */
    public function isPaymentPending(): bool
    {
        return $this->status === 'pending_payment';
    }

    /**
     * Check if payment failed
     */
    public function isPaymentFailed(): bool
    {
        return $this->status === 'payment_failed';
    }
}
