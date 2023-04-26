<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Parental\HasParent;

class Customer extends User
{
    use HasFactory, HasParent;

    public function orders():HasMany
    {
        return $this->hasMany(Order::class, 'courier_id');
    }
}
