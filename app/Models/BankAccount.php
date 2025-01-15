<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'name', 'account_number', 'bank_name',
        'external_id', 'last_synced_at'
    ];

    protected $casts = [
        'last_synced_at' => 'datetime'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}