<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $shipment->waybill_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 13px; }
        .header { display: table; width: 100%; margin-bottom: 24px; }
        .header .left, .header .right { display: table-cell; vertical-align: top; }
        .header .right { text-align: right; }
        .logo { font-size: 22px; font-weight: bold; color: #0057D9; }
        .tagline { font-size: 10px; color: #00A651; font-weight: bold; }
        h1 { font-size: 18px; margin: 0 0 4px; color: #0057D9; }
        table.info { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        table.info td { padding: 10px; vertical-align: top; width: 50%; }
        table.info .box { background: #F1F3F5; border-radius: 6px; padding: 12px; }
        table.info .label { font-size: 10px; text-transform: uppercase; color: #6b7280; font-weight: bold; margin-bottom: 4px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.items th { background: #0057D9; color: #fff; text-align: left; padding: 8px; font-size: 11px; text-transform: uppercase; }
        table.items td { padding: 8px; border-bottom: 1px solid #e5e7eb; }
        .total-row td { font-weight: bold; font-size: 15px; color: #00A651; }
        .footer { margin-top: 40px; font-size: 10px; color: #9ca3af; text-align: center; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 10px; background: #F1F3F5; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="left">
            <div class="logo">PSCM</div>
            <div class="tagline">PRIME SUPPLY CHAIN MANAGEMENT</div>
            <p>{{ config('company.address') }}<br>{{ config('company.phone_1') }} | {{ config('company.email') }}</p>
        </div>
        <div class="right">
            <h1>INVOICE</h1>
            <p>Waybill: <strong>{{ $shipment->waybill_number }}</strong><br>
            Date: {{ $shipment->created_at->format('d M Y') }}<br>
            Status: <span class="badge">{{ $shipment->statusLabel() }}</span></p>
        </div>
    </div>

    <table class="info">
        <tr>
            <td>
                <div class="box">
                    <div class="label">From (Sender)</div>
                    <strong>{{ $shipment->sender_name }}</strong><br>
                    {{ $shipment->sender_phone }}<br>
                    {{ $shipment->pickup_address }}
                </div>
            </td>
            <td>
                <div class="box">
                    <div class="label">To (Receiver)</div>
                    <strong>{{ $shipment->receiver_name }}</strong><br>
                    {{ $shipment->receiver_phone }}<br>
                    {{ $shipment->delivery_address }}
                </div>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th>Package Type</th>
                <th>Weight</th>
                <th style="text-align:right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $shipment->description ?: 'Shipment / Dispatch Delivery' }}</td>
                <td>{{ $shipment->package_type }}</td>
                <td>{{ $shipment->weight_kg }} kg</td>
                <td style="text-align:right">&#8358;{{ number_format($shipment->amount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align:right">Total</td>
                <td style="text-align:right">&#8358;{{ number_format($shipment->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top:20px;">Payment Method: {{ $shipment->payment_method === 'online' ? 'Online (Paystack)' : 'Pay on Delivery' }} &nbsp;|&nbsp; Payment Status: {{ ucfirst($shipment->payment_status) }}</p>

    <div class="footer">
        Thank you for choosing PSCM Logistics — Delivering Trust. Every Time.
    </div>
</body>
</html>
