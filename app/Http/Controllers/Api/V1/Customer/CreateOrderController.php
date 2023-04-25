<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Events\NewOrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerOrderStoreRequest;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\Product;
use Illuminate\Http\Response;
/**
 * @group Customer
 */
class CreateOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CustomerOrderStoreRequest $request)
    {

        $total_price = 0;

        foreach($request->products as $product)
        {
            $total_price += Product::find($product)->price;
        }

        if (auth()->user()->balance < $total_price) {
            throw new \Exception('Insufficient balance.');
        }

        $order = Order::create($request->validated());

        $order->customer()->associate(auth()->user());

        foreach($request->products as $product)
        {
            $order->products()->attach($product);
        }

        $order->update([
            'price' => $order->orderPrice(),
            //'payment_status' => PaymentStatus::PENDING,
        ]);

        $order->setStatus(OrderStatus::AWAITING_MANAGER_APPROVAL);

        if(app()->isProduction())
            event(new NewOrderCreated($order));

        return response()->json([
            'success' => 'Order created.',
        ], Response::HTTP_CREATED);
    }
}
