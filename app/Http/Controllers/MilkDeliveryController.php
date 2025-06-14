<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MilkDelivery;
use App\Models\RateMaster;
use Carbon\Carbon;
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

        // Get rate for customer_type (e.g., Cow/Buffalo)
        $rate = RateMaster::where('rate_type', $customer->customer_type)->first();

        if (!$rate) {
            return response()->json(['error' => 'Rate not found for type'], 404);
        }

        return response()->json([
            'name' => $customer->customer_name,
            'type' => $customer->customer_type,
            'rate' => $rate ? $rate->rate : null,
        ]);
    }

    public function milk_delivery_store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'weight'      => 'required|numeric|min:0',
            'time'        => 'required|in:Morning,Evening',
            'delivery_date'  => 'required|date',
        ]);

        $customer = Customer::find($validated['customer_id']);
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }

        $rateRecord = RateMaster::where('rate_type', $customer->customer_type)->first();
        if (!$rateRecord) {
            return redirect()->back()->with('error', 'Rate not found for this customer type.');
        }

        $rate       = $rateRecord->rate;
        $type       = $customer->customer_type;
        $weight     = $validated['weight'];
        $total_rate = $rate * $weight;

        MilkDelivery::create([
            'customer_id' => $customer->id,
            'weight'      => $weight,
            'type'        => $type,
            'rate'        => $rate,
            'total_rate'  => $total_rate,
            'time'        => $validated['time'],
            'created_at'  => $validated['delivery_date'],
        ]);

        return redirect()->back()->with('success', 'Milk delivery record added successfully.');
    }

    public function milk_delivery_list()
    {
        $deliveries = MilkDelivery::with('customer')->orderBy('id', 'desc')->get();
        return view('milk-delivery.milk-delivery-list', compact('deliveries'));
    }

    // Show edit form
    public function milk_delivery_edit($id)
    {
        $delivery = MilkDelivery::findOrFail($id);
        // If you want to allow changing type or rate from rate_master table:
        $rateTypes = RateMaster::select('rate_type')->distinct()->pluck('rate_type');
        return view('milk-delivery.milk-delivery-edit', compact('delivery', 'rateTypes'));
    }

    // Handle update form submission
    public function milk_delivery_update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'weight' => 'required|numeric|min:0',
            'type' => 'required|string',
            'rate' => 'required|numeric|min:0',
            'total_rate' => 'required|numeric|min:0',
            'time' => 'required|in:Morning,Evening',
            // 'delivery_date'  => 'required|date',
            'delivery_date' => 'required|date_format:d-m-Y'
        ]);

        $delivery = MilkDelivery::findOrFail($id);
        $deliveryDate = Carbon::createFromFormat('d-m-Y', $request->delivery_date);
        $delivery->update([
            'customer_id' => $request->customer_id,
            'weight' => $request->weight,
            'type' => $request->type,
            'rate' => $request->rate,
            'total_rate' => $request->total_rate,
            'time' => $request->time,
            // 'created_at'  => $request->delivery_date,
            'created_at' => $deliveryDate,
        ]);

        return redirect()->route('admin.milk_delivery_list')->with('success_update', 'Milk delivery updated successfully.');
    }

    public function milk_delivery_delete($id)
    {
        $delivery = MilkDelivery::findOrFail($id);
        $delivery->delete();

        return redirect()->back()->with('success_delete', 'Milk delivery deleted successfully.');
    }
}
