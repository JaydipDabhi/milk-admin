@extends('layouts.index')
@section('title', 'Milk Delivery List')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Milk Delivery List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Milk Delivery List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row w-100 align-items-center">
                                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                                        <h3 class="card-title mb-0">Milk Delivery List</h3>
                                    </div>

                                    <div class="col-12 col-md-6 text-md-right text-left">
                                        <a href="{{ route('admin.milk_delivery') }}" class="btn btn-primary">
                                            <i class="fas fa-user-plus mr-1"></i> Add Delivery
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Customer</th>
                                            <th>Type</th>
                                            <th>Weight (liters)</th>
                                            <th>Rate</th>
                                            <th>Total</th>
                                            <th>Time</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deliveries as $index => $delivery)
                                            <tr>
                                                <td>{{ $delivery->id }}</td>
                                                <td>{{ $delivery->customer->customer_name ?? 'N/A' }}</td>
                                                <td>{{ ucfirst($delivery->type) }}</td>
                                                <td>{{ $delivery->weight }}</td>
                                                <td>{{ $delivery->rate }}</td>
                                                <td>{{ $delivery->total_rate }}</td>
                                                <td>{{ $delivery->time }}</td>
                                                <td>{{ $delivery->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.milk_delivery_edit', $delivery->id) }}"
                                                        class="text-primary mr-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="" method="POST" class="d-inline">
                                                        <button type="button"
                                                            class="btn btn-link text-danger p-0 m-0 align-baseline">
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
                                            <th>Customer</th>
                                            <th>Type</th>
                                            <th>Weight (liters)</th>
                                            <th>Rate</th>
                                            <th>Total</th>
                                            <th>Time</th>
                                            <th>Date</th>
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
