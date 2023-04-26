<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Events\NewOrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerOrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return OrderResource::collection(Order::query()
            ->where('customer_id', auth()->user()->id)
            ->filter($request)
            ->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerOrderStoreRequest $request)
    {
        if($request->sender_type == 'partner')
            $sender = 'App\Models\Partner';
        else
            $sender = 'App\Models\Customer';

        if($request->receiver_type == 'partner')
            $receiver = 'App\Models\Partner';
        else
            $receiver = 'App\Models\Customer';

        $order = Order::create([
            'product_id' => $request->product_id,
            'desired_pick_up_date' => $request->desired_pick_up_date,
            'desired_delivery_date' => $request->desired_delivery_date,
            'text' => $request->text,
            'sender_id' => $request->sender_id,
            'sender_type' => $sender,
            'receiver_id' => $request->receiver_id,
            'receiver_type' => $receiver,
            'customer_id' => auth()->user()->id,
            'status' => OrderStatus::AWAITING_MANAGER_APPROVAL
        ]);

        event(new NewOrderCreated($order));

        return response()->json([
            'success' => 'Order created.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if(auth()->user()->id !== $order->customer_id)
            abort(403);

        return OrderResource::make($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        if($request->sender_type == 'partner')
            $sender = 'App\Models\Partner';
        else
            $sender = 'App\Models\Customer';

        if($request->receiver_type == 'partner')
            $receiver = 'App\Models\Partner';
        else
            $receiver = 'App\Models\Customer';

        $order->update([
            'desired_pick_up_date' => $request->desired_pick_up_date,
            'desired_delivery_date' => $request->desired_delivery_date,
            'text' => $request->text,
            'sender_id' => $request->sender_id,
            'sender_type' => $sender,
            'receiver_id' => $request->receiver_id,
            'receiver_type' => $receiver,
        ]);

        return response()->json([
            'success' => 'Order updated.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function cancel(Order $order)
    {
        $order->setStatus(OrderStatus::CANCELED);

        return response()->json([
            'success' => 'Order canceled.',
        ], Response::HTTP_CREATED);
    }

    public function rate(Request $request, Order $order)
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
