<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const TRANSACTION_TYPES = [
        'Receipts',
        'Penalty',
        'Withdrawal'
    ];
}
