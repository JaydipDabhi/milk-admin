@extends('layouts.index')
@section('title', 'Milk Delivery List')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Milk Delivery List - {{ \Carbon\Carbon::now()->format('F Y') }}</h1>
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

                @php
                    $alerts = [
                        'success' => 'success',
                        'success_delete' => 'danger',
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
                                            <th>Weight (Liters with Share)</th>
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
                                                <td>
                                                    @php
                                                        $weight = $delivery->weight;
                                                        $type = strtolower($delivery->type);
                                                        $unit = in_array($type, ['ghee', 'butter']) ? 'kg' : 'liters';

                                                        if (!in_array($type, ['ghee', 'butter'])) {
                                                            if ($weight == 0.25) {
                                                                $share = 0.5;
                                                            } elseif ($weight == 0.5) {
                                                                $share = 1;
                                                            } elseif ($weight == 0.75) {
                                                                $share = 1.5;
                                                            } elseif ($weight == 1) {
                                                                $share = 2;
                                                            } else {
                                                                $share = $weight * 2;
                                                            }
                                                        }
                                                    @endphp

                                                    {{ number_format($weight, 2) }} {{ $unit }}
                                                    @unless (in_array($type, ['ghee', 'butter']))
                                                        ({{ rtrim(rtrim(number_format($share, 2), '0'), '.') }} Share)
                                                    @endunless
                                                </td>
                                                <td>{{ $delivery->rate }}</td>
                                                <td>{{ $delivery->total_rate }}</td>
                                                <td>{{ $delivery->time }}</td>
                                                <td>{{ $delivery->created_at ? $delivery->created_at->format('d-m-Y') : 'N/A' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.milk_delivery_edit', $delivery->id) }}"
                                                        class="text-primary mr-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.milk_delivery_delete', $delivery->id) }}"
                                                        method="POST" class="d-inline"
                                                        id="delete-form-{{ $delivery->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                            onclick="confirmMilkDeliveryDelete({{ $delivery->id }})">
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
                                            <th>Weight (Liters with Share)</th>
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
