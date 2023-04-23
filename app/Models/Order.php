<?php

namespace App\Models;

use App\Traits\ChangeOrderStatusTrait;
use App\Traits\Finishabled;
use App\Traits\Startabled;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory, ChangeOrderStatusTrait, Finishabled, Startabled;

    protected $guarded = ['id'];

    protected $casts = [
        'desired_pick_up_date' => 'datetime',
        'desired_delivery_date' => 'datetime',
        'approximate_time' => 'string',
    ];

    public function customer():BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function courier():BelongsTo
    {
        return $this->belongsTo(User::class, 'courier_id', 'id');
    }

    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function order_status():BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function courier_transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function receipt()
    {
        return $this->courier_transactions()->sum('amount');
    }

    public function scopeFilter(Builder $builder, $request = null):void
    {
        $builder->when($request['active'], function ($q){
                $q->has('courier');
            })
            ->when($request['finished'], function ($q){
                $q->whereNotNull('stop_at');
            });
    }
}
