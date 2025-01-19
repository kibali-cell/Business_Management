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
            'current_balance' => 'required|numeric|min:0'
        ]);

        $validated['last_synced_at'] = now();

        BankAccount::create($validated);

        return redirect()->route('bank-accounts.index')
            ->with('success', 'Bank account created successfully');
    }


    public function sync(BankAccount $account)
    {
        // Implement bank sync logic here
        // This would typically connect to your bank's API
        
        return redirect()->back()->with('success', 'Account synchronized successfully');
    }

        public function deposit(Request $request, BankAccount $account)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255'
        ]);

        try {
            $account->deposit(
                $validated['amount'],
                $validated['description'] ?? 'Cash deposit'
            );

            return redirect()->route('bank-accounts.transactions', $account)
                ->with('success', 'Deposit completed successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to process deposit: ' . $e->getMessage());
        }
    }

    public function withdraw(Request $request, BankAccount $account)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255'
        ]);

        try {
            $account->withdraw(
                $validated['amount'],
                $validated['description'] ?? 'Cash withdrawal'
            );

            return redirect()->route('bank-accounts.transactions', $account)
                ->with('success', 'Withdrawal completed successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to process withdrawal: ' . $e->getMessage());
        }
    }
}
