<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanciaalReport extends Model
{
    //
    protected $fillable = [
        'report_type',
        'start_date',
        'end_date',
        'data',
        'generated_by'
    ];

    protected $casts = [
        'data' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
