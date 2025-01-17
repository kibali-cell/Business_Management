<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();
        return view('financial.currency.index', compact('currencies'));
    }

    public function convert(Request $request)
    {
        $request->validate([
            'from_currency' => 'required|string',
            'to_currency' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        // Simple conversion logic (you'll need to integrate with a real exchange rate API)
        $rate = 1.0; // Replace with actual rate from API
        $converted = $request->amount * $rate;

        return response()->json([
            'result' => $converted,
            'rate' => $rate
        ]);
    }
}
