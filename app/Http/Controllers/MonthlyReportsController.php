<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MilkDelivery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonthlyReportsController extends Controller
{
    public function showForm()
    {
        $customers = Customer::all();
        return view('monthly-reports.monthly-report-list', compact('customers'));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
        ]);

        $customer = Customer::findOrFail($request->customer_id);
        $month = $request->month;
        $year = $request->year;

        $deliveries = MilkDelivery::where('customer_id', $customer->id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

        $totals = $deliveries->reduce(function ($carry, $item) {
            $carry['milk'] += $item->weight;
            $carry['amount'] += $item->total_rate;
            return $carry;
        }, ['milk' => 0, 'amount' => 0]);

        return view('monthly-reports.monthly-report-list', [
            'customers' => Customer::all(),
            'deliveries' => $deliveries,
            'totalMilk' => $totals['milk'],
            'totalAmount' => $totals['amount'],
            'selectedCustomer' => $customer,
            'month' => $month,
            'year' => $year,
        ]);
    }
}
