{{-- @extends('layouts.index')
@section('title', '10-Day Dairy Reports')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>10-Day Periodic Dairy Reports ({{ \Carbon\Carbon::now()->format('F Y') }})</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">10 Days Dairy Reports</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <form method="GET" action="{{ route('milk_dairy.ten_days_reports') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ request('start_date') ?? $startDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ request('end_date') ?? $endDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            @foreach (['1-10', '11-20', '21-end'] as $period)
                @php
                    $records = $grouped->get($period, collect());
                @endphp

                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">From {{ $startDate->format('d-m-Y') }} to
                            {{ $endDate->format('d-m-Y') }}</h5>
                    </div>

                    @if ($records->isEmpty())
                        <div class="p-3">No records found.</div>
                    @else
                        <div class="card-body">
                            <table class="table table-bordered table-striped mb-0" id="example1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer No</th>
                                        <th>Shift</th>
                                        <th>Milk (L)</th>
                                        <th>Fat %</th>
                                        <th>Rate/L (₹)</th>
                                        <th>Amount (₹)</th>
                                        <th>Total ₹</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach ($records as $index => $entry)
                                        @php
                                            $amount = (float) $entry->amount;
                                            $total += $amount;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $entry->customer_no_in_dairy }}</td>
                                            <td>{{ ucfirst($entry->shift) }}</td>
                                            <td>{{ $entry->milk_weight }}</td>
                                            <td>{{ $entry->fat_in_percentage }}</td>
                                            <td>{{ $entry->rate_per_liter }}</td>
                                            <td>{{ number_format($amount, 2) }}</td>
                                            <td>{{ number_format($total, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($entry->created_at)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endforeach
        </section>
    </div>
@endsection --}}
@extends('layouts.index')
@section('title', '10-Day Dairy Reports')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12 col-md-6">
                        <h1 class="m-0">10-Day Periodic Dairy Reports ({{ \Carbon\Carbon::now()->format('F Y') }})</h1>
                    </div>
                    <div class="col-12 col-md-6 text-md-right">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">10 Days Dairy Reports</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            {{-- Date Filter Form --}}
            <form method="GET" action="{{ route('milk_dairy.ten_days_reports') }}" class="mb-4">
                <div class="form-row">
                    <div class="col-sm-6 col-md-3 mb-2">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ request('start_date') ?? $startDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-sm-6 col-md-3 mb-2">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ request('end_date') ?? $endDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-sm-12 col-md-2 mb-2 align-self-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>

            {{-- Report Tables --}}
            @foreach (['1-10', '11-20', '21-end'] as $period)
                @php $records = $grouped->get($period, collect()); @endphp

                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            Period: {{ $period }} — From {{ $startDate->format('d-m-Y') }} to
                            {{ $endDate->format('d-m-Y') }}
                        </h5>
                    </div>

                    @if ($records->isEmpty())
                        <div class="p-3">No records found.</div>
                    @else
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Customer No</th>
                                            <th>Shift</th>
                                            <th>Milk (L)</th>
                                            <th>Fat %</th>
                                            <th>Rate/L (₹)</th>
                                            <th>Amount (₹)</th>
                                            <th>Total ₹</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach ($records as $index => $entry)
                                            @php
                                                $amount = (float) $entry->amount;
                                                $total += $amount;
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($entry->created_at)->format('d-m-Y') }}</td>
                                                <td>{{ $entry->customer_no_in_dairy }}</td>
                                                <td>{{ ucfirst($entry->shift) }}</td>
                                                <td>{{ $entry->milk_weight }}</td>
                                                <td>{{ $entry->fat_in_percentage }}</td>
                                                <td>{{ $entry->rate_per_liter }}</td>
                                                <td>{{ number_format($amount, 2) }}</td>
                                                <td>{{ number_format($total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </section>
    </div>
@endsection
