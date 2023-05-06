<?php

namespace App\Http\Controllers\Api\V1\Courier;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourierRatingResource;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group Курьер
 */
class RatingsController extends Controller
{
    /**
     * Список курьеров с рейтингом.
     */
    public function __invoke(Request $request)
    {
        return CourierRatingResource::collection(User::role('courier')
            ->withAvg('ratings', 'score')
            ->orderByDesc('ratings_avg_score')
            ->get());
    }
}
