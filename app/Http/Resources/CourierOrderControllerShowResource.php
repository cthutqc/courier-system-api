<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourierOrderControllerShowResource extends JsonResource
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
            'name' => $this->orderName(),
            'text' => $this->text,
            'price' => $this->price,
            'status' => $this->status,
            'sender' => CustomerForOrderResource::make($this->sender),
            'receiver' => CustomerForOrderResource::make($this->receiver),
            'desired_pick_up_date' => $this->desired_pick_up_date ? $this->desired_pick_up_date->toDateTimeString() : null,
            'desired_delivery_date' => $this->desiredDeliveryTime(),
            'approximate_time' => $this->approximate_time,
            'remaining_time' => $this->remainingTime(),
            'start_at' => $this->start_at ? $this->start_at->toDateTimeString() : null,
            'stop_at' => $this->stop_at ? $this->stop_at->toDateTimeString() : null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
