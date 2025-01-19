<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Currency;



class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $currencies = [
        ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'rate' => 1.00000, 'is_default' => true],
        ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'rate' => 0.91234],
        ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£', 'rate' => 0.78901],
        ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥', 'rate' => 110.45678],
    ];

    foreach ($currencies as $currency) {
        Currency::updateOrCreate(
            ['code' => $currency['code']], // Search criteria
            $currency // Data to insert/update
        );
    }
}

}
