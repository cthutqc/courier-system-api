<?php

namespace App\Traits;

trait HasStatus
{
    public function setStatus($status):void
    {
        $this->update([
            'status' => $status,
        ]);
    }
}
