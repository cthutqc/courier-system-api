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
        auth()->user()->deposit($amount);

        if(app()->isProduction())
            auth()->user()->notify(new BalanceRechargedNotification($amount));

    }

    public function process(Order $order):void
    {
        if ($order->customer->balance < $order->price) {
            throw new \Exception('Insufficient balance.');
        }

        $order->customer->forceTransfer($order->courier, $order->price);

        // $commission = $order->total * 0.1; // Assume 10% commission
        //$courier->balance += $commission;
    }
}
