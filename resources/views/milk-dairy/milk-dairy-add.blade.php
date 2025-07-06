@extends('layouts.index')
@section('title', 'Add Milk Dairy Daily Report')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Add Milk Dairy Daily Report</h1>
                <ol class="breadcrumb bg-transparent mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Add Milk Dairy Daily Report</li>
                </ol>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Milk Dairy Daily Details</h3>
                    </div>

                    <form method="POST" action="{{ route('milk_dairy.store') }}" id="milkDairyForm">
                        @csrf
                        <div class="card-body p-0">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th style="width:20%">Customer No. in Dairy</th>
                                        <td>
                                            <input type="number" name="customer_no_in_dairy" id="customer_no_in_dairy"
                                                class="form-control @error('customer_no_in_dairy') is-invalid @enderror"
                                                placeholder="Enter Dairy Customer No." />
                                            <div id="customer_name" class="text-success font-weight-bold small mt-1"></div>
                                            @error('customer_no_in_dairy')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Date</th>
                                        <td>
                                            <input type="date" name="created_at" id="created_at"
                                                class="form-control @error('created_at') is-invalid @enderror"
                                                value="{{ old('created_at', now()->toDateString()) }}"
                                                max="{{ now()->toDateString() }}" autocomplete="off">
                                            @error('created_at')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Shift</th>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="shift" id="morning"
                                                    value="Morning"
                                                    {{ old('shift', 'Morning') == 'Morning' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="morning">Morning</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="shift" id="evening"
                                                    value="Evening" {{ old('shift') == 'Evening' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evening">Evening</label>
                                            </div>
                                            @error('shift')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Milk Weight (L)</th>
                                        <td>
                                            <input type="number" step="0.01" min="0.01" name="milk_weight"
                                                id="milk_weight"
                                                class="form-control @error('milk_weight') is-invalid @enderror"
                                                placeholder="0.00" />
                                            @error('milk_weight')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Fat %</th>
                                        <td>
                                            <input type="number" step="0.1" min="0" name="fat_in_percentage"
                                                id="fat_in_percentage"
                                                class="form-control @error('fat_in_percentage') is-invalid @enderror"
                                                placeholder="e.g. 4.5" />
                                            @error('fat_in_percentage')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Rate (₹ / L)</th>
                                        <td>
                                            <input type="number" step="0.01" min="0" name="rate_per_liter"
                                                id="rate_per_liter"
                                                class="form-control @error('rate_per_liter') is-invalid @enderror"
                                                placeholder="0.00" />
                                            @error('rate_per_liter')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Amount (₹)</th>
                                        <td>
                                            <input type="text" name="amount" id="amount" class="form-control"
                                                readonly>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Total Amount (₹)</th>
                                        <td>
                                            <input type="text" name="total_amount" id="total_amount" class="form-control"
                                                readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('milk_dairy.summary') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {

            // /* ---------- live totals (your existing logic) ---------- */
            let prevTotal = 0;

            $('#customer_no_in_dairy').on('input', function() {
                const cust = $(this).val();
                if (!cust) return;

                $.post('{{ route('milk_dairy.prev_total') }}', {
                    customer_no: cust,
                    _token: '{{ csrf_token() }}'
                }).done(res => {
                    prevTotal = parseFloat(res.total) || 0;
                    computeTotals();
                });
            });

            // compute new amount & total
            ['milk_weight', 'rate_per_liter'].forEach(id =>
                $('#' + id).on('input', computeTotals)
            );

            function computeTotals() {
                const w = parseFloat($('#milk_weight').val()) || 0;
                const r = parseFloat($('#rate_per_liter').val()) || 0;
                const amt = w * r;

                $('#amount').val(amt ? amt.toFixed(2) : '');
                $('#total_amount').val(amt ? (prevTotal + amt).toFixed(2) : '');
            }
            $.validator.addMethod("notFutureDate", function(value, element) {
                const today = new Date().toISOString().split('T')[0]; // 'YYYY-MM-DD'
                return value <= today;
            }, "Date cannot be in the future.");

            /* ---------- jQuery Validation rules & messages ---------- */
            $('#milkDairyForm').validate({
                ignore: ':hidden', // validate radio group too
                errorClass: 'text-danger small',
                errorElement: 'div',

                // where to place radio‑group errors
                errorPlacement: function(error, element) {
                    element.attr('name') === 'shift' ?
                        error.insertAfter(element.closest('td')) :
                        error.insertAfter(element);
                },

                highlight: el => $(el).addClass('is-invalid'),
                unhighlight: el => $(el).removeClass('is-invalid'),

                rules: {
                    created_at: {
                        required: true,
                        dateISO: true,
                        notFutureDate: true
                    },
                    customer_no_in_dairy: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    shift: {
                        required: true
                    },
                    milk_weight: {
                        required: true,
                        number: true,
                        min: 0.01
                    },
                    fat_in_percentage: {
                        required: true,
                        number: true,
                        min: 0,
                        max: 15
                    },
                    rate_per_liter: {
                        required: true,
                        number: true,
                        min: 0
                    }
                },

                messages: {
                    created_at: {
                        required: 'Date is required.',
                        dateISO: 'Use a valid date (YYYY-MM-DD).',
                        notFutureDate: 'Date cannot be in the future.'
                    },
                    customer_no_in_dairy: {
                        required: 'Customer number is required.',
                        number: 'Customer number must be a numeric value.',
                        min: 'Customer number must be at least 1.'
                    },
                    shift: {
                        required: 'Please select a shift.'
                    },
                    milk_weight: {
                        required: 'Milk weight is required.',
                        number: 'Enter a valid number.',
                        min: 'Weight must be greater than 0.'
                    },
                    fat_in_percentage: {
                        required: 'Fat percentage is required.',
                        number: 'Enter a valid number.',
                        min: 'Must be 0 or more.',
                        max: 'Unlikely to exceed 15 %.'
                    },
                    rate_per_liter: {
                        required: 'Rate per litre is required.',
                        number: 'Enter a valid number.',
                        min: 'Rate cannot be negative.'
                    }
                }
            });

        })();
    </script>
@endpush
