<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\RateMaster;
use Illuminate\Http\Request;

class MilkDeliveryController extends Controller
{
    public function milk_delivery()
    {
        return view('milk-delivery.milk-delivery-add');
    }

    public function getCustomerInfo(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        return response()->json([
            'name' => $customer->customer_name,
        ]);
    }
}
