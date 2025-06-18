<?php

namespace App\Http\Controllers;

use App\Models\RateMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateMasterController extends Controller
{
    public function add_rate()
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.index')->with('error', 'Access denied.');
        }
        return view('rate-master.rate-add');
    }

    public function rate_store(Request $request)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.index')->with('error', 'Access denied.');
        }
        $validated = $request->validate([
            'rate_type' => 'required',
            'rate' => 'required',
        ]);

        $data = RateMaster::create([
            'rate_type' => $validated['rate_type'],
            'rate' => $validated['rate'],
        ]);
        return redirect()->route('admin.rate_list')->with('success', 'Rate added successfully!');
    }

    public function rate_list()
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.index')->with('error', 'Access denied.');
        }
        $rates = RateMaster::orderBy('created_at', 'desc')->get();
        return view('rate-master.rate-list', compact('rates'));
    }

    public function rate_edit($id)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.index')->with('error', 'Access denied.');
        }
        $rate = RateMaster::findOrFail($id);
        return view('rate-master.rate-edit', compact('rate'));
    }

    public function rate_update(Request $request, $id)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.index')->with('error', 'Access denied.');
        }
        $validated = $request->validate([
            'rate_type' => 'required',
            'rate' => 'required',
        ]);

        $rate = RateMaster::findOrFail($id);
        $rate->update([
            'rate_type' => $validated['rate_type'],
            'rate' => $validated['rate'],
        ]);

        return redirect()->route('admin.rate_list')->with('success_update', 'Rate updated successfully!');
    }

    public function rate_delete($id)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('admin.index')->with('error', 'Access denied.');
        }
        $rate = RateMaster::findOrFail($id);
        $rate->delete();

        return redirect()->route('admin.rate_list')->with('success_delete', 'Rate deleted successfully!');
    }
}
