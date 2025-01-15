<?php
// app/Services/Financial/BankIntegrationService.php
namespace App\Services\Financial;

use App\Models\BankAccount;
use App\Models\Transaction;
use GuzzleHttp\Client;

class BankIntegrationService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.bank_api.url'),
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.bank_api.key')
            ]
        ]);
    }

    public function syncTransactions(BankAccount $account)
    {
        try {
            // Example API call to fetch transactions
            $response = $this->client->get("/accounts/{$account->external_id}/transactions");
            $transactions = json_decode($response->getBody(), true);

            foreach ($transactions as $transaction) {
                Transaction::updateOrCreate(
                    ['external_id' => $transaction['id']],
                    [
                        'date' => $transaction['date'],
                        'amount' => $transaction['amount'],
                        'description' => $transaction['description'],
                        'type' => $this->mapTransactionType($transaction['type']),
                        'account_id' => $account->id
                    ]
                );
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Bank sync failed: ' . $e->getMessage());
            return false;
        }
    }

    private function mapTransactionType($bankType)
    {
        $typeMap = [
            'credit' => 'deposit',
            'debit' => 'withdrawal',
            // Add more mappings as needed
        ];

        return $typeMap[$bankType] ?? 'other';
    }
}