<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MilkDairy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MilkDairyController extends Controller
{
    public function summary()
    {
        $entries = MilkDairy::all();
        $totalsByCustomer = MilkDairy::select('customer_no_in_dairy', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('customer_no_in_dairy')
            ->get();
        $subTotalAmount = $totalsByCustomer->sum('total_amount');
        $totalMilk = $entries->sum('milk_weight');
        $totalFat = $entries->sum('fat_in_percentage');
        $totalRate = $entries->sum('rate_per_liter');
        $totalAmount = $entries->sum('amount');
        $entryCount = $entries->count();

        return view('milk-dairy.summary', compact(
            'entries',
            'totalsByCustomer',
            'subTotalAmount',
            'totalMilk',
            'totalFat',
            'totalRate',
            'totalAmount',
            'entryCount'
        ));
    }

    public function create()
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('milk_dairy.summary')->with('error', 'You are not authorized to add a dairy entry.');
        }
        return view('milk-dairy.milk-dairy-add');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()
                ->route('milk_dairy.summary')
                ->with('error', 'You are not authorized to store dairy data.');
        }

        $validated = $request->validate([
            'customer_no_in_dairy' => ['required', 'numeric', 'min:1'],
            'shift'               => ['required', 'in:Morning,Evening'],
            'created_at'          => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'milk_weight'         => ['required', 'numeric', 'min:0.01'],
            'fat_in_percentage'   => ['required', 'numeric', 'min:0', 'max:15'],
            'rate_per_liter'      => ['required', 'numeric', 'min:0'],
        ]);

        $validated['amount'] = round(
            $validated['milk_weight'] * $validated['rate_per_liter'],
            2
        );

        $validated['total_amount'] = MilkDairy::where(
            'customer_no_in_dairy',
            $validated['customer_no_in_dairy']
        )->sum('amount') + $validated['amount'];

        $validated['created_at'] = Carbon::createFromFormat('Y-m-d', $validated['created_at']);

        MilkDairy::create($validated);

        return redirect()
            ->route('milk_dairy.summary')
            ->with('success', 'Milk entry added successfully.');
    }

    public function prevTotal(Request $request)
    {
        $request->validate([
            'customer_no' => 'required|numeric',
            'exclude_id'  => 'nullable|numeric',
        ]);

        $query = MilkDairy::where('customer_no_in_dairy', $request->customer_no);

        if ($request->filled('exclude_id')) {
            $query->where('id', '!=', $request->exclude_id);
        }

        $total = $query->sum('amount');

        return response()->json(['total' => round($total, 2)]);
    }

    public function edit(MilkDairy $milkDairy)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('milk_dairy.summary')->with('error', 'You are not authorized to edit this entry.');
        }
        $prevTotal = MilkDairy::where('customer_no_in_dairy', $milkDairy->customer_no_in_dairy)
            ->where('id', '!=', $milkDairy->id)
            ->sum('amount');
        return view('milk-dairy.milk-dairy-edit', compact('milkDairy', 'prevTotal'));
    }
    public function update(Request $request, MilkDairy $milkDairy)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('milk_dairy.summary')->with('error', 'You are not authorized to update this entry.');
        }
        $validated = $request->validate([
            'customer_no_in_dairy' => ['required', 'numeric'],
            'shift'               => ['required', 'in:Morning,Evening'],
            'created_at'          => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'milk_weight'          => ['required', 'numeric', 'min:0.01'],
            'fat_in_percentage'    => ['required', 'numeric', 'min:0', 'max:15'],
            'rate_per_liter'       => ['required', 'numeric', 'min:0'],
        ]);

        $validated['amount'] = round($validated['milk_weight'] * $validated['rate_per_liter'], 2);

        $prevTotal = MilkDairy::where('customer_no_in_dairy', $validated['customer_no_in_dairy'])
            ->where('id', '!=', $milkDairy->id)
            ->sum('amount');

        $validated['total_amount'] = $prevTotal + $validated['amount'];

        $milkDairy->update($validated);

        return redirect()
            ->route('milk_dairy.summary')
            ->with('success_update', 'Milk entry updated successfully.');
    }

    public function destroy(MilkDairy $milkDairy)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return redirect()->route('milk_dairy.summary')->with('error', 'You are not authorized to delete this entry.');
        }
        $milkDairy->delete();
        return redirect()->route('milk_dairy.summary')->with('success_delete', 'Milk entry deleted successfully.');
    }

    public function ten_days_reports(Request $request)
    {
        $request->validate([
            'start_date' => ['nullable', 'date', 'before_or_equal:today'],
            'end_date'   => ['nullable', 'date', 'before_or_equal:today'],
        ]);

        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfMonth();

        if ($startDate->gt($endDate)) {
            return back()
                ->withErrors(['date_range' => 'Start date cannot be after end date.'])
                ->withInput();
        }

        $entries = MilkDairy::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get();

        $grouped = $entries->groupBy(function ($entry) {
            $day = Carbon::parse($entry->created_at)->day;
            return $day <= 10 ? '1-10'
                : ($day <= 20 ? '11-20' : '21-end');
        });

        return view('milk-dairy.ten-days-reports', compact('grouped', 'startDate', 'endDate'));
    }
}
