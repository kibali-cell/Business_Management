<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Balance Sheet</h2>

    <table>
        <thead>
            <tr>
                <th>Account</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($data as $account => $amount)
        <tr>
            <td>{{ $account }}</td>
            <td>
                {{ is_numeric($amount) ? number_format($amount, 2) : 'N/A' }}
            </td>
        </tr>
    @endforeach
</tbody>

    </table>

    <p><strong>Generated on:</strong> {{ now()->format('M d, Y h:i A') }}</p>
</body>
</html>
