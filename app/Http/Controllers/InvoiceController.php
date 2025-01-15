<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('finance.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('finance.invoices.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'subtotal' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string'
        ]);

        // Calculate tax and total
        $tax = $validated['subtotal'] * ($validated['tax_rate'] / 100);
        $total = $validated['subtotal'] + $tax;

        // Add calculated values to validated data
        $validated['tax'] = $tax;
        $validated['total'] = $total;
        $validated['invoice_number'] = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
        $validated['status'] = 'draft';

        // Remove tax_rate as it's not in the fillable array
        unset($validated['tax_rate']);

        Invoice::create($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully');
    }

    public function show(Invoice $invoice)
    {
        return view('finance.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $customers = Customer::all();
        return view('finance.invoices.edit', compact('invoice', 'customers'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'subtotal' => 'required|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:draft,sent,paid,overdue',
            'notes' => 'nullable|string'
        ]);

        // Calculate tax and total
        $tax = $validated['subtotal'] * ($validated['tax_rate'] / 100);
        $total = $validated['subtotal'] + $tax;

        // Add calculated values to validated data
        $validated['tax'] = $tax;
        $validated['total'] = $total;

        // Remove tax_rate as it's not in the fillable array
        unset($validated['tax_rate']);

        $invoice->update($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully');
    }
}