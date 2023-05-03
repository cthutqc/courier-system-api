<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Events\NewOrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerOrderStoreRequest;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Partner;
use App\Models\ProductPrice;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Заказчик
 *
 * @subgroup Заказы
 */
class OrderController extends Controller
{
    /**
     * Список заказов с фильтром.
     */
    public function index(Request $request)
    {
        return OrderListResource::collection(Order::query()
            ->where('customer_id', auth()->user()->id)
            ->filter($request)
            ->get());
    }

    /**
     * Создание заказа.
     */
    public function store(CustomerOrderStoreRequest $request)
    {
        $order = Order::create([
            'product_id' => $request->product_id,
            'rate_id' => $request->rate_id,
            'desired_pick_up_date' => $request->desired_pick_up_date,
            'desired_delivery_date' => $request->desired_delivery_date,
            'text' => $request->text,
            'customer_id' => auth()->user()->id,
            'price' => ProductPrice::query()
                ->where('product_id', $request->product_id)
                ->where('rate_id', $request->rate_id)
                ->first()
                ->amount,
            'status' => OrderStatus::AWAITING_MANAGER_APPROVAL,
            'door_to_door' => $request->door_to_door,
        ]);

        $order->sender()->associate($request->sender_type === 'partner' ? Partner::find($request->sender_id) : auth()->user());

        $order->receiver()->associate($request->receiver_type === 'partner' ? Partner::find($request->receiver_id) : auth()->user());

        $order->save();

        if(app()->isProduction())
            event(new NewOrderCreated($order));

        return response()->json([
            'order' => OrderResource::make($order),
            'success' => 'Order created.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Информация о заказе.
     */
    public function show(Order $order)
    {
        if(auth()->user()->id !== $order->customer_id)
            abort(403);

        return OrderResource::make($order);
    }

    /**
     * Обновление информации о заказе.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'desired_pick_up_date' => ['required'],
            'desired_delivery_date' => ['required'],
            'sender_id' => ['required'],
            'sender_type' => ['required'],
            'receiver_id' => ['required'],
            'receiver_type' => ['required'],
            'text' => ['sometimes'],
        ]);

        $order->update([
            'desired_pick_up_date' => $request->desired_pick_up_date,
            'desired_delivery_date' => $request->desired_delivery_date,
            'text' => $request->text,
        ]);

        $order->sender()->associate($request->sender_type === 'partner' ? Partner::find($request->sender_id) : auth()->user());

        $order->receiver()->associate($request->receiver_type === 'partner' ? Partner::find($request->receiver_id) : auth()->user());

        $order->save();

        return response()->json([
            'success' => 'Order updated.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Отмена заказа.
     */
    public function cancel(Order $order)
    {
        $order->setStatus(OrderStatus::CANCELED);

        return response()->json([
            'success' => 'Order canceled.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Оценка доставки.
     */
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
