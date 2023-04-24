<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
/**
 * @group Customer
 */
class ShowAllOrdersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return OrderResource::collection(Order::query()
            ->where('customer_id', auth()->user()->id)
            ->filter($request)
            ->get());
    }
}
