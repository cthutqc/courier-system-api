<?php

namespace App\Services;

use App\Models\Order;
use App\Notifications\BalanceRechargedNotification;
use Bavix\Wallet\External\Dto\Extra;
use Bavix\Wallet\External\Dto\Option;

class PaymentService
{
    public function recharge($amount): void
    {
        auth()->user()->deposit($amount);

        if (app()->isProduction()) {
            auth()->user()->notify(new BalanceRechargedNotification($amount));
        }

    }

    public function withdraw():void
    {

    }

    public function tips(Order $order, $tips): void
    {
        $order->customer->transfer($order->courier, $tips, new Extra(
            deposit: ['tips'],
            withdraw: new Option(meta: ['tips'], confirmed: false)
        ));
    }

    public function process(Order $order): void
    {
        $order->customer->transfer($order->courier, $order->price, new Extra(
            deposit: ['message' => 'deposit for order #'.$order->id],
            withdraw: new Option(meta: ['message' => 'withdraw for order #'.$order->id], confirmed: false)
        ));

        // $commission = $order->total * 0.1; // Assume 10% commission
        //$courier->balance += $commission;
    }
}
