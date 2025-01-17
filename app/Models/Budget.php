<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    //
    protected $fillable = [
        'category',
        'amount',
        'start_date',
        'end_date',
        'actual_amount',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'actual_amount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];
}
