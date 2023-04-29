<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const DAILY  = 'daily';
    const URGENT = 'urgent';
    const EXTRA_URGENT = 'extra_urgent';

    public function product_prices():HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }
}
