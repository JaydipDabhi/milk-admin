<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\RateMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function customer_list()
    {
        $customers = Customer::latest()->get();
        return view('customer.customer-list', compact('customers'));
    }

    public function customer_create()
    {
        $rateTypes = RateMaster::select('rate_type')->distinct()->pluck('rate_type');
        return view('customer.customer-add', compact('rateTypes'));
    }

    public function customer_store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_type' => 'required|string|max:255',
            'customer_mobile' => 'nullable|string|max:10',
            'customer_email' => 'nullable|email|max:255',
        ]);

        $data = Customer::create([
            'customer_name' => $validated['customer_name'],
            'customer_type' => $validated['customer_type'],
            'customer_mobile' => $validated['customer_mobile'],
            'customer_email' => $validated['customer_email'],
        ]);
        // dd($data);
        return redirect()->route('admin.customer_list')->with('success', 'Customer added successfully!');
    }

    public function customer_edit($id)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.customer_list')->with('error', 'You cannot edit the customer.');
        }
        $customer = Customer::findOrFail($id);
        $rateTypes = RateMaster::select('rate_type')->distinct()->pluck('rate_type');
        return view('customer.customer-edit', compact('customer', 'rateTypes'));
    }

    public function customer_update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_type' => 'required|string|max:255',
            'customer_mobile' => 'nullable|string|max:10',
            'customer_email' => 'nullable|email|max:255',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update([
            'customer_name' => $validated['customer_name'],
            'customer_type' => $validated['customer_type'],
            'customer_mobile' => $validated['customer_mobile'],
            'customer_email' => $validated['customer_email'],
        ]);

        return redirect()->route('admin.customer_list')->with('success_update', 'Customer updated successfully!');
    }

    public function customer_delete($id)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.customer_list')->with('error', 'You cannot delete a customer.');
        }
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customer_list')->with('success_delete', 'Customer deleted successfully!');
    }
}
