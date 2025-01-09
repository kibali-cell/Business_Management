
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Customers</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomer">
            Add Customer
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->company }}</td>
                            <td>
                                <span class="badge bg-{{ $customer->status === 'lead' ? 'warning' : 'success' }}">
                                    {{ $customer->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('crm.customers.show', $customer) }}" class="btn btn-sm btn-info">
                                    View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>

@include('crm.customers.create-modal')
@endsection