<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const RECHARGE = 'recharge';
    const INCREMENT = 'increment';
    const DECREMENT = 'decrement';
    const TIPS = 'tips';
    const FINE = 'fine';

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
