<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();
        $defaultCurrency = Currency::where('is_default', true)->first();

        return view('financial.currency.index', compact('currencies', 'defaultCurrency'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:3|unique:currencies',
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:5',
            'rate' => 'required|numeric|min:0'
        ]);

        $currency = Currency::create($validated);

        return redirect()->route('currency.index')
            ->with('success', 'Currency added successfully');
    }

    public function setDefault(Currency $currency)
    {
        $currency->setAsDefault();
        return redirect()->route('currency.index')
            ->with('success', 'Default currency updated');
    }

    public function updateRates()
    {
        try {
            // Example using ExchangeRate-API (you'll need to sign up for an API key)
            $response = Http::get('https://open.er-api.com/v6/latest/USD');
            
            if ($response->successful()) {
                $rates = $response->json()['rates'];
                
                foreach (Currency::all() as $currency) {
                    if (isset($rates[$currency->code])) {
                        $currency->update(['rate' => $rates[$currency->code]]);
                    }
                }
                
                return redirect()->route('currency.index')
                    ->with('success', 'Exchange rates updated successfully');
            }
        } catch (\Exception $e) {
            return redirect()->route('currency.index')
                ->with('error', 'Failed to update exchange rates');
        }
    }


    public function convert(Request $request)
    {
        $validated = $request->validate([
            'from_currency' => 'required|exists:currencies,id',
            'to_currency' => 'required|exists:currencies,id',
            'amount' => 'required|numeric|min:0'
        ]);

        $fromCurrency = Currency::find($validated['from_currency']);
        $toCurrency = Currency::find($validated['to_currency']);
        $amount = $validated['amount'];

        $convertedAmount = $fromCurrency->convert($amount, $toCurrency);

        return response()->json([
            'amount' => $convertedAmount,
            'formatted' => $toCurrency->formatAmount($convertedAmount),
            'rate' => $toCurrency->rate / $fromCurrency->rate
        ]);
    }
}
