@extends('layouts.index')
@section('title', 'Yearly Report')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-calendar-alt"></i> Yearly Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}">
                                    <i class="fas fa-home"></i> Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Yearly Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary shadow">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-filter"></i> Filter Yearly Report</h3>
                    </div>

                    <form method="GET" action="{{ route('reports.generate_yearly_report') }}" id="yearlyForm">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4 mb-2">
                                    <label for="year">Select Year</label>
                                    <select name="year" id="year"
                                        class="form-control select2 @error('year') is-invalid @enderror">
                                        <option value="">-- Select Year --</option>
                                        <option value="{{ date('Y') }}"
                                            {{ old('year', $year ?? '') == date('Y') ? 'selected' : '' }}>
                                            {{ date('Y') }}
                                        </option>
                                    </select>
                                    @error('year')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 mb-2">
                                    <label for="type">Select Type</label>
                                    <select name="type" id="type"
                                        class="form-control select2 @error('type') is-invalid @enderror">
                                        <option value="">-- Select Type --</option>
                                        @foreach ($types as $t)
                                            <option value="{{ $t }}"
                                                {{ old('type', $type ?? '') == $t ? 'selected' : '' }}>
                                                {{ ucfirst($t) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 mb-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-chart-bar"></i> Generate Report
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        @if (isset($monthly))
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-info shadow">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line"></i> Summary for {{ ucfirst($type) }} - {{ $year }}
                            </h3>
                        </div>

                        <div class="card-body">
                            @if ($monthly->isEmpty())
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-circle"></i>
                                    No records found for <strong>{{ $type }}</strong> in
                                    <strong>{{ $year }}</strong>.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Month</th>
                                                <th>Total Weight (Liters)</th>
                                                <th>Shares (0.25L = 0.5 share)</th>
                                                <th>Total Amount (₹)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (range(1, 12) as $m)
                                                @php
                                                    $monthKey = str_pad($m, 2, '0', STR_PAD_LEFT);
                                                    $data = $monthly->get($monthKey, ['amount' => 0, 'weight' => 0]);
                                                    $amount = $data['amount'];
                                                    $weight = $data['weight'];
                                                    if ($weight == 0.25) {
                                                        $shares = 0.5;
                                                    } elseif ($weight == 0.5) {
                                                        $shares = 1.0;
                                                    } elseif ($weight == 0.75) {
                                                        $shares = 1.5;
                                                    } elseif ($weight == 1.0) {
                                                        $shares = 2.0;
                                                    } else {
                                                        $shares = $weight * 2;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</td>
                                                    <td>{{ number_format($weight, 2) }} L</td>
                                                    <td>{{ number_format($shares, 1) }} shares</td>
                                                    <td>₹{{ number_format($amount, 2) }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot class="font-weight-bold bg-light">
                                            @php
                                                $totalAmount = $monthly->sum(fn($row) => $row['amount']);
                                                $totalWeight = $monthly->sum(fn($row) => $row['weight']);
                                                if ($totalWeight == 0.25) {
                                                    $totalShares = 0.5;
                                                } elseif ($totalWeight == 0.5) {
                                                    $totalShares = 1.0;
                                                } elseif ($totalWeight == 0.75) {
                                                    $totalShares = 1.5;
                                                } elseif ($totalWeight == 1.0) {
                                                    $totalShares = 2.0;
                                                } else {
                                                    $totalShares = $totalWeight * 2;
                                                }
                                            @endphp
                                            <tr>
                                                <td>Total</td>
                                                <td>{{ number_format($totalWeight, 2) }} L</td>
                                                <td>{{ number_format($totalShares, 1) }} shares</td>
                                                <td>₹{{ number_format($totalAmount, 2) }}</td>
                                            </tr>

                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('.select2').select2({
                width: '100%'
            });

            // jQuery Validation
            $('#yearlyForm').first().validate({
                rules: {
                    year: {
                        required: true,
                    },
                    type: {
                        required: true
                    }
                },
                messages: {
                    year: {
                        required: "Please enter a year"
                    },
                    type: {
                        required: "Please select a type"
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
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
@endpush
