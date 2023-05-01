<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentStatus;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\BalanceRechargedNotification;

class PaymentService
{
    public function recharge($amount):void
    {
        auth()->user()->increment('balance', $amount);

        Transaction::create([
            'user_id' => auth()->user()->id,
            'amount' => $amount,
            'type' => Transaction::RECHARGE,
        ]);

        if(app()->isProduction())
            auth()->user()->notify(new BalanceRechargedNotification($amount));

    }

    public function process(Order $order):void
    {
        if ($order->customer->balance < $order->price) {
            throw new \Exception('Insufficient balance.');
        }

        $order->courier->increment('balance', $order->price);

        Transaction::create([
            'user_id' => $order->courier->id,
            'amount' => $order->price,
            'type' =>  Transaction::INCREMENT,
        ]);

        $order->customer->decrement('balance', $order->price);

        Transaction::create([
            'user_id' => $order->customer->id,
            'amount' => $order->price,
            'type' =>  Transaction::DECREMENT,
        ]);

       // $commission = $order->total * 0.1; // Assume 10% commission
        //$courier->balance += $commission;

        $order->save();
    }
}
