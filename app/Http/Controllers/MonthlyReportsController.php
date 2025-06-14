<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MilkDelivery;
use App\Models\RateMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonthlyReportsController extends Controller
{
    public function monthly_report_form()
    {
        $customers = Customer::all();
        return view('monthly-reports.monthly-report-list', compact('customers'));
    }

    public function generate_monthly_report(Request $request)
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

    // public function yearly_report_form()
    // {
    //     $types = RateMaster::select('rate_type')->distinct()->pluck('rate_type');
    //     return view('monthly-reports.yearly-report-list', compact('types'));
    // }

    // public function generate_yearly_report(Request $request)
    // {
    //     $types = RateMaster::select('rate_type')->distinct()->pluck('rate_type');

    //     $validated = $request->validate([
    //         'year' => 'required|integer|min:2000|max:' . date('Y'),
    //         'type' => 'required|in:' . $types->implode(','),
    //     ]);

    //     $year = $validated['year'];
    //     $type = $validated['type'];

    //     $data = \App\Models\MilkDelivery::whereYear('created_at', $year)
    //         ->where('type', $type)
    //         ->get();

    //     // $monthly = $data->groupBy(fn($item) => $item->created_at->format('m'))->map(fn($grp) => $grp->sum('total_rate'));
    //     $monthly = $data->groupBy(fn($item) => $item->created_at->format('m'))
    //         ->map(function ($grp) {
    //             return [
    //                 'amount' => $grp->sum('total_rate'),
    //                 'weight' => $grp->sum('weight'),
    //             ];
    //         });

    //     return view('monthly-reports.yearly-report-list', compact('types', 'year', 'type', 'monthly'));
    // }

    public function yearly_report_form()
    {
        $types = RateMaster::select('rate_type')->distinct()->pluck('rate_type');
        return view('monthly-reports.yearly-report-list', compact('types'));
    }

    public function generate_yearly_report(Request $request)
    {
        $types = RateMaster::select('rate_type')->distinct()->pluck('rate_type');

        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'type' => 'required|in:' . $types->implode(','),
        ]);

        $year = $validated['year'];
        $type = $validated['type'];

        $data = \App\Models\MilkDelivery::whereYear('created_at', $year)
            ->where('type', $type)
            ->get();

        $monthly = $data->groupBy(fn($item) => $item->created_at->format('m'))
            ->map(function ($group) {
                return [
                    'amount' => $group->sum('total_rate'),
                    'weight' => $group->sum('weight'),
                ];
            });

        return view('monthly-reports.yearly-report-list', compact('types', 'year', 'type', 'monthly'));
    }
}
