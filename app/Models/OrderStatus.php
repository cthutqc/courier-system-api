<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    //const CREATED  = 'created';
    const AWAITING_MANAGER_APPROVAL  = 'manager_approval';
    const ACCEPTED = 'accepted';
    const ON_DELIVERY = 'on_delivery';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';

    protected $guarded = ['id'];
}
