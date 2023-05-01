<?php

namespace App\Models;

use App\Traits\HasStatus;
use App\Traits\Stopable;
use App\Traits\Startabled;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, HasStatus, Stopable, Startabled, SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'start_at' => 'datetime',
        'stop_at' => 'datetime',
        'desired_pick_up_date' => 'datetime',
        'desired_delivery_date' => 'datetime',
        'approximate_time' => 'string',
    ];

    public function sender(): MorphTo
    {
        return $this->morphTo();
    }

    public function receiver(): MorphTo
    {
        return $this->morphTo();
    }

    public function customer():BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function courier():BelongsTo
    {
        return $this->belongsTo(User::class, 'courier_id', 'id');
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderName():string
    {
        return $this->product->name ?? 'Заказ';
    }

    public function order_status():BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function scopeFilter(Builder $builder, $request = null):void
    {

        $builder->when(isset($request['name']), function ($q) use ($request){
                $q->orderBy(Product::select('name')->whereColumn('orders.product_id', 'products.id'), $request['name']);
            })
            ->when(isset($request['price']), function ($q) use ($request){
                $q->orderBy(Product::select('price')->whereColumn('orders.product_id', 'products.id'), $request['price']);
            })
            ->when(isset($request['active']), function ($q){
                $q->where('status', OrderStatus::ON_DELIVERY);
            })
            ->when(isset($request['finished']), function ($q){
                $q->where('status', OrderStatus::COMPLETED);
            })
            ->when(isset($request['search']), function ($q) use ($request){
                $q->whereHas('product', function ($q) use ($request){
                    $q->where('name', 'like', '%' . $request['search'] . '%');
                });
            })
            ->when(isset($request['product']), function ($q) use ($request){
               $q->whereHas('product', function ($q) use ($request){
                   $q->where('product_id', $request['product']);
               });
            });
    }
}
