<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Parental\HasParent;

class Customer extends User
{
    use HasFactory, HasParent;

    public function orders():HasMany
    {
        return $this->hasMany(Order::class, 'courier_id');
    }

    public function partners():HasMany
    {
        return $this->hasMany(Partner::class, 'user_id');
    }

    public function sender(): MorphOne
    {
        return $this->morphOne(Order::class, 'sender');
    }

    public function receiver(): MorphOne
    {
        return $this->morphOne(Order::class, 'receiver');
    }
}