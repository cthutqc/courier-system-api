<?php

namespace App\Traits;

use App\Models\OrderStatus;

trait Startabled
{
    public function start():void
    {
        $this->update([
            'start_at' => now(),
        ]);

        $this->setStatus(OrderStatus::ON_DELIVERY);
    }
}
