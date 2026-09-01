<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name','email','phone','address'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    /**
     * Customer's saved cards for quick checkout
     */
    public function savedCards()
    {
        return $this->hasMany(SavedCard::class);
    }

    /**
     * Get the customer's default card
     */
    public function getDefaultCard()
    {
        return $this->savedCards()->where('is_default', true)->first();
    }
}
