<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Parental\HasParent;

class Courier extends User
{
    use HasFactory, HasParent;

    public function orders():HasMany
    {
        return $this->hasMany(Order::class, 'courier_id');
    }

    public function totalIncome():int
    {
        return $this->payments()
            ->where('type', Transaction::INCREMENT)
            ->sum('amount');
    }

    public function todayIncome():int
    {
        return $this->payments()
            ->where('type', Transaction::INCREMENT)
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');
    }

    public function todayTips():int
    {
        return $this->transactions()
            ->where('type', Transaction::TIPS)
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');
    }

    public function ratings():HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function avgRating()
    {
        return $this->ratings()->avg('score');
    }

    public function courier_location():HasOne
    {
        return $this->hasOne(CourierLocation::class);
    }
}
