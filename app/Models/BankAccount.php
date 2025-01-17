<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'bank_name',
        'account_number',
        'account_type',
        'currency',
        'balance',
        'last_synced'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'last_synced' => 'datetime'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}