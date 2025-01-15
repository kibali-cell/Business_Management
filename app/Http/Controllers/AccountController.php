<?php

namespace App\Http\Controllers;

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
}
