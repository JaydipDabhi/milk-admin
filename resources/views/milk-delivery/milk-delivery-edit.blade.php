@extends('layouts.index')
@section('title', 'Edit Milk Delivery')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Milk Delivery</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Milk Delivery</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @php
                    $alerts = [
                        'error' => 'error',
                        'success' => 'success',
                    ];
                @endphp

                @foreach ($alerts as $key => $type)
                    @if (session($key))
                        <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                            {{ session($key) }}
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        </div>
                    @endif
                @endforeach
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Milk Delivery</h3>
                            </div>
                            <form method="POST" action="{{ route('admin.milk_delivery_update', $delivery->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="customer_id">Customer Number</label>
                                        <input type="number" class="form-control" id="customer_id" name="customer_id"
                                            value="{{ $delivery->customer_id }}" placeholder="Enter Customer Number">
                                        <div id="customer_name" class="text-success font-weight-bold mt-2">
                                            {{ $delivery->customer->customer_name ?? 'N/A' }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="weight">Weight (in liters)</label>
                                        <input type="number" class="form-control" id="weight" name="weight"
                                            value="{{ $delivery->weight }}" step="0.01" min="0">
                                    </div>

                                    <div class="form-group">
                                        <label for="delivery_date">Delivery Date</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="delivery_date" id="delivery_date"
                                                class="form-control datetimepicker-input" data-target="#reservationdate"
                                                value="{{ optional($delivery->created_at)->format('d-m-Y') }}" />
                                            <div class="input-group-append" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="type">Type (Cow/Buffalo)</label>
                                        <input type="text" class="form-control" id="type" name="type"
                                            value="{{ $delivery->type }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="rate">Rate</label>
                                        <input type="text" class="form-control" id="rate" name="rate"
                                            value="{{ $delivery->rate }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="total_rate">Total Rate</label>
                                        <input type="text" class="form-control" id="total_rate" name="total_rate"
                                            value="{{ $delivery->total_rate }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Time</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="time" id="morning"
                                                value="Morning" {{ $delivery->time == 'Morning' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="morning">Morning</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="time" id="evening"
                                                value="Evening" {{ $delivery->time == 'Evening' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="evening">Evening</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ route('admin.milk_delivery_list') }}"
                                        class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        jQuery(document).ready(function() {
            let rate = parseFloat($("#rate").val()) || 0;

            $("#customer_id").on("input", function() {
                let customerId = $(this).val().trim();
                if (customerId.length > 0) {
                    $.ajax({
                        url: "{{ route('admin.get.customer.info') }}",
                        type: "GET",
                        data: {
                            customer_id: customerId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $("#customer_name").text(response.name).removeClass("text-danger")
                                .addClass("text-success");
                            $("#type").val(response.type);
                            $("#rate").val(response.rate);
                            rate = parseFloat(response.rate) || 0;
                            calculateTotal();
                        },
                        error: function() {
                            $("#customer_name").text("Customer not found").removeClass(
                                "text-success").addClass("text-danger");
                            $("#type, #rate, #total_rate").val("");
                            rate = 0;
                        }
                    });
                }
            });

            $("#weight").on("input", function() {
                calculateTotal();
            });

            function calculateTotal() {
                let weight = parseFloat($("#weight").val()) || 0;
                let total = rate * weight;
                $("#total_rate").val(total.toFixed(2));
            }
        });
    </script>
@endpush
