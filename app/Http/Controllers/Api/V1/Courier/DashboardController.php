<?php

namespace App\Http\Controllers\Api\V1\Courier;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourierDashboardResource;
use Illuminate\Http\Request;

/**
 * @group Курьер
 *
 * @subgroup Дашборд
 */
class DashboardController extends Controller
{
    /**
     * Главный экран курьера.
     */
    public function __invoke(Request $request)
    {
        return CourierDashboardResource::make($request->user());
    }
}
