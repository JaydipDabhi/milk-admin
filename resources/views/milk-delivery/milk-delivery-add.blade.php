@extends('layouts.index')
@section('title', 'Milk Delivery')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Milk Delivery</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Milk Delivery</li>
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
                                <h3 class="card-title">Add Milk Delivery</h3>
                            </div>
                            <form method="POST" action="{{ route('admin.admin.milk_delivery_store') }}" id="milkAddForm">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="customer_id">Customer Number</label>
                                        <input type="number"
                                            class="form-control @error('customer_id') is-invalid @enderror" id="customer_id"
                                            name="customer_id" placeholder="Enter Customer Number">
                                        <div id="customer_name" class="text-success font-weight-bold mt-2"></div>
                                        @error('customer_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="weight">Weight (in liters)</label>
                                        <input type="number" class="form-control @error('weight') is-invalid @enderror"
                                            id="weight" name="weight" placeholder="Enter Weight (in liters)"
                                            step="0.01" min="0">
                                        @error('weight')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="delivery_date">Delivery Date</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="delivery_date" id="delivery_date"
                                                class="form-control datetimepicker-input @error('delivery_date') is-invalid @enderror"
                                                data-target="#reservationdate" placeholder="Select a Delivery Date" />
                                            <div class="input-group-append" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('delivery_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="time" id="morning"
                                                value="Morning" {{ old('time') == 'Morning' ? 'checked' : '' }}>
                                            <label class="form-check-label">Morning</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="time" id="evening"
                                                value="Evening" {{ old('time') == 'Evening' ? 'checked' : '' }}>
                                            <label class="form-check-label">Evening</label>
                                        </div>
                                        @error('time')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}

                                    <div class="form-group">
                                        <label>Time</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="time" id="morning"
                                                value="Morning" {{ old('time') == 'Morning' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="morning">Morning</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="time" id="evening"
                                                value="Evening" {{ old('time') == 'Evening' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="evening">Evening</label>
                                        </div>
                                        @error('time')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="type">Type (Cow/Buffalo)</label>
                                        <input type="text" class="form-control" id="type" name="type" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="rate">Rate</label>
                                        <input type="text" class="form-control" id="rate" name="rate" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="total_rate">Total Rate</label>
                                        <input type="text" class="form-control" id="total_rate" name="total_rate"
                                            disabled>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
            let rate = 0;
            jQuery("#customer_id").on("input", function() {
                let customerId = jQuery(this).val().trim();
                if (customerId.length > 0) {
                    $.ajax({
                        url: "{{ route('admin.get.customer.info') }}",
                        type: "GET",
                        data: {
                            _token: "{{ csrf_token() }}",
                            customer_id: customerId,
                        },
                        success: function(response) {
                            $("#customer_name").text(response.name).removeClass("text-danger")
                                .addClass("text-success");
                            $("#type").val(response.type);
                            $("#rate").val(response.rate);
                            rate = parseFloat(response.rate) || 0;
                            $("#rate-section").show();
                            calculateTotal();
                        },
                        error: function(xhr) {
                            $("#customer_name").text("Customer not found").removeClass(
                                "text-success").addClass("text-danger");
                            $("#type, #rate, #total_rate, #weight").val("");
                            $("#rate-section").hide();
                            rate = 0;
                        },
                    });
                } else {
                    $("#customer_name").text("");
                    $("#type, #rate, #total_rate, #weight").val("");
                    $("#rate-section").hide();
                    rate = 0;
                }
            });

            jQuery("#weight").on("input", function() {
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
