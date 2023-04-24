<?php

namespace App\Traits;

use App\Models\Balance;
use App\Models\OrderStatus;
use App\Models\Transaction;
use App\Services\PaymentService;

trait Finishabled
{
    public function finish():void
    {
        $this->update([
            'stop_at' => now(),
        ]);

        $this->setStatus(OrderStatus::SUCCESS);

        $paymentService = new PaymentService();

        $paymentService->process($this);

    }
}
