@extends('layouts.index')
@section('title', '10-Day Dairy Reports')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">10-Day Periodic Dairy Reports ({{ \Carbon\Carbon::now()->format('F Y') }})
                        </h1>
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
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {!! implode('<br>', $errors->all()) !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Filter By Date</h3>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('milk_dairy.ten_days_reports') }}" id="filterForm">
                            <div class="form-row">
                                <div class="col-sm-6 col-md-3 mb-2">
                                    <label>Start Date</label>
                                    <input type="date" name="start_date"
                                        value="{{ old('start_date', $startDate->format('d-m-Y')) }}"
                                        class="form-control @error('start_date') is-invalid @enderror">
                                </div>
                                <div class="col-sm-6 col-md-3 mb-2">
                                    <label>End Date</label>
                                    <input type="date" name="end_date"
                                        value="{{ old('end_date', $endDate->format('d-m-Y')) }}"
                                        class="form-control @error('end_date') is-invalid @enderror">
                                </div>
                                <div class="col-sm-12 col-md-2 mb-2 align-self-end">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @foreach (['1-10', '11-20', '21-end'] as $period)
                    @php $records = $grouped->get($period, collect()); @endphp

                    <div class="card card-outline card-success mb-4">
                        <div class="card-header">
                            <h3 class="card-title">From {{ $startDate->format('d-m-Y') }} to
                                {{ $endDate->format('d-m-Y') }}
                            </h3>
                        </div>

                        @if ($records->isEmpty())
                            <div class="card-body">
                                <p class="mb-0">No records found.</p>
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
                            @endphp
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover mb-0 datatable">
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
                                            @foreach ($records as $index => $entry)
                                                @php
                                                    $amount = (float) $entry->amount;
                                                    $total += $amount;
                                                @endphp
                                                <tr>
                                                    <td>{{ $entry->id }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($entry->created_at)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ $entry->customer_no_in_dairy }}</td>
                                                    <td>{{ ucfirst($entry->shift) }}</td>
                                                    <td>{{ $entry->milk_weight }}</td>
                                                    <td>{{ $entry->fat_in_percentage }}</td>
                                                    <td>{{ $entry->rate_per_liter }}</td>
                                                    <td>{{ number_format($amount, 2) }}</td>
                                                    <td>{{ number_format($runningTotal[$entry->id] ?? 0, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="font-weight-bold bg-light">
                                            @php
                                                $milkTotal = $records->sum('milk_weight');
                                                $fatAvg = $records->avg('fat_in_percentage');
                                                $rateAvg = $records->avg('rate_per_liter');
                                                $amountTotal = $records->sum('amount');
                                            @endphp
                                            <tr>
                                                <td colspan="4" class="text-center">Totals / Averages</td>
                                                <td>{{ number_format($milkTotal, 2) }}</td>
                                                <td>{{ number_format($fatAvg, 2) }}</td>
                                                <td>{{ number_format($rateAvg, 2) }}</td>
                                                <td>{{ number_format($amountTotal, 2) }}</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
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
        (function($) {
            'use strict';
            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'desc']
                ],
                pageLength: 10,
                responsive: true,
                language: {
                    searchPlaceholder: 'Search records…',
                    search: ''
                }
            });

            $('.datatable').DataTable();


            $.validator.setDefaults({
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                highlight: el => $(el).addClass('is-invalid'),
                unhighlight: el => $(el).removeClass('is-invalid'),
                errorPlacement: (err, el) => err.insertAfter(el)
            });

            $.validator.addMethod(
                'endAfterStart',
                (value, element, param) => {
                    const start = $(param).val();
                    return !start || !value || new Date(value) >= new Date(start);
                },
                'End date must be the same as or after the start date.'
            );

            $('#filterForm').validate({
                rules: {
                    start_date: {
                        required: true,
                        date: true
                    },
                    end_date: {
                        required: true,
                        date: true,
                        endAfterStart: '[name="start_date"]'
                    }
                },
                messages: {
                    start_date: {
                        required: 'Select a start date'
                    },
                    end_date: {
                        required: 'Select an end date',
                        endAfterStart: 'End date can’t be before start date'
                    }
                }
            });

        })(jQuery);
    </script>
@endpush
