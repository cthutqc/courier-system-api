<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'sure_name' => $this->sure_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'active' => $this->when(!auth()->user()->role('courier'), 'active'),
            'balance' => $this->when(!auth()->user()->role('courier'), 'balance'),
        ];
    }
}
