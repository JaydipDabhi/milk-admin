@extends('layouts.index')
@section('title', 'Print Reports')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Print Reports</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Print Reports</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form method="GET" action="{{ route('reports.print_reports_pdf') }}">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <div class="row w-100 align-items-center">
                                <div class="col-md-6">
                                    <h3 class="card-title">
                                        <i class="fas fa-print mr-2"></i> Generate Customer PDF Reports
                                    </h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-file-pdf mr-1"></i> Download PDF
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="form-row align-items-end mb-4">
                                <div class="col-md-4">
                                    <label for="month" class="font-weight-bold">Select Month</label>
                                    <select class="form-control select2" name="month" id="month" required>
                                        @foreach (range(1, 12) as $m)
                                            <option value="{{ $m }}"
                                                {{ request('month') == $m ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="year" class="font-weight-bold">Select Year</label>
                                    <select class="form-control select2" name="year" id="year" required>
                                        @for ($y = date('Y'); $y >= 2020; $y--)
                                            <option value="{{ $y }}"
                                                {{ request('year') == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-4 mt-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="select_all">
                                        <label class="form-check-label font-weight-bold" for="select_all">
                                            <i class="fas fa-check-double text-primary mr-1"></i> Select All Customers
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @foreach (App\Models\Customer::all() as $cust)
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <div class="card card-light shadow-sm mb-3">
                                            <div class="card-body py-2 px-3">
                                                <div class="form-check">
                                                    <input class="form-check-input customer-checkbox" type="checkbox"
                                                        name="customer_ids[]" value="{{ $cust->id }}"
                                                        id="cust_{{ $cust->id }}">
                                                    <label class="form-check-label" for="cust_{{ $cust->id }}">
                                                        {{ $cust->customer_name }}
                                                        <br><small class="text-muted">ID: {{ $cust->id }}</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#select_all').on('change', function() {
                $('.customer-checkbox').prop('checked', this.checked);
            });

            $('.customer-checkbox').on('change', function() {
                $('#select_all').prop('checked',
                    $('.customer-checkbox:checked').length === $('.customer-checkbox').length
                );
            });
        });
    </script>
@endpush
