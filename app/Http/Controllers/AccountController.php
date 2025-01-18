<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::orderBy('name')->get();
        return view('finance.accounts.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|unique:accounts',
            'type' => 'required|in:asset,liability,income,expense',
            'currency' => 'required|string|size:3',
            'description' => 'nullable|string'
        ]);

        Account::create($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Account created successfully');
    }

    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|unique:accounts,account_number,' . $account->id,
            'type' => 'required|in:asset,liability,income,expense',
            'currency' => 'required|string|size:3',
            'description' => 'nullable|string'
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Account updated successfully');
    }

    public function destroy(Account $account)
{
    // Delete related transactions
    $account->transactions()->delete();

    // Delete the account
    $account->delete();

    return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
}


    public function download(Account $account)
    {
        // Option 1: Generate PDF using dompdf
        $pdf = PDF::loadView('finance.accounts.pdf', compact('account'));
        return $pdf->download('account-' . $account->account_number . '.pdf');

        // Option 2: If you prefer CSV format
        /* 
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=account-' . $account->account_number . '.csv',
        ];

        $data = [
            ['Account Name', $account->name],
            ['Account Number', $account->account_number],
            ['Type', ucfirst($account->type)],
            ['Currency', $account->currency],
            ['Balance', number_format($account->balance, 2)],
            ['Description', $account->description ?? 'N/A'],
            ['Created At', $account->created_at->format('Y-m-d H:i:s')],
            ['Updated At', $account->updated_at->format('Y-m-d H:i:s')],
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
        */
    }
}
