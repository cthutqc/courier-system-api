<?php

namespace App\Http\Controllers\Api\V1\Courier;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourierOrderControllerShowResource;
use App\Http\Resources\OrderListResource;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Курьер
 *
 * @subgroup Работа с заказами.
 */
class OrdersController extends Controller
{
    /**
     * Список и фильтрация заказов.
     */
    public function index(Request $request)
    {
        if ($request->all) {
            $orders = Order::query()
                ->doesntHave('courier');
        } else {
            $orders = $request->user()
                ->orders();
        }

        $orders->filter($request->all());

        return response()->json([
            OrderListResource::collection($orders->get()),
        ]);
    }

    /**
     * Информация о заказе.
     */
    public function show(Order $order)
    {
        if (isset($order->courier_id) && $order->courier_id != auth()->user()->id) {
            return response()->json([
                'error' => 'You cannot see this order.',
            ], Response::HTTP_FORBIDDEN);
        }

        return CourierOrderControllerShowResource::make($order);
    }

    /**
     * Заказ принят к исполнению.
     */
    public function start(Order $order)
    {
        if ($order->status != OrderStatus::ACCEPTED) {
            return response()->json([
                'error' => 'You cannot start this order.',
            ], Response::HTTP_FORBIDDEN);
        }

        $order->start();

        return response()->json([
            'message' => 'You pick up order.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Заказ выполнен.
     */
    public function stop(Order $order)
    {
        if ($order->status != OrderStatus::ON_DELIVERY) {
            return response()->json([
                'error' => 'You cannot finish this order.',
            ], Response::HTTP_FORBIDDEN);
        }

        $order->stop();

        return response()->json([
            'message' => 'Order finished.',
        ], Response::HTTP_CREATED);
    }
}
