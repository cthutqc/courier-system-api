<?php

namespace App\Http\Controllers\Api\V1\Courier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FinishOrderAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order)
    {
        $order->finish();

        return response()->json([
            'message' => 'You finished this order.',
        ], Response::HTTP_CREATED);
    }
}
