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

<!-- New Bank Account Modal -->
<div class="modal fade" id="newBankAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('bank-accounts.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Link New Bank Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Account Name field - This was missing -->
                    <div class="mb-3">
                        <label class="form-label">Account Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Number</label>
                        <input type="text" name="account_number" class="form-control" required>
                    </div>

                    <!-- Current Balance field -->
                    <div class="mb-3">
                        <label class="form-label">Current Balance</label>
                        <input type="number" name="current_balance" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection