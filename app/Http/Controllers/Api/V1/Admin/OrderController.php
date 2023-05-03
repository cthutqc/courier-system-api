<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminOrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
/**
 * @group Админ
 *
 * @subgroup Работа с заказами
 */
class OrderController extends Controller
{
    /**
     * Вывод всех заказов.
     */
    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    /**
     * Вывод одного заказа.
     */
    public function show(Order $order)
    {
        return OrderResource::make($order);
    }

    /**
     * Обновление данных заказа.
     */
    public function update(AdminOrderUpdateRequest $request, Order $order)
    {
        $order->update($request->validated());

        return response()->json([
            'success' => 'Order updated.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Удаление заказа.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'success' => 'Order deleted.',
        ], Response::HTTP_OK);
    }

    /**
     * Одобрение заказа.
     */
    public function accepted(Order $order)
    {
        $order->setStatus(OrderStatus::ACCEPTED);

        return response()->json([
            'message' => 'Order accepted.',
        ], Response::HTTP_CREATED);
    }
}
