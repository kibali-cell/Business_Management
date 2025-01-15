@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Invoice #{{ $invoice->invoice_number }}</h2>
                <div>
                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back to Invoices</a>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="mb-3">From:</h6>
                            <div>Your Company Name</div>
                            <div>123 Business Street</div>
                            <div>Business City, 12345</div>
                            <div>Email: business@example.com</div>
                            <div>Phone: (123) 456-7890</div>
                        </div>

                        <div class="col-sm-6">
                            <h6 class="mb-3">To:</h6>
                            <div>{{ $invoice->customer->name }}</div>
                            <div>{{ $invoice->customer->email }}</div>
                            <div>{{ $invoice->customer->phone }}</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <div><strong>Issue Date:</strong> {{ $invoice->issue_date }}</div>
                            <div><strong>Due Date:</strong> {{ $invoice->due_date }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div>
                                <strong>Status:</strong>
                                <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : 
                                    ($invoice->status === 'overdue' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="text-end">${{ number_format($invoice->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td class="text-end">${{ number_format($invoice->tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total</td>
                                    <td class="text-end fw-bold">${{ number_format($invoice->total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if($invoice->notes)
                    <div class="mb-4">
                        <h6>Notes:</h6>
                        <p class="mb-0">{{ $invoice->notes }}</p>
                    </div>
                    @endif

                    <div class="text-end">
                        <button class="btn btn-primary" onclick="window.print()">Print Invoice