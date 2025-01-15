<!DOCTYPE html>
<html>
<head>
    <title>Balance Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Balance Sheet Report</h2>
    <table>
        <thead>
            <tr>
                <th>Account</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $account => $amount)
                <tr>
                    <td>{{ $account }}</td>
                    <td>{{ number_format($amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="total">Total</td>
                <td class="total">{{ number_format(array_sum($report), 2) }}</td>
            </tr>
        </tfoot>
    </table>
    <p>Generated on: {{ now()->format('M d, Y h:i A') }}</p>
</body>
</html>
