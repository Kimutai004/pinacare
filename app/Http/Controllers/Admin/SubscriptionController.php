<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscriptions = Subscription::with('customer','product')
            ->when($request->has('status') && $request->status !== '', fn($q) => $q->where('status',$request->status))
            ->latest()
            ->paginate(10);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $data = $request->validate([
            'status'             => 'required|in:active,paused,cancelled',
            'next_delivery_date' => 'nullable|date',
        ]);

        $subscription->update($data);

        return back()->with('success','Subscription updated successfully.');
    }
}
