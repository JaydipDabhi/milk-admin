<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Milk Full Report</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('https://raw.githubusercontent.com/dejavu-fonts/dejavu-fonts/master/ttf/DejaVuSans.ttf') format('truetype');
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>

</head>

<body>
    <h2 style="text-align: center;">Milk Type Summary Report</h2>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Rate (₹/unit)</th>
                <th>Total Quantity</th>
                <th>Total Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandAmount = 0; @endphp
            @foreach ($summary as $type => $data)
                @php $grandAmount += $data['total_amount']; @endphp
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

            @foreach ($customerSummaries as $custNo => $data)
                @php $grandAmount += $data['amount']; @endphp
                <tr>
                    <td>{{ $custNo }}</td>
                    <td>-</td>
                    <td>{{ number_format($data['weight'], 2) }} L ({{ number_format($data['shares'], 1) }} shares)</td>
                    <td>₹{{ number_format($data['amount'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Total Across All Types</strong></td>
                <td><strong>₹{{ number_format($grandAmount, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
