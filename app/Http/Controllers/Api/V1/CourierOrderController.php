<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\CourierTakeOrder;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CourierOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return OrderResource::collection(Order::query()
            ->doesntHave('courier')
            ->get());
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if(auth()->user()->id !== $order->courier_id)
            abort(403);

        return OrderResource::make($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->update([
            'approximate_time' => $request->approximate_time ?? null,
        ]);

        $order->courier()->associate(auth()->user());

        $order->setStatus(OrderStatus::ON_DELIVERY);

        if(app()->isProduction())
            event(new CourierTakeOrder($order));

        return response()->json([
            'message' => 'You accept to proceed this order.',
        ], Response::HTTP_CREATED);
    }

    public function start(Order $order)
    {
        $order->start();

        return response()->json([
            'message' => 'You pick up order.',
        ], Response::HTTP_CREATED);
    }

    public function finished(Order $order)
    {
        $order->finish();

        return response()->json([
            'message' => 'You finished this order.',
        ], Response::HTTP_CREATED);
    }
}
