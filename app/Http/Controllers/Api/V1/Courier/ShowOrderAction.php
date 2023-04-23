<?php

namespace App\Http\Controllers\Api\V1\Courier;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class ShowOrderAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order)
    {
        if(isset($order->courier_id) && auth()->user()->id !== $order->courier_id)
            abort(403);

        return OrderResource::make($order);
    }
}
