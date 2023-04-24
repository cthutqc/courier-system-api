<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
/**
 * @group Customer
 */
class RateOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order, Request $request)
    {
        Rating::create([
            'score' => $request->score,
            'review' => $request->review ?: null,
            'order_id' => $order->id,
            'user_id' => $order->courier->id,
        ]);

        return response()->json([
            'success' => 'You rate order.',
        ], Response::HTTP_CREATED);
    }
}
