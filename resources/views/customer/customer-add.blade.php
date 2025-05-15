@extends('layouts.index')
@section('title', 'Add New Customer')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Customer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add New Customer</li>
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
                                <h3 class="card-title">Add New Customer</h3>
                            </div>
                            <form method="POST" action="{{ route('admin.customer_store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="customerName">Customer Name</label>
                                        <input type="text"
                                            class="form-control @error('customer_name') is-invalid @enderror"
                                            id="customerName" name="customer_name" placeholder="Enter Customer Name"
                                            value="{{ old('customer_name') }}">
                                        @error('customer_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="customerMobile">Customer Mobile Number</label>
                                        <input type="tel" class="form-control" id="customerMobile"
                                            name="customer_mobile" placeholder="Enter Customer Mobile Number"
                                            value="{{ old('customer_mobile') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="customerEmail">Customer Email address</label>
                                        <input type="email" class="form-control" id="customerEmail" name="customer_email"
                                            placeholder="Enter Customer Email" value="{{ old('customer_email') }}">
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
