<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $accounts = BankAccount::all();
        return view('financial.bank-accounts.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'balance' => 'required|numeric'
        ]);

        BankAccount::create($validated);
        return redirect()->route('bank-accounts.index')->with('success', 'Bank account created successfully');
    }

    public function sync(BankAccount $account)
    {
        // Implement bank sync logic here
        // This would typically connect to your bank's API
        
        return redirect()->back()->with('success', 'Account synchronized successfully');
    }
}
