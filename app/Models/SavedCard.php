<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * SavedCard Model
 * 
 * Stores tokenized card information for quick checkout
 * Stripe handles actual card data (PCI compliant)
 */
class SavedCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'stripe_payment_method_id',  // Stripe's token for the card
        'card_brand',                 // visa, mastercard, amex, etc
        'card_last_four',             // Last 4 digits of card
        'card_exp_month',             // Expiration month
        'card_exp_year',              // Expiration year
        'cardholder_name',            // Name on card
        'is_default',                 // Default card for checkout
        'stripe_customer_id',         // Link to Stripe customer
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'card_exp_month' => 'integer',
        'card_exp_year' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Card belongs to a customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Set this card as default
     * Unsets other default cards for this customer
     */
    public function setAsDefault()
    {
        // Unset other defaults
        SavedCard::where('customer_id', $this->customer_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // Set this as default
        $this->update(['is_default' => true]);
    }

    /**
     * Get display string (e.g., "Visa ending in 4242")
     */
    public function getDisplayName()
    {
        $brand = ucfirst($this->card_brand);
        return "{$brand} ending in {$this->card_last_four}";
    }

    /**
     * Check if card is expired
     */
    public function isExpired()
    {
        $now = now();
        $expiry = $this->card_exp_year . '-' . str_pad($this->card_exp_month, 2, '0', STR_PAD_LEFT) . '-01';
        return strtotime($expiry) < $now->timestamp;
    }

    /**
     * Get expiry date formatted
     */
    public function getExpiryDate()
    {
        return str_pad($this->card_exp_month, 2, '0', STR_PAD_LEFT) . '/' . $this->card_exp_year;
    }
}
