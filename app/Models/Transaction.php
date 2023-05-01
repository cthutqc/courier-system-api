<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
jytfik
    const RECHARGE = 'recharge';
    const INCREMENT = 'increment';
    const DECREMENT = 'decrement';
    const TIPS = 'tips';
    const PENALTY = 'penalty';

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
