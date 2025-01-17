<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'bank_name',
        'account_number',
        'account_type',
        'currency_id', // Changed from currency to currency_id for proper relationship
        'balance',
        'last_synced'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'last_synced' => 'datetime'
    ];

    // Relationship with Currency model
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    // Relationship with Transaction model
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Helper method to format balance with currency symbol
    public function getFormattedBalanceAttribute()
    {
        return $this->currency->symbol . ' ' . number_format($this->balance, 2);
    }

    // Helper method to sync account balance based on transactions
    public function updateBalance()
    {
        $this->balance = $this->transactions()->sum('amount');
        $this->last_synced = now();
        $this->save();
    }
}