<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'code',
        'name', 
        'symbol',
        'is_default',
        'rate'  // Adding rate for currency conversion functionality
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'rate' => 'decimal:4'
    ];

    // Get all bank accounts using this currency
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    // Helper method to get default currency
    public static function getDefault()
    {
        return static::where('is_default', true)->first();
    }

    public function setAsDefault()
    {
        // Remove default status from all other currencies
        static::where('is_default', true)->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }

    public function convert($amount, Currency $toCurrency)
    {
        if ($this->id === $toCurrency->id) {
            return $amount;
        }

        // Convert through base currency (usually USD)
        $baseAmount = $amount / $this->rate;
        return $baseAmount * $toCurrency->rate;
    }

    public function formatAmount($amount)
    {
        return $this->symbol . ' ' . number_format($amount, 2);
    }

    // Scope for active currencies
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

}
