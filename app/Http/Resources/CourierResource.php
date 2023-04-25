<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourierResource extends JsonResource
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
            'middle_name' => $this->middle_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'active' => $this->when(!auth()->user()->role('customer'), 'active'),
            'balance' => $this->when(!auth()->user()->role('customer'), 'balance'),
            'rating' => $this->avgRating(),
            'review' => ReviewResource::collection($this->ratings),
            'personal_information' => PersonalInformationResource::make($this->whenLoaded('personal_information')),
            'contact_information' => ContactInformationResource::make($this->whenLoaded('contact_information')),
            'courier_location' => CourierLocationResource::make($this->whenLoaded('courier_location')),
        ];
    }
}
