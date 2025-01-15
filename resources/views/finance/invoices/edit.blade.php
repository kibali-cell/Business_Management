@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Edit Invoice #{{ $invoice->invoice_number }}</h2>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back to Invoices</a>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Customer Selection -->
                        <div class="mb-3">
                            <label class="form-label">Customer</label>
                            <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dates -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Issue Date</label>
                                    <input type="date" name="issue_date" class="form-control @error('issue_date') is-invalid @enderror" 
                                           value="{{ old('issue_date', $invoice->issue_date) }}" required>
                                    @error('issue_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
                                           value="{{ old('due_date', $invoice->due_date) }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Amount Calculations -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Subtotal</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="subtotal" step="0.01" class="form-control @error('subtotal') is-invalid @enderror"
                                           value="{{ old('subtotal', $invoice->subtotal) }}" required onchange="calculateTotal()" onkeyup="calculateTotal()">
                                    @error('subtotal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tax Rate</label>
                                <div class="input-group">
                                    <input type="number" name="tax_rate" step="0.1" class="form-control @error('tax_rate') is-invalid @enderror"
                                           value="{{ old('tax_rate', round(($invoice->tax / $invoice->subtotal) * 100, 1)) }}" 
                                           required onchange="calculateTotal()" onkeyup="calculateTotal()">
                                    <span class="input-group-text">%</span>
                                    @error('tax_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tax Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="tax" step="0.01" class="form-control" 
                                           value="{{ old('tax', $invoice->tax) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="draft" {{ $invoice->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="sent" {{ $invoice->status == 'sent' ? 'selected' : '' }}>Sent</option>
                                    <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="overdue" {{ $invoice->status == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="row mb-3">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <label class="form-label">Total</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="total" step="0.01" class="form-control" 
                                           value="{{ old('total', $invoice->total) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $invoice->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Invoice</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function calculateTotal() {
    const subtotal = parseFloat(document.getElementsByName('subtotal')[0].value) || 0;
    const taxRate = parseFloat(document.getElementsByName('tax_rate')[0].value) || 0;
    
    // Calculate tax amount
    const taxAmount = (subtotal * taxRate / 100);
    const total = subtotal + taxAmount;
    
    // Update tax amount and total fields
    document.getElementsByName('tax')[0].value = taxAmount.toFixed(2);
    document.getElementsByName('total')[0].value = total.toFixed(2);
}

// Calculate total on page load
document.addEventListener('DOMContentLoaded', calculateTotal);
</script>
@endpush
@endsection