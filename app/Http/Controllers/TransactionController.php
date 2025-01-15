<?php

namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB; // For DB::transaction

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['fromAccount', 'toAccount'])
            ->orderBy('transaction_date', 'desc')
            ->paginate(15);
        return view('finance.transactions.index', compact('transactions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0',
            'from_account_id' => 'required|exists:accounts,id',
            'to_account_id' => 'required|exists:accounts,id',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        DB::transaction(function () use ($validated) {
            // Create transaction
            $transaction = Transaction::create($validated + [
                'reference_number' => 'TRX-' . uniqid(),
                'status' => 'completed'
            ]);

            // Update account balances
            $fromAccount = Account::find($validated['from_account_id']);
            $toAccount = Account::find($validated['to_account_id']);

            $fromAccount->decrement('balance', $validated['amount']);
            $toAccount->increment('balance', $validated['amount']);
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction recorded successfully');
    }
}
