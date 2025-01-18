<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .details {
            margin-bottom: 20px;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            width: 150px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Account Details</h1>
    </div>

    <div class="details">
        <div class="detail-row">
            <span class="label">Account Name:</span>
            <span>{{ $account->name }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Account Number:</span>
            <span>{{ $account->account_number }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Type:</span>
            <span>{{ ucfirst($account->type) }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Currency:</span>
            <span>{{ $account->currency }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Balance:</span>
            <span>{{ number_format($account->balance, 2) }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Description:</span>
            <span>{{ $account->description ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Created At:</span>
            <span>{{ $account->created_at->format('Y-m-d H:i:s') }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Last Updated:</span>
            <span>{{ $account->updated_at->format('Y-m-d H:i:s') }}</span>
        </div>
    </div>
</body>
</html>