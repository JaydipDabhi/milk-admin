@extends('layouts.index')
@section('title', 'Update Customer Details')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Customer Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Update Customer Details</li>
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
                                <h3 class="card-title">Update Customer Details</h3>
                            </div>
                            <form method="POST" action="{{ route('admin.customer_update', $customer->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="customerName">Update Customer Name</label>
                                        <input type="text"
                                            class="form-control @error('customer_name') is-invalid @enderror"
                                            id="customerName" name="customer_name" placeholder="Update Customer Name"
                                            value="{{ old('customer_name', $customer->customer_name) }}">
                                        @error('customer_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="customer_type">Update Customer Type</label>
                                        <select class="form-control select2 @error('customer_type') is-invalid @enderror"
                                            id="customer_type" name="customer_type">
                                            <option value="">-- Select Customer Type --</option>
                                            @foreach ($rateTypes as $type)
                                                <option value="{{ $type }}"
                                                    {{ old('customer_type', $customer->customer_type) == $type ? 'selected' : '' }}>
                                                    {{ ucfirst($type) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('customer_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="customerMobile">Update Customer Mobile Number</label>
                                        <input type="tel" class="form-control" id="customerMobile"
                                            name="customer_mobile" placeholder="Update Customer Mobile Number"
                                            value="{{ old('customer_mobile', $customer->customer_mobile) }}">
                                        @error('customer_mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="customerEmail">Update Customer Email address</label>
                                        <input type="email" class="form-control" id="customerEmail" name="customer_email"
                                            placeholder="Update Customer Email"
                                            value="{{ old('customer_email', $customer->customer_email) }}">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
