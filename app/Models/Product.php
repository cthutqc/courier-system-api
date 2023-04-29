<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function product_prices():HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
