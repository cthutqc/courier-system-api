<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerDashboardResource;
use Illuminate\Http\Request;

/**
 * @group Заказчик
 *
 * @subgroup Дашборд
 */
class DashboardController extends Controller
{
    /**
     * Стартовый экран заказчика
     */
    public function __invoke(Request $request)
    {
        return CustomerDashboardResource::make($request->user());

    }
}
