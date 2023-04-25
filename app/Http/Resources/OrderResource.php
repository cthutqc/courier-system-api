<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'address_from' => $this->address_from,
            'address_to' => $this->address_to,
            'text' => $this->text,
            'product' => $this->product,
            'price' => $this->orderPrice(),
            'status' => $this->status,
            'courier' => $this->courier ? CourierResource::make($this->courier->load('courier_location')) : null,
            'customer' => CustomerResource::make($this->customer),
            'desired_pick_up_date' => $this->desired_pick_up_date ? $this->desired_pick_up_date->toDateTimeString() : null,
            'desired_delivery_date' => $this->desired_delivery_date? $this->desired_delivery_date->toDateTimeString() : null,
            'approximate_time' => $this->approximate_time,
            'remaining_time' => $this->approximate_time ? now()->diffInMinutes($this->approximate_time, false) : null,
            'start_at' => $this->start_at ? $this->start_at->toDateTimeString() : null,
            'stop_at' => $this->stop_at ? $this->stop_at->toDateTimeString()  : null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
