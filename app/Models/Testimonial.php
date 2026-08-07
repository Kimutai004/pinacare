<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['customer_id','content','rating','approved'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
