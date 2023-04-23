<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApprovedOrderAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order)
    {
        $order->setStatus(OrderStatus::ACCEPTED);

        return response()->json([
            'message' => 'Order approved.',
        ], Response::HTTP_CREATED);
    }
}
