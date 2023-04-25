<?php

namespace App\Http\Controllers\Api\V1\Courier;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourierOrderControllerShowResource;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
/**
 * @group Courier
 */
class OrdersController extends Controller
{

    public function index(Request $request)
    {
        if($request->list_all)
        {
            $q = Order::query()
                ->doesnthave('courier');
        } else {
            $q = $request->user()
                ->courierOrders();
        }

        $q->filter($request->all());

        return OrderListResource::collection($orders = $q->get());
    }

    public function show(Order $order, Request $request)
    {
        if(isset($order->courier_id) && $order->courier_id != auth()->user()->id)
            return response()->json([
                'error' => 'You cannot see this order.',
            ], Response::HTTP_FORBIDDEN);

        return CourierOrderControllerShowResource::make($order);
    }

    public function start(Order $order)
    {
        if($order->status != OrderStatus::ACCEPTED)
            return response()->json([
                'error' => 'You cannot start this order.',
            ], Response::HTTP_FORBIDDEN);

        $order->start();

        return response()->json([
            'message' => 'You pick up order.',
        ], Response::HTTP_CREATED);
    }

    public function finished(Order $order)
    {
        if($order->status != OrderStatus::ON_DELIVERY)
            return response()->json([
                'error' => 'You cannot finish this order.',
            ], Response::HTTP_FORBIDDEN);

        $order->finish();

        return response()->json([
            'message' => 'Order finished.',
        ], Response::HTTP_CREATED);
    }
}
