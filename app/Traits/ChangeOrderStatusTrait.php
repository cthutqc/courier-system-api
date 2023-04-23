<?php

namespace App\Traits;

trait ChangeOrderStatusTrait
{
    public function setStatus($status):void
    {
        $this->update([
            'status' => $status,
        ]);
    }
}
