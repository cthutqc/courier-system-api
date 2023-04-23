<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourierInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'address' => $this->address,
            'passport_series' => $this->passport_series,
            'passport_number' => $this->passport_number,
            'passport_issued_date' => $this->passport_issued_date,
            'passport_issued_by' => $this->passport_issued_by,
        ];
    }
}
