<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourierDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name . substr($this->last_name, 0, 1) . '.',
            'total_income' => $this->totalIncome(),
            'current_orders_count' => $this->currentOrders(),
            'best_couriers' => CourierRatingResource::collection(User::role('courier')
                ->withAvg('rating', 'score')
                ->orderBy('rating_avg_score')
                ->take(3)
                ->get()),
        ];
    }
}
