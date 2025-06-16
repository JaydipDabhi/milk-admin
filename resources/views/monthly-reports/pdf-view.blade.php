<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Milk Bill</title>
    <style>
        @page {
            margin: 20px;
        }

        body {
            /* font-family: DejaVu Sans, sans-serif; */
            font-family: 'noto_sans_gujarati', DejaVu Sans, sans-serif;
            font-size: 15px;
            margin: 0;
            padding: 0;
        }

        .bill-box {
            text-align: center;
            width: 45%;
            display: inline-block;
            vertical-align: top;
            margin: 6px 1%;
            padding: 8px;
            border: 2px solid #000;
            box-sizing: border-box;
            height: 200px;
            page-break-inside: avoid;
        }

        .divider {
            border: none;
            border-top: 2px solid #000;
            margin: 4px 0;
            padding-left: 10px;
        }

        .header {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .content {
            margin-top: 4px;
            line-height: 1.65;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @foreach ($data->chunk(6) as $page)
        <div class="page">
            @foreach ($page->chunk(2) as $row)
                <div style="width: 100%; page-break-inside: avoid;">
                    @foreach ($row as $item)
                        @php
                            $grandTotal = collect($item['products'])->sum('total');
                        @endphp
                        <div class="bill-box">
                            <div class="header">{{ $item['customer']->customer_name }}</div>
                            <div class="content">
                                {{ $item['startDate'] }} to {{ $item['endDate'] }}<br>

                                @foreach ($item['products'] as $product)
                                    {{ $product['type'] }}<br>
                                    {{ number_format($product['shares'], 0) }} Shares<br>
                                    × ₹ {{ number_format($product['rate'] / 2, 0) }} Rate<br>
                                    <hr class="divider">
                                    = <strong>₹ {{ number_format($product['total'], 2) }} Total</strong>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
