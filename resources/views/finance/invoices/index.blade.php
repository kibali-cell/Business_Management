@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Invoices</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                Create Invoice
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Issue Date</th>
                            <th>Due Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->customer->name }}</td>
                            <td>{{ $invoice->issue_date }}</td>
                            <td>{{ $invoice->due_date }}</td>
                            <td>${{ number_format($invoice->total, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : 
                                    ($invoice->status === 'overdue' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection