@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Transactions</h2>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newTransactionModal">
                New Transaction
            </button>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>From Account</th>
                            <th>To Account</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->reference_number }}</td>
                            <td>{{ $transaction->transaction_date }}</td>
                            <td>{{ ucfirst($transaction->type) }}</td>
                            <td>{{ $transaction->fromAccount->name }}</td>
                            <td>{{ $transaction->toAccount->name }}</td>
                            <td>{{ number_format($transaction->amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info">View</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $transactions->links() }}
        </div>
    </div>
</div>

<!-- New Transaction Modal -->
<div class="modal fade" id="newTransactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">New Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">From Account</label>
                        <select name="from_account_id" class="form-select" required>
                            @foreach(App\Models\Account::all() as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">To Account</label>
                        <select name="to_account_id" class="form-select" required>
                            @foreach(App\Models\Account::all() as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="transaction_date" class="form-control" required 
                               value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Transaction</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection