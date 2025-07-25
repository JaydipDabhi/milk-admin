@extends('layouts.index')
@section('title', 'Monthly Report')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-clipboard-list"></i> Customer Monthly Milk Delivery Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i>
                                    Home</a></li>
                            <li class="breadcrumb-item active">Customer Monthly Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-filter"></i> Filter by Customer</h3>
                    </div>
                    <form method="GET" action="{{ route('reports.generate_monthly_report') }}" id="monthlyForm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="customer_id">Customer</label>
                                        <select name="customer_id"
                                            class="form-control select2 @error('customer_id') is-invalid @enderror">
                                            <option value="">-- Select Customer --</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->id }} - {{ $customer->customer_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="month">Month</label>
                                        <select name="month"
                                            class="form-control select2 @error('month') is-invalid @enderror">
                                            <option value="">-- Select Month --</option>
                                            @foreach ($availableMonths as $m)
                                                <option value="{{ $m }}"
                                                    {{ request('month') == $m ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('month')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="year">Year</label>
                                        <select name="year"
                                            class="form-control select2 @error('year') is-invalid @enderror">
                                            <option value="">-- Select Year --</option>
                                            @foreach ($availableYears as $y)
                                                <option value="{{ $y }}"
                                                    {{ request('year') == $y ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('year')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-chart-line"></i> Generate Report
                            </button>
                        </div>
                    </form>
                </div>

                @if ($deliveries->isNotEmpty())
                    @isset($selectedCustomer)
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user"></i> Summary for {{ $selectedCustomer->customer_name }} –
                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}
                                </h3>
                            </div>
                            <div class="card-body">
                                @php
                                    $typeSummary = [];

                                    foreach ($deliveries as $d) {
                                        $type = strtolower($d->type);
                                        $typeSummary[$type]['weight'] =
                                            ($typeSummary[$type]['weight'] ?? 0) + $d->weight;
                                        $typeSummary[$type]['amount'] =
                                            ($typeSummary[$type]['amount'] ?? 0) + $d->total_rate;

                                        if (!in_array($type, ['ghee', 'butter'])) {
                                            if ($d->weight == 0.25) {
                                                $shares = 0.5;
                                            } elseif ($d->weight == 0.5) {
                                                $shares = 1.0;
                                            } elseif ($d->weight == 0.75) {
                                                $shares = 1.5;
                                            } elseif ($d->weight == 1.0) {
                                                $shares = 2.0;
                                            } else {
                                                $shares = $d->weight * 2;
                                            }

                                            $typeSummary[$type]['shares'] =
                                                ($typeSummary[$type]['shares'] ?? 0) + $shares;
                                        }
                                    }

                                    $grandAmount = array_sum(array_column($typeSummary, 'amount'));
                                @endphp

                                @foreach ($typeSummary as $type => $info)
                                    @php
                                        $unit = in_array($type, ['ghee', 'butter']) ? 'kg' : 'liters';
                                    @endphp
                                    <p>
                                        <strong>{{ ucfirst($type) }}:</strong>
                                        {{ number_format($info['weight'], 2) }} {{ $unit }}
                                        @if (!in_array($type, ['ghee', 'butter']))
                                            ({{ number_format($info['shares'], 1) }} shares)
                                        @endif
                                        – ₹{{ number_format($info['amount'], 2) }}
                                    </p>
                                @endforeach

                                <p><strong>Grand Total Amount:</strong> ₹{{ number_format($grandAmount, 2) }}</p>
                            </div>
                        </div>
                    @endisset
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i> No delivery records found for this customer in the selected month
                        and year.
                    </div>
                @endif

                @if ($deliveries->isNotEmpty())
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white"><i class="fas fa-list"></i> Detailed Deliveries</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Weight (liters)</th>
                                        <th>Rate (₹)</th>
                                        <th>Total (₹)</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalWeight = 0;
                                        $totalShares = 0;
                                        $grandTotal = 0;
                                    @endphp
                                    @foreach ($deliveries as $entry)
                                        @php
                                            $weight = $entry->weight;
                                            $rate = $entry->rate;
                                            $amount = $entry->total_rate;
                                            $totalWeight += $weight;
                                            $grandTotal += $amount;

                                            if ($weight == 0.25) {
                                                $shares = 0.5;
                                            } elseif ($weight == 0.5) {
                                                $shares = 1.0;
                                            } elseif ($weight == 0.75) {
                                                $shares = 1.5;
                                            } elseif ($weight == 1.0) {
                                                $shares = 2.0;
                                            } else {
                                                $shares = $weight * 2;
                                            }

                                            $totalShares += $shares;
                                        @endphp
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($entry->created_at)->format('d-m-Y') }}</td>
                                            <td>{{ ucfirst($entry->type) }}</td>
                                            <td>
                                                @php
                                                    $unit = in_array(strtolower($entry->type), ['ghee', 'butter'])
                                                        ? 'Kg'
                                                        : 'L';
                                                @endphp
                                                {{ number_format($weight, 2) }} {{ $unit }}
                                                @if (!in_array(strtolower($entry->type), ['ghee', 'butter']))
                                                    ({{ number_format($shares, 1) }} shares)
                                                @endif
                                            </td>
                                            <td>₹{{ number_format($rate, 2) }}</td>
                                            <td>₹{{ number_format($amount, 2) }}</td>
                                            <td>{{ $entry->time }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                @php
                                    $typeSummary = [];

                                    foreach ($deliveries as $d) {
                                        $type = strtolower($d->type);
                                        $typeSummary[$type]['weight'] =
                                            ($typeSummary[$type]['weight'] ?? 0) + $d->weight;
                                        $typeSummary[$type]['amount'] =
                                            ($typeSummary[$type]['amount'] ?? 0) + $d->total_rate;

                                        // Shares for non-kg items only
                                        if (!in_array($type, ['ghee', 'butter'])) {
                                            if ($d->weight == 0.25) {
                                                $shares = 0.5;
                                            } elseif ($d->weight == 0.5) {
                                                $shares = 1.0;
                                            } elseif ($d->weight == 0.75) {
                                                $shares = 1.5;
                                            } elseif ($d->weight == 1.0) {
                                                $shares = 2.0;
                                            } else {
                                                $shares = $d->weight * 2;
                                            }
                                            $typeSummary[$type]['shares'] =
                                                ($typeSummary[$type]['shares'] ?? 0) + $shares;
                                        }
                                    }

                                    $grandTotal = array_sum(array_column($typeSummary, 'amount'));
                                @endphp

                                <tfoot class="bg-light">
                                    <tr>
                                        <th colspan="2" class="text-right">Total:</th>
                                        <th colspan="2">
                                            @foreach ($typeSummary as $type => $info)
                                                @php
                                                    $unit = in_array($type, ['ghee', 'butter']) ? 'Kg' : 'L';
                                                    $label = ucfirst($type);
                                                @endphp
                                                {{ $label }}: {{ number_format($info['weight'], 2) }}
                                                {{ $unit }}
                                                @if (!in_array($type, ['ghee', 'butter']) && isset($info['shares']))
                                                    ({{ number_format($info['shares'], 1) }} shares)
                                                @endif
                                                <br>
                                            @endforeach
                                        </th>
                                        <th colspan="2">₹{{ number_format($grandTotal, 2) }}</th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            // jQuery Validation for the filter form
            $('#monthlyForm').first().validate({
                rules: {
                    customer_id: {
                        required: true
                    },
                    month: {
                        required: true,
                        digits: true,
                        min: 1,
                        max: 12
                    },
                    year: {
                        required: true,
                        digits: true,
                        min: 2020,
                        max: new Date().getFullYear()
                    }
                },
                messages: {
                    customer_id: {
                        required: "Please select a customer"
                    },
                    month: {
                        required: "Please select a month",
                        digits: "Invalid month format",
                        min: "Invalid month",
                        max: "Invalid month"
                    },
                    year: {
                        required: "Please select a year",
                        digits: "Invalid year format",
                        min: "Year must be 2020 or later",
                        max: "Year cannot be in the future"
                    }
                },
                errorElement: 'span',
                errorClass: 'text-danger',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
@endpush
