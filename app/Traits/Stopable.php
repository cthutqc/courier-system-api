<?php

namespace App\Traits;

use App\Models\OrderStatus;
use App\Services\PaymentService;

trait Stopable
{
    public function stop(): void
    {
        $this->update([
            'stop_at' => now(),
        ]);

        $paymentService = new PaymentService();

        $paymentService->process($this);

        $this->setStatus(OrderStatus::COMPLETED);

    }
}
