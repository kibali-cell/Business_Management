<?php
// app/Services/Financial/CurrencyService.php
namespace App\Services\Financial;

use App\Models\Currency;
use App\Models\ExchangeRate;
use GuzzleHttp\Client;

class CurrencyService
{
    public function convert($amount, $fromCurrency, $toCurrency)
    {
        $rate = $this->getExchangeRate($fromCurrency, $toCurrency);
        return $amount * $rate;
    }

    public function getExchangeRate($fromCurrency, $toCurrency)
    {
        $rate = ExchangeRate::where('from_currency', $fromCurrency)
            ->where('to_currency', $toCurrency)
            ->where('created_at', '>=', now()->subDay())
            ->first();

        if (!$rate) {
            $rate = $this->fetchLatestRate($fromCurrency, $toCurrency);
        }

        return $rate->rate;
    }

    private function fetchLatestRate($fromCurrency, $toCurrency)
    {
        $client = new Client();
        $response = $client->get("https://api.exchangerate-api.com/v4/latest/{$fromCurrency}");
        $data = json_decode($response->getBody(), true);

        return ExchangeRate::create([
            'from_currency' => $fromCurrency,
            'to_currency' => $toCurrency,
            'rate' => $data['rates'][$toCurrency]
        ]);
    }
}
