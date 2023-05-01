<?php

namespace App\Http\Resources;

use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->product->name,
            'price' => $this->price,
            'status' => $this->status,
            'desired_delivery_date' => $this->desired_delivery_date,
            'remaining_time' => now()->diffInMinutes($this->desired_delivery_date, false),
            'address' => $this->when(auth()->user()->isCustomer(), $this->receiver->address()),
        ];
    }
}
