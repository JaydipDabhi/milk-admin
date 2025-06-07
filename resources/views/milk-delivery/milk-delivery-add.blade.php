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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Milk Delivery</h3>
                            </div>
                            <form method="POST" action="#">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="customer_id">Customer Number</label>
                                        <input type="number" class="form-control" id="customer_id" name="customer_id"
                                            placeholder="Enter Customer Number">
                                        <div id="customer_name" class="text-success font-weight-bold mt-2"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="weight">Weight (in liters)</label>
                                        <input type="number" class="form-control" id="weight" name="weight"
                                            placeholder="Enter Weight (in liters)" step="0.1" min="0">
                                    </div>

                                    <div class="form-group">
                                        <label for="type">Type (Cow/Buffalo)</label>
                                        <input type="text" class="form-control" id="type" name="type"
                                            placeholder="Cow" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="rate">Rate</label>
                                        <input type="text" class="form-control" id="rate" name="rate"
                                            placeholder="60 / Liter" disabled>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="time" id="morning"
                                                value="Morning">
                                            <label class="form-check-label">Morning</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="time" id="evening"
                                                value="Evening">
                                            <label class="form-check-label">Evening</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
            jQuery("#customer_id").on("input", function() {
                let customerId = jQuery(this).val();
                if (customerId.length > 0) {
                    $.ajax({
                        url: "{{ route('admin.get.customer.info') }}",
                        type: "GET",
                        data: {
                            _token: "{{ csrf_token() }}",
                            customer_id: customerId,
                        },
                        success: function(response) {
                            jQuery("#customer_name")
                                .text(response.name)
                                .removeClass("text-danger")
                                .addClass("text-success");
                        },
                        error: function(xhr) {
                            if (xhr.status === 404) {
                                jQuery("#customer_name")
                                    .text("Customer not found")
                                    .removeClass("text-success")
                                    .addClass("text-danger");
                            } else {
                                jQuery("#customer_name")
                                    .text("Error fetching customer info")
                                    .removeClass("text-success")
                                    .addClass("text-danger");
                            }
                        },
                    });
                } else {
                    jQuery("#customer_name").text("");
                }
            });
        });
    </script>
@endpush
