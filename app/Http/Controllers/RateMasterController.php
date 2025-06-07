<?php

namespace App\Http\Controllers;

use App\Models\RateMaster;
use Illuminate\Http\Request;

class RateMasterController extends Controller
{
    public function add_rate()
    {
        return view('rate-master.rate-add');
    }

    public function rate_store(Request $request)
    {
        $validated = $request->validate([
            'rate_type' => 'required',
            'rate' => 'required',
        ]);

        $data = RateMaster::create([
            'rate_type' => $validated['rate_type'],
            'rate' => $validated['rate'],
        ]);
        // dd($data);
        return redirect()->route('admin.rate_list')->with('success', 'Rate added successfully!');
    }

    public function rate_list()
    {
        $rates = RateMaster::orderBy('created_at', 'desc')->get();
        return view('rate-master.rate-list', compact('rates'));
    }

    public function rate_edit($id)
    {
        $rate = RateMaster::findOrFail($id);
        return view('rate-master.rate-edit', compact('rate'));
    }

    public function rate_update(Request $request, $id)
    {
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
        $rate = RateMaster::findOrFail($id);
        $rate->delete();

        return redirect()->route('admin.rate_list')->with('success_delete', 'Rate deleted successfully!');
    }
}
