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
            'product' => $this->product,
            'sender' => $this->sender->contact_information ?: $this->sender,
            'receiver' => $this->receiver->contact_information ?: $this->receiver,
            'price' => $this->price,
            'rate' => Rate::where('id', $this->rate_id)->first(),
            'desired_delivery_date' => $this->desired_delivery_date,
            'remaining_time' => now()->diffInMinutes($this->desired_delivery_date, false),
            'start_at' => $this->start_at ?? null,
            'stop_at' => $this->stop_at ? $this->stop_at->toFormattedDateString() : null,
        ];
    }
}
