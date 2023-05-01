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

        $this->transfer(auth()->user()->id, $amount, Transaction::RECHARGE);

        if(app()->isProduction())
            auth()->user()->notify(new BalanceRechargedNotification($amount));

    }

    public function process(Order $order):void
    {
        if ($order->customer->balance < $order->price) {
            throw new \Exception('Insufficient balance.');
        }

        $amount = $order->price;

        $this->increase($order->courier, $amount, $order);

        $this->decrease($order->customer, $amount, $order);

        $this->fine($order);

        // $commission = $order->total * 0.1; // Assume 10% commission
        //$courier->balance += $commission;
    }

    private function fine($order):void
    {
        if($order->desired_delivery_date < now()) {

            $this->transfer($order->courier->id, -100, Transaction::FINE, $order);

            $this->transfer($order->customer->id, 100, Transaction::FINE, $order);

        }
    }

    private function increase($model, $amount, $data = []): void
    {
        $model->increment('balance', $amount);
        $this->transfer($model->id, $amount, Transaction::INCREMENT, $data);
    }

    private function decrease($model, $amount, $data = []): void
    {
        $model->decrement('balance', $amount);
        $this->transfer($model->id, $amount, Transaction::DECREMENT, $data);
    }

    public function transfer($accountId, $amount, $type, $data = []): void
    {
        Transaction::create([
            'user_id' => $accountId,
            'amount' => $amount,
            'type' =>  $type,
            'data' => $data->toJson()
        ]);
    }
}
