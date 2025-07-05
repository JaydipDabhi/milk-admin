{{-- @extends('layouts.index')
@section('title', 'Add Rate')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Rate</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Rate</li>
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
                                <h3 class="card-title">Add Rate</h3>
                            </div>
                            <form method="POST" action="{{ route('admin.rate_store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="rate_type">Rate Type (Cow/Buffalo)</label>
                                        <input type="text" class="form-control @error('rate_type') is-invalid @enderror"
                                            id="rate_type" name="rate_type" placeholder="Enter Type (Cow/Buffalo)"
                                            value="{{ old('rate_type') }}">
                                        @error('rate_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="rate">Rate (₹/Liter)</label>
                                        <input type="number" class="form-control" id="rate" name="rate"
                                            placeholder="Enter Rate (₹/Liter)" value="{{ old('rate') }}" step="0.01"
                                            min="0">
                                        @error('rate')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('admin.rate_list') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection --}}

@extends('layouts.index')
@section('title', 'Add Rate')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Rate</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Rate</li>
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
                                <h3 class="card-title">Add Rate</h3>
                            </div>

                            <form id="rateForm" method="POST" action="{{ route('admin.rate_store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="rate_type">Rate Type</label>
                                        <input type="text" class="form-control @error('rate_type') is-invalid @enderror"
                                            id="rate_type" name="rate_type" placeholder="e.g. (Cow/Buffalo)"
                                            value="{{ old('rate_type') }}">
                                        @error('rate_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="rate">Rate (₹/Liter)</label>
                                        <input type="number" class="form-control @error('rate') is-invalid @enderror"
                                            id="rate" name="rate" placeholder="Enter Rate (₹/Liter)"
                                            value="{{ old('rate') }}" step="0.01" min="0">
                                        @error('rate')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('admin.rate_list') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
<!-- jQuery and Validation Script -->
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#rateForm').validate({
                rules: {
                    rate_type: {
                        required: true,
                        // pattern: /^(Cow|Buffalo)$/i
                    },
                    rate: {
                        required: true,
                        number: true,
                        min: 0.01
                    }
                },
                messages: {
                    rate_type: {
                        required: "Please enter the rate type",
                        // pattern: "Rate type must be either 'Cow' or 'Buffalo'"
                    },
                    rate: {
                        required: "Please enter the rate",
                        number: "Rate must be a valid number",
                        min: "Rate must be greater than 0"
                    }
                },
                errorElement: 'span',
                errorClass: 'text-danger',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
@endpush
