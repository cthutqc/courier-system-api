<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentStatus;
use App\Models\User;
use App\Notifications\BalanceRechargedNotification;

class PaymentService
{
    public function recharge($amount):void
    {
        auth()->user()->increment('balance', $amount);

        auth()->user()->notify(new BalanceRechargedNotification($amount));

    }

    public function process(Order $order):void
    {
        if ($order->customer->balance < $order->orderPrice()) {
            throw new \Exception('Insufficient balance.');
        }

        $order->payments()->create([
            'user_id' => auth()->user()->id,
            'payment_status' => PaymentStatus::PAID,
            'amount' => $order->orderPrice()
        ]);

        $order->courier->increment('balance', $order->orderPrice());

        $order->customer->decrement('balance', $order->orderPrice());

       // $commission = $order->total * 0.1; // Assume 10% commission
        //$courier->balance += $commission;

        $order->save();
    }
}
