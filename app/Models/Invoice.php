<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable = [
        'invoice_number', 'customer_id', 'issue_date', 'due_date',
        'subtotal', 'tax', 'total', 'status', 'notes'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
