@extends('layouts.index')
@section('title', 'Update Rate')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Rate</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Update Rate</li>
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
                                <h3 class="card-title">Update Rate</h3>
                            </div>
                            <form method="POST" action="{{ route('admin.rate_update', $rate->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="rate_type">Rate Type (Cow/Bufflo)</label>
                                        <input type="text" class="form-control @error('rate_type') is-invalid @enderror"
                                            id="rate_type" name="rate_type" placeholder="Enter Type (Cow/Bufflo)"
                                            value="{{ old('rate_type', $rate->rate_type) }}">
                                        @error('rate_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="rate">Update Rate (₹/Liter)</label>
                                        <input type="number" class="form-control" id="rate" name="rate"
                                            placeholder="Enter Rate (₹/Liter)" value="{{ old('rate', $rate->rate) }}"
                                            step="0.01" min="0">
                                        @error('rate')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
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
