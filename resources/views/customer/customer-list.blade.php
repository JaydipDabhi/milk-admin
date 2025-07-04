@extends('layouts.index')
@section('title', 'Customer List')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customer List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Customer List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @php
                    $alerts = [
                        'success' => 'success',
                        'success_delete' => 'danger',
                        'error' => 'danger',
                        'success_update' => 'info',
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row w-100 align-items-center">
                                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                                        <h3 class="card-title mb-0">Customer List</h3>
                                    </div>

                                    <div class="col-12 col-md-6 text-md-right text-left">
                                        <a href="{{ route('admin.customer_create') }}" class="btn btn-primary">
                                            <i class="fas fa-user-plus mr-1"></i> Add New Customer
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Customer Name</th>
                                            <th>Customer Type</th>
                                            <th>Mobile Number</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ $customer->id }}</td>
                                                <td>{{ $customer->customer_name }}</td>
                                                <td>{{ $customer->customer_type }}</td>
                                                <td>{{ $customer->customer_mobile }}</td>
                                                <td>{{ $customer->customer_email }}</td>
                                                <td>
                                                    <a href="{{ route('admin.customer_edit', $customer->id) }}"
                                                        class="text-primary mr-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.customer_delete', $customer->id) }}"
                                                        method="POST" class="d-inline"
                                                        id="delete-form-{{ $customer->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                            onclick="confirmCustomerDelete({{ $customer->id }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Customer Name</th>
                                            <th>Customer Type</th>
                                            <th>Mobile Number</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
