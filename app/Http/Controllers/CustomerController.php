<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        $customer = Customer::create($request->only(['name','email','phone','address']));
        return response()->json($customer, 201);
    }
}
