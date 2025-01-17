@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Bank Accounts</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newBankAccountModal">
                        Link New Account
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Bank Name</th>
                                    <th>Account Name</th>
                                    <th>Account Number</th>
                                    <th>Current Balance</th>
                                    <th>Last Synced</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accounts as $account)
                                <tr>
                                    <td>{{ $account->bank_name }}</td>
                                    <td>{{ $account->name }}</td>
                                    <td>{{ substr($account->account_number, -4) }}</td>
                                    <td>{{ number_format($account->current_balance, 2) }}</td>
                                    <td>{{ $account->last_synced_at ? $account->last_synced_at->diffForHumans() : 'Never' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="syncAccount({{ $account->id }})">
                                            Sync
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection