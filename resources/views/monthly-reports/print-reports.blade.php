@extends('layouts.index')
@section('title', 'Print Reports')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <form method="GET" action="{{ route('reports.print_reports') }}">
                <div class="card card-info">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Select Customers to Print</h3>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-print"></i> Print Selected
                        </button>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select_all">
                                <label class="form-check-label font-weight-bold" for="select_all">
                                    All Customers
                                </label>
                            </div>
                        </div>

                        @foreach (App\Models\Customer::all() as $cust)
                            <div class="col-md-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input customer-checkbox" type="checkbox" name="customer_ids[]"
                                        value="{{ $cust->id }}" id="cust_{{ $cust->id }}">
                                    <label class="form-check-label" for="cust_{{ $cust->id }}">
                                        {{ $cust->customer_name }} (ID: {{ $cust->id }})
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#select_all').on('change', function() {
                let isChecked = $(this).is(':checked');
                $('.customer-checkbox').prop('checked', isChecked);
            });

            $('.customer-checkbox').on('change', function() {
                let total = $('.customer-checkbox').length;
                let checked = $('.customer-checkbox:checked').length;
                $('#select_all').prop('checked', total === checked);
            });
        });
    </script>
@endpush
