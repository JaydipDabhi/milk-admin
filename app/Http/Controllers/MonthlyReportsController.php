<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MilkDelivery;
use App\Models\RateMaster;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function print_reports(Request $request)
    {
        $customerIds = $request->input('customer_ids', []);
        $customers = Customer::whereIn('id', $customerIds)->get();

        $cowRate = RateMaster::where('rate_type', 'cow')->latest('id')->value('rate') ?? 0;
        $buffloRate = RateMaster::where('rate_type', 'bufflo')->latest('id')->value('rate') ?? 0;

        $data = $customers->map(function ($customer) use ($cowRate, $buffloRate) {
            $deliveries = MilkDelivery::where('customer_id', $customer->id)->get();

            $cowMilk = $deliveries->where('type', 'cow')->sum('weight');
            $buffloMilk = $deliveries->where('type', 'bufflo')->sum('weight');

            return [
                'customer' => $customer,
                'cowMilk' => $cowMilk,
                'buffloMilk' => $buffloMilk,
                'cowRate' => $cowRate,
                'buffloRate' => $buffloRate,
            ];
        });

        return view('monthly-reports.print-reports', compact('data'));
    }

    // public function download_pdf(Request $request)
    // {
    //     $customerIds = $request->input('customer_ids', []);
    //     $month = $request->input('month');
    //     $year = $request->input('year');

    //     if (!$month || !$year) {
    //         return back()->with('error', 'Please select both month and year.');
    //     }

    //     $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
    //     $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

    //     $customers = Customer::whereIn('id', $customerIds)->get();

    //     $rates = RateMaster::latest('id')
    //         ->get()
    //         ->pluck('rate', 'rate_type') // ['cow' => 60, 'bufflo' => 70, ...]
    //         ->mapWithKeys(fn($rate, $type) => [strtolower($type) => $rate]);

    //     $data = $customers->map(function ($customer) use ($startDate, $endDate, $rates) {
    //         $deliveries = MilkDelivery::where('customer_id', $customer->id)
    //             ->whereBetween('created_at', [$startDate, $endDate])
    //             ->get();

    //         $grouped = $deliveries->groupBy(fn($d) => strtolower($d->type));

    //         $products = [];

    //         foreach ($grouped as $type => $entries) {
    //             $totalWeight = $entries->sum('weight');

    //             // Default to x2 shares logic, customizable per product
    //             $shares = match ($totalWeight) {
    //                 0.25 => 0.5,
    //                 0.5 => 1,
    //                 0.75 => 1.5,
    //                 1 => 2,
    //                 default => $totalWeight * 2,
    //             };

    //             $rate = $rates[$type] ?? 0;
    //             $amount = $shares * ($rate / 2);

    //             $products[] = [
    //                 'type' => Str::title($type),
    //                 'weight' => $totalWeight,
    //                 'shares' => $shares,
    //                 'rate' => $rate,
    //                 'total' => $amount,
    //             ];
    //         }

    //         return [
    //             'customer' => $customer,
    //             'products' => $products,
    //             'startDate' => $startDate->format('d-m-Y'),
    //             'endDate' => $endDate->format('d-m-Y'),
    //         ];
    //     });

    //     $pdf = Pdf::loadView('monthly-reports.pdf-view', compact('data'))->setPaper('a4');
    //     return $pdf->stream("milk-bill-{$month}-{$year}.pdf");
    //     // return $pdf->download("milk-bill-{$month}-{$year}.pdf");
    // }

    public function download_pdf(Request $request)
    {
        $customerIds = $request->input('customer_ids', []);
        $month = $request->input('month');
        $year = $request->input('year');

        if (!$month || !$year) {
            return back()->with('error', 'Please select both month and year.');
        }

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $customers = Customer::whereIn('id', $customerIds)->get();

        $rates = RateMaster::latest('id')
            ->get()
            ->pluck('rate', 'rate_type') // ['cow' => 60, 'bufflo' => 70]
            ->mapWithKeys(fn($rate, $type) => [strtolower($type) => $rate]);

        $data = $customers->map(function ($customer) use ($startDate, $endDate, $rates) {
            $deliveries = MilkDelivery::where('customer_id', $customer->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            if ($deliveries->isEmpty()) {
                return null; // Skip customers with no data
            }

            $grouped = $deliveries->groupBy(fn($d) => strtolower($d->type));
            $products = [];

            foreach ($grouped as $type => $entries) {
                $totalWeight = $entries->sum('weight');

                $shares = match ($totalWeight) {
                    0.25 => 0.5,
                    0.5 => 1,
                    0.75 => 1.5,
                    1 => 2,
                    default => $totalWeight * 2,
                };

                $rate = $rates[$type] ?? 0;
                $amount = $shares * ($rate / 2);

                $products[] = [
                    'type' => Str::title($type),
                    'weight' => $totalWeight,
                    'shares' => $shares,
                    'rate' => $rate,
                    'total' => $amount,
                ];
            }

            return [
                'customer' => $customer,
                'products' => $products,
                'startDate' => $startDate->format('d-m-Y'),
                'endDate' => $endDate->format('d-m-Y'),
            ];
        })->filter(); // Filter out nulls

        if ($data->isEmpty()) {
            return back()->with('error', 'No milk delivery records found for the selected customers.');
        }

        $pdf = Pdf::loadView('monthly-reports.pdf-view', compact('data'))->setPaper('a4');
        return $pdf->stream("milk-bill-{$month}-{$year}.pdf");
    }
}
