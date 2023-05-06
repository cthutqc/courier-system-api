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

        $rate = Rate::find($this->rate_id);

        return [
            'id' => $this->id,
            'name' => $this->product->name,
            'price' => $this->price,
            'status' => $this->status,
            'rate' => $rate->name,
            'desired_delivery_date' => $this->desiredDeliveryTime(),
            'remaining_time' => $this->remainingTime(),
            'address' => $this->receiver->address(),
        ];
    }
}
