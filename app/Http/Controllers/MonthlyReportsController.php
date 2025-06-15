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

    public function full_reports()
    {
        $rateMasters = RateMaster::all();
        $summary = [];

        foreach ($rateMasters as $rate) {
            $type = strtolower($rate->rate_type); // cow, buffalo, ghee, butter

            $deliveries = MilkDelivery::where('type', $type)->get();

            $total_weight = $deliveries->sum('weight');        // L or kg
            $total_amount = $deliveries->sum('total_rate');

            // Share logic (only for cow/bufflo)
            if (in_array($type, ['cow', 'bufflo'])) {
                if ($total_weight == 0.25) {
                    $shares = 0.5;
                } elseif ($total_weight == 0.5) {
                    $shares = 1.0;
                } elseif ($total_weight == 0.75) {
                    $shares = 1.5;
                } elseif ($total_weight == 1.0) {
                    $shares = 2.0;
                } else {
                    $shares = $total_weight * 2;
                }
            } else {
                $shares = null; // No shares for ghee/butter
            }

            $unit = in_array($type, ['ghee', 'butter']) ? 'kg' : 'L';

            $summary[$type] = [
                'rate' => $rate->rate,
                'total_weight' => $total_weight,
                'total_amount' => $total_amount,
                'shares' => $shares,
                'unit' => $unit,
            ];
        }

        return view('monthly-reports.full-reports', compact('summary'));
    }

    // public function print_reports(Request $request)
    // {
    //     $customerIds = $request->input('customer_ids', []);
    //     $customers = Customer::whereIn('id', $customerIds)->get();

    //     $cowRate = RateMaster::where('rate_type', 'cow')->latest('id')->value('rate') ?? 0;
    //     $buffaloRate = RateMaster::where('rate_type', 'buffalo')->latest('id')->value('rate') ?? 0;

    //     $data = $customers->map(function ($customer) use ($cowRate, $buffaloRate) {
    //         $deliveries = MilkDelivery::where('customer_id', $customer->id)->get();

    //         $cowMilk = $deliveries->where('type', 'cow')->sum('weight');
    //         $buffaloMilk = $deliveries->where('type', 'buffalo')->sum('weight');

    //         return [
    //             'customer' => $customer,
    //             'cowMilk' => $cowMilk,
    //             'buffaloMilk' => $buffaloMilk,
    //             'cowRate' => $cowRate,
    //             'buffaloRate' => $buffaloRate,
    //         ];
    //     });

    //     return view('monthly-reports.print-reports', compact('data'));
    // }

    public function print_reports(Request $request)
    {
        $customerIds = $request->input('customer_ids', []);
        $customers = Customer::whereIn('id', $customerIds)->get();

        $cowRate = RateMaster::where('rate_type', 'cow')->latest('id')->value('rate') ?? 0;
        $buffaloRate = RateMaster::where('rate_type', 'buffalo')->latest('id')->value('rate') ?? 0;

        $data = $customers->map(function ($customer) use ($cowRate, $buffaloRate) {
            $deliveries = MilkDelivery::where('customer_id', $customer->id)->get();

            $cowMilk = $deliveries->where('type', 'cow')->sum('weight');
            $buffaloMilk = $deliveries->where('type', 'buffalo')->sum('weight');

            return [
                'customer' => $customer,
                'cowMilk' => $cowMilk,
                'buffaloMilk' => $buffaloMilk,
                'cowRate' => $cowRate,
                'buffaloRate' => $buffaloRate,
            ];
        });

        return view('monthly-reports.print-reports', compact('data'));
    }
}
