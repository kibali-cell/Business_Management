<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('crm.customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'status' => 'required|string|in:lead,customer,prospect',
        ]);

        Customer::create($validated);

        return redirect()->route('crm.customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        return view('crm.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('crm.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'status' => 'required|string|in:lead,customer,prospect',
        ]);

        $customer->update($validated);

        return redirect()->route('crm.customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('crm.customers.index')->with('success', 'Customer deleted successfully.');
    }
}