<?php

namespace App\Http\Controllers\Api\V1\Courier;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
/**
 * @group Courier
 */
class ShowAllOrdersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return OrderResource::collection(Order::query()
            ->doesntHave('courier')
            ->get());
    }
}
