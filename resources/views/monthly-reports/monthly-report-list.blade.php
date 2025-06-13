@extends('layouts.index')
@section('title', 'Customer Monthly Report')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Customer Monthly Milk Delivery Report</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                {{-- Filter Form --}}
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Filter by Customer</h3>
                    </div>
                    <form method="GET" action="{{ route('reports.monthly.generate') }}">
                        <div class="card-body">
                            {{-- Customer --}}
                            <div class="form-group">
                                <label for="customer_id">Customer</label>
                                <select name="customer_id" class="form-control select2" required>
                                    <option value="">-- Select Customer --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->id }} - {{ $customer->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Month --}}
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select name="month" class="form-control" required>
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Year --}}
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select name="year" class="form-control" required>
                                    @for ($y = now()->year; $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </form>
                </div>

                {{-- Summary --}}
                @isset($selectedCustomer)
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Summary for {{ $selectedCustomer->name }} -
                                {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Total Milk:</strong> {{ number_format($totalMilk, 2) }} liters</p>
                            <p><strong>Total Amount:</strong> ₹{{ number_format($totalAmount, 2) }}</p>
                        </div>
                    </div>
                @endisset

                {{-- Detailed Table --}}
                @if (!empty($deliveries))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detailed Deliveries</h3>
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
                                    @foreach ($deliveries as $entry)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($entry->created_at)->format('d M Y') }}</td>
                                            <td>{{ $entry->type }}</td>
                                            <td>{{ number_format($entry->weight, 2) }}</td>
                                            <td>₹{{ number_format($entry->rate, 2) }}</td>
                                            <td>₹{{ number_format($entry->total_rate, 2) }}</td>
                                            <td>{{ $entry->time }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Weight (liters)</th>
                                        <th>Rate (₹)</th>
                                        <th>Total (₹)</th>
                                        <th>Time</th>
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
