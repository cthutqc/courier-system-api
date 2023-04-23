<?php

namespace App\Traits;

use App\Models\Balance;
use App\Models\OrderStatus;
use App\Models\Transaction;

trait Finishabled
{
    public function finish():void
    {
        $this->update([
            'stop_at' => now(),
        ]);

        $this->setStatus(OrderStatus::SUCCESS);

        Transaction::create([
            'order_id' => $this->id,
            'user_id' => $this->courier->id,
            'amount' => $this->price,
            'type' => Transaction::TRANSACTION_TYPES[0]
        ]);

        if($this->descired_delivery_date < $this->stop_order) {

            Transaction::create([
                'order_id' => $this->id,
                'user_id' => $this->courier->id,
                'amount' => -100,
                'type' => Transaction::TRANSACTION_TYPES[1]
            ]);

        }

        $income = $this->receipt();

        $this->courier->balance->increment('amount', $income);

        $this->customer->balance->decrement('amount', $income);
    }
}
