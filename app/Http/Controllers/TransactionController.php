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

    public function show($accountId)
    {
        // Eager load the currency relationship
        $account = Account::with('currency')->find($accountId);

        // Now you can pass the account to the view
        return view('account.show', compact('account'));
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

            // Retrieve the accounts to update balances
            $fromAccount = Account::find($validated['from_account_id']);
            $toAccount = Account::find($validated['to_account_id']);

            // Check if the accounts exist
            if ($fromAccount && $toAccount) {
                // Update account balances
                $fromAccount->decrement('balance', $validated['amount']);
                $toAccount->increment('balance', $validated['amount']);
            } else {
                // If accounts don't exist, handle the error
                throw new \Exception("Invalid accounts.");
            }
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction recorded successfully');
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

            return redirect()->route('finance.transactions', $account)
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
