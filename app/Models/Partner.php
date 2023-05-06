<?php

namespace App\Models;

use App\Traits\FormattedInformation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Partner extends Model
{
    use HasFactory, FormattedInformation;

    protected $guarded = ['id'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function sender(): MorphOne
    {
        return $this->morphOne(Order::class, 'sender');
    }

    public function receiver(): MorphOne
    {
        return $this->morphOne(Order::class, 'receiver');
    }

    public function address(): string
    {
        return $this->attributes['street'].', '.$this->attributes['house'];
    }
}
