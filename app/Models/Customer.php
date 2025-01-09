<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'company', 'status', 'custom_fields'];
    protected $casts = ['custom_fields' => 'array'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
