<?php

namespace App\Http\Controllers\Api\V1\Courier;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderListResource;
use App\Models\Order;
use Illuminate\Http\Request;
/**
 * @group Courier
 */
class SearchOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return OrderListResource::collection(Order::query()
            ->doesnthave('courier')
            ->sort($request->only('name', 'price', 'created_at', 'time'))
            ->get());
    }
}
