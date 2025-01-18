@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Account Details</h2>
    <div class="card">
        <div class="card-body">
            <h4>{{ $account->name }}</h4>
            <p><strong>Account Number:</strong> {{ $account->account_number }}</p>
            <p><strong>Type:</strong> {{ ucfirst($account->type) }}</p>
            <p><strong>Balance:</strong> {{ $account->currency }} {{ number_format($account->balance, 2) }}</p>
            <p><strong>Description:</strong> {{ $account->description }}</p>
            <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
