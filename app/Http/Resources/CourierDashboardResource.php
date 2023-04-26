<?php

namespace App\Http\Resources;

use App\Models\Courier;
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
            'name' => $this->name . ' ' . substr($this->last_name, 0, 1) . '.',
            'total_income' => $this->totalIncome(),
            'today_income' => $this->todayIncome(),
            'today_tips' => $this->todayTips(),
            'current_orders_count' => $this->orders(),
            'best_couriers' => CourierRatingResource::collection(Courier::query()
                ->withAvg('ratings', 'score')
                ->orderByDesc('ratings_avg_score')
                ->take(3)
                ->get()),
        ];
    }
}
