<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $subscription = Subscription::create($request->only([
            'customer_id','product_id','frequency','next_delivery_date','status'
        ]));

        return response()->json($subscription, 201);
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update($request->only(['status','next_delivery_date']));
        return response()->json($subscription);
    }
}
