@extends('layouts.index')
@section('title', 'Full Reports')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-calendar-alt"></i> Full Reports</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}">
                                    <i class="fas fa-home"></i> Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Full Reports</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow border-0">
                    <div class="card-header bg-info text-white">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-chart-line"></i> Milk Type Summary Report
                            </h3>
                            <button class="btn btn-light btn-sm d-print-none" onclick="printReportTable()">
                                <i class="fas fa-print"></i> Print Report
                            </button>
                        </div>
                    </div>

                    <div class="card-body" id="print-section">
                        @if (empty($summary))
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-circle"></i> No milk delivery data available.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Type</th>
                                            <th>Rate (₹/unit)</th>
                                            <th>Total Quantity</th>
                                            <th>Total Amount (₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $grandAmount = 0;
                                        @endphp
                                        @foreach ($summary as $type => $data)
                                            @php
                                                $grandAmount += $data['total_amount'];
                                            @endphp
                                            <tr>
                                                <td>{{ ucfirst($type) }}</td>
                                                <td>₹{{ number_format($data['rate'], 2) }}</td>
                                                <td>
                                                    {{ number_format($data['total_weight'], 2) }} {{ $data['unit'] }}
                                                    @if (!is_null($data['shares']))
                                                        ({{ number_format($data['shares'], 1) }} shares)
                                                    @endif
                                                </td>
                                                <td>₹{{ number_format($data['total_amount'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="font-weight-bold bg-light">
                                        <tr>
                                            <td colspan="3">Total Across All Types</td>
                                            <td>₹{{ number_format($grandAmount, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        function printReportTable() {
            const content = document.getElementById("print-section").innerHTML;
            const printWindow = window.open('', '', 'height=842,width=595');
            printWindow.document.write(`
            <html>
                <head>
                    <title>Milk Type Summary Report</title>
                    <style>
                        body { font-family: Arial, sans-serif; font-size: 12pt; padding: 20px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                        h3 { text-align: center; margin-bottom: 20px; }
                    </style>
                </head>
                <body>
                    <h3>Milk Type Summary Report</h3>
                    ${content}
                </body>
            </html>
        `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>
@endpush
