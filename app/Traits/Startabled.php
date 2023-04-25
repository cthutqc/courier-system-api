<?php

namespace App\Traits;

use App\Models\OrderStatus;

trait Startabled
{
    public function start():void
    {
        $this->courier()->associate(auth()->user());

        $this->start_at = now();

        $this->status = OrderStatus::ON_DELIVERY;

        $this->setStatus(OrderStatus::ON_DELIVERY);
    }
}
