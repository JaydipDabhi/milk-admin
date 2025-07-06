@extends('layouts.index')
@section('title', 'Milk Dairy Summary')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1>Milk Dairy Summary</h1>
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Milk Dairy Summary</li>
                </ol>
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
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
        @if ($totalsByCustomer->count())
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-info card-outline">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Total Amount by Customer No.</h3>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-striped mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Customer No.</th>
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
                <div class="card">
                    <div class="card-header">
                        <div class="row w-100 align-items-center">
                            <div class="col-12 col-md-6 mb-2 mb-md-0 text-md-left text-center">
                                <h3 class="card-title mb-0">Milk Dairy Summary</h3>
                            </div>

                            <div class="col-12 col-md-6 text-md-right text-center">
                                <a href="{{ route('milk_dairy.create') }}" class="btn btn-primary">
                                    <i class="fas fa-user-plus mr-1"></i> Add Daily Entry
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
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
                                        <td>{{ \Carbon\Carbon::parse($entry->created_at)->format('d-m-Y') }}</td>
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
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('milk_dairy.destroy', $entry) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDairyDelete({{ $entry->id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light font-weight-bold">
                                <tr>
                                    <th colspan="4" class="text-center">Total / Average</th>
                                    <th>{{ number_format($totalMilk, 2) }} L</th>
                                    <th>{{ number_format($entryCount ? $totalFat / $entryCount : 0, 2) }}%</th>
                                    <th>{{ number_format($entryCount ? $totalRate / $entryCount : 0, 2) }}</th>
                                    <th>₹ {{ number_format($totalAmount, 2) }}</th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
