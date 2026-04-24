<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>CityCare Medical Centre</h2>
    <h3>Payment Report</h3>

    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Reference</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->patient?->first_name }} {{ $payment->patient?->last_name }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td>{{ $payment->transaction_reference }}</td>
                    <td>{{ $payment->payment_date?->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($payment->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>