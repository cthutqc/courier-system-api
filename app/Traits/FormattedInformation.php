<?php

namespace App\Traits;

trait FormattedInformation
{
    public function displayedName():string
    {
        return $this->name . ' ' . substr($this->last_name, 0, 1) . '.';
    }
}
