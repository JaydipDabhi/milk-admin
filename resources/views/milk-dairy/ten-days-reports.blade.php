@extends('layouts.index')
@section('title', '10-Day Dairy Reports')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-chart-bar mr-1"></i> 10-Day Dairy Reports</h1>
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">10 Days Dairy Reports</li>
                </ol>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                {{-- Alerts --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {!! implode('<br>', $errors->all()) !!}
                    </div>
                @endif

                {{-- Filter Form --}}
                <div class="card card-primary shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filter by Date</h3>
                    </div>
                    <form method="GET" action="{{ route('milk_dairy.ten_days_reports') }}" id="filterForm">
                        <div class="card-body">
                            <div class="form-row align-items-end">
                                <div class="form-group col-md-4">
                                    <label>Start Date</label>
                                    <input type="date" name="start_date" value="{{ $startDate->format('d-m-Y') }}"
                                        class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>End Date</label>
                                    <input type="date" name="end_date" value="{{ $endDate->format('d-m-Y') }}"
                                        class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-search mr-1"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Periodic Summaries --}}
                @foreach (['1-10', '11-20', '21-end'] as $period)
                    @php $records = $grouped->get($period, collect()); @endphp

                    <div class="card card-outline card-info mt-4">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <h5 class="card-title mb-0"><i class="fas fa-calendar-alt mr-1"></i> Period:
                                        {{ $period }}</h5>
                                </div>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if ($records->isEmpty())
                            <div class="card-body text-muted">
                                <p><i class="fas fa-info-circle"></i> No records found for this period.</p>
                            </div>
                        @else
                            @php
                                $sorted = $records->sortBy('created_at')->values();
                                $runningTotal = [];
                                $total = 0;
                                foreach ($sorted as $entry) {
                                    $total += (float) $entry->amount;
                                    $runningTotal[$entry->id] = $total;
                                }
                                $records = $sorted->sortByDesc('created_at')->values();
                                $milkTotal = $records->sum('milk_weight');
                                $fatAvg = $records->avg('fat_in_percentage');
                                $rateAvg = $records->avg('rate_per_liter');
                                $amountTotal = $records->sum('amount');
                            @endphp

                            <div class="card-body">
                                {{-- Summary Boxes --}}
                                <div class="row text-center mb-3">
                                    <div class="col-md-3">
                                        <div class="info-box bg-light">
                                            <span class="info-box-icon bg-info"><i class="fas fa-tint"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Milk</span>
                                                <span class="info-box-number">{{ number_format($milkTotal, 2) }} L</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box bg-light">
                                            <span class="info-box-icon bg-success"><i class="fas fa-percent"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Avg Fat</span>
                                                <span class="info-box-number">{{ number_format($fatAvg, 2) }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box bg-light">
                                            <span class="info-box-icon bg-warning"><i class="fas fa-rupee-sign"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Avg Rate/L</span>
                                                <span class="info-box-number">₹{{ number_format($rateAvg, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-box bg-light">
                                            <span class="info-box-icon bg-danger"><i class="fas fa-wallet"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total ₹</span>
                                                <span class="info-box-number">₹{{ number_format($amountTotal, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Table --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm table-hover text-center mb-0 datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Customer</th>
                                                <th>Shift</th>
                                                <th>Milk (L)</th>
                                                <th>Fat %</th>
                                                <th>Rate/L</th>
                                                <th>Amount</th>
                                                <th>Running ₹</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($records as $entry)
                                                <tr>
                                                    <td>{{ $entry->id }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($entry->created_at)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ $entry->customer_no_in_dairy }}</td>
                                                    <td>{{ ucfirst($entry->shift) }}</td>
                                                    <td>{{ $entry->milk_weight }}</td>
                                                    <td>{{ $entry->fat_in_percentage }}</td>
                                                    <td>{{ $entry->rate_per_liter }}</td>
                                                    <td>{{ number_format($entry->amount, 2) }}</td>
                                                    <td>{{ number_format($runningTotal[$entry->id] ?? 0, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $('.datatable').DataTable({
            pageLength: 10,
            ordering: true,
            order: [
                [1, 'desc']
            ],
            responsive: true
        });
    </script>
@endpush
