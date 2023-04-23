<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminOrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return OrderResource::make($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminOrderUpdateRequest $request, Order $order)
    {
        $order->update($request->validated());

        return response()->json([
            'success' => 'Order updated.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'success' => 'Order deleted.',
        ], Response::HTTP_OK);
    }

    public function accepted(Order $order)
    {
        $order->setStatus(OrderStatus::ACCEPTED);

        return response()->json([
            'message' => 'Order accepted.',
        ], Response::HTTP_CREATED);
    }
}
