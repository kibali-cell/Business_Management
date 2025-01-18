@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Accounts</h2>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAccountModal">
                Add Account
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Account Number</th>
                            <th>Type</th>
                            <th>Balance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account->name }}</td>
                            <td>{{ $account->account_number }}</td>
                            <td>{{ ucfirst($account->type) }}</td>
                            <td>{{ $account->currency }} {{ number_format($account->balance, 2) }}</td>
                            <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-info me-2" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewAccountModal{{ $account->id }}">
                                    View
                                </button>
                                <button type="button" class="btn btn-sm btn-warning me-2" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editAccountModal{{ $account->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this account?')">
                                        Delete
                                    </button>
                                </form>
                            </div>

                            </td>
                        </tr>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewAccountModal{{ $account->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Account Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <dl class="row">
                                            <dt class="col-sm-4">Account Name</dt>
                                            <dd class="col-sm-8">{{ $account->name }}</dd>

                                            <dt class="col-sm-4">Account Number</dt>
                                            <dd class="col-sm-8">{{ $account->account_number }}</dd>

                                            <dt class="col-sm-4">Type</dt>
                                            <dd class="col-sm-8">{{ ucfirst($account->type) }}</dd>

                                            <dt class="col-sm-4">Currency</dt>
                                            <dd class="col-sm-8">{{ $account->currency }}</dd>

                                            <dt class="col-sm-4">Balance</dt>
                                            <dd class="col-sm-8">{{ number_format($account->balance, 2) }}</dd>

                                            <dt class="col-sm-4">Description</dt>
                                            <dd class="col-sm-8">{{ $account->description ?? 'N/A' }}</dd>

                                            <dt class="col-sm-4">Created At</dt>
                                            <dd class="col-sm-8">{{ $account->created_at->format('Y-m-d H:i:s') }}</dd>
                                        </dl>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <a href="{{ route('accounts.download', $account) }}" class="btn btn-primary">
                                            Download Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editAccountModal{{ $account->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('accounts.update', $account) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Account</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Account Name</label>
                                                <input type="text" name="name" class="form-control" 
                                                       value="{{ $account->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Account Number</label>
                                                <input type="text" name="account_number" class="form-control" 
                                                       value="{{ $account->account_number }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Type</label>
                                                <select name="type" class="form-select" required>
                                                    <option value="asset" {{ $account->type == 'asset' ? 'selected' : '' }}>Asset</option>
                                                    <option value="liability" {{ $account->type == 'liability' ? 'selected' : '' }}>Liability</option>
                                                    <option value="income" {{ $account->type == 'income' ? 'selected' : '' }}>Income</option>
                                                    <option value="expense" {{ $account->type == 'expense' ? 'selected' : '' }}>Expense</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Currency</label>
                                                <input type="text" name="currency" class="form-control" 
                                                       value="{{ $account->currency }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control" 
                                                          rows="3">{{ $account->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update Account</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- New Account Modal -->
<div class="modal fade" id="newAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('accounts.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">New Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Account Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Account Number</label>
                        <input type="text" name="account_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="asset">Asset</option>
                            <option value="liability">Liability</option>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Currency</label>
                        <input type="text" name="currency" class="form-control" value="USD" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="uploadButton" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection