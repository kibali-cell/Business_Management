<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use App\Models\BankAccount;
use Illuminate\Support\Facades\DB;

class UpdateCurrencyRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have at least one default currency
        $defaultCurrency = Currency::firstOrCreate(
            ['code' => 'USD'],
            [
                'name' => 'US Dollar',
                'symbol' => '$',
                'is_default' => true,
                'rate' => 1.0000
            ]
        );

        // Update bank accounts that don't have a currency_id
        $bankAccounts = BankAccount::whereNull('currency_id')->get();
        foreach ($bankAccounts as $account) {
            // Get the currency code from the old currency column if it exists
            $currencyCode = $account->currency ?? 'USD';
            
            // Find or create the currency
            $currency = Currency::firstOrCreate(
                ['code' => strtoupper($currencyCode)],
                [
                    'name' => strtoupper($currencyCode),
                    'symbol' => $currencyCode === 'USD' ? '$' : $currencyCode,
                    'is_default' => false,
                    'rate' => 1.0000
                ]
            );

            // Update the bank account with the currency_id
            $account->currency_id = $currency->id;
            $account->save();
        }
    }
}
