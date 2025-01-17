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
}
