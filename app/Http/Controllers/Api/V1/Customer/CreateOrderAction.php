<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Events\NewOrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerOrderStoreRequest;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Response;

class CreateOrderAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CustomerOrderStoreRequest $request)
    {
        $order = Order::create($request->validated());

        $order->customer()->associate(auth()->user());

        foreach($request->products as $product)
        {
            $order->products()->attach($product);
        }

        $order->update([
            'price' => $order->products()->sum('price'),
        ]);

        $order->setStatus(OrderStatus::CREATED);

        if(app()->isProduction())
            event(new NewOrderCreated($order));

        return response()->json([
            'message' => 'Your order has been proceed.',
        ], Response::HTTP_CREATED);
    }
}
