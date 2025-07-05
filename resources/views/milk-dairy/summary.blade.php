@extends('layouts.index')
@section('title', 'Milk Dairy Summary')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Milk Dairy Summary</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Milk Dairy Summary</li>
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
                        'success_update' => 'info',
                        'error' => 'danger',
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
            </div>
        </section>

        @if ($totalsByCustomer->count())
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title mb-0">💰 Total Amount by Customer No. in Dairy</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped table-bordered mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 50%">Customer No.</th>
                                        <th>Total ₹</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($totalsByCustomer as $customer)
                                        <tr>
                                            <td>{{ $customer->customer_no_in_dairy }}</td>
                                            <td>₹ {{ number_format($customer->total_amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light font-weight-bold">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td>₹ {{ number_format($subTotalAmount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        @endif


        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row w-100 align-items-center">
                                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                                        <h3 class="card-title mb-0">Milk Dairy Summary</h3>
                                    </div>

                                    <div class="col-12 col-md-6 text-md-right text-left">
                                        <a href="{{ route('milk_dairy.create') }}" class="btn btn-primary">
                                            <i class="fas fa-user-plus mr-1"></i> Add Daily Entry
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer No</th>
                                            <th>Shift</th>
                                            <th>Milk (L)</th>
                                            <th>Fat %</th>
                                            <th>Rate/L</th>
                                            <th>Amount</th>
                                            <th>Total ₹</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entries as $entry)
                                            <tr>
                                                <td>{{ $entry->id }}</td>
                                                <td>{{ $entry->customer_no_in_dairy }}</td>
                                                <td>{{ ucfirst($entry->shift) }}</td>
                                                <td>{{ $entry->milk_weight }}</td>
                                                <td>{{ $entry->fat_in_percentage }}</td>
                                                <td>{{ $entry->rate_per_liter }}</td>
                                                <td>{{ $entry->amount }}</td>
                                                <td>{{ $entry->total_amount }}</td>
                                                <td>
                                                    <a href="{{ route('milk_dairy.edit', $entry) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                    <form id="delete-form-{{ $entry->id }}"
                                                        action="{{ route('milk_dairy.destroy', $entry) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="confirmDairyDelete({{ $entry->id }})">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer No</th>
                                            <th>Shift</th>
                                            <th>Milk (L)</th>
                                            <th>Fat %</th>
                                            <th>Rate/L</th>
                                            <th>Amount</th>
                                            <th>Total ₹</th>
                                            <th>Actions</th>
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
