<?php

namespace App\Http\Resources;

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
            'product' => $this->product,
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'price' => $this->price,
            'desired_delivery_date' => $this->desired_delivery_date,
            'remaining_time' => now()->diffInMinutes($this->desired_delivery_date, false),
            'stop_at' => $this->stop_at ? $this->stop_at->toFormattedDateString() : null,
        ];
    }
}
