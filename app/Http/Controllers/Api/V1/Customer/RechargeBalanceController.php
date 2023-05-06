<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Заказчик
 *
 * @subgroup Финансы
 */
class RechargeBalanceController extends Controller
{
    /**
     * Пополнение баланса.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'amount' => ['required'],
        ]);

        $paymentService = new PaymentService();

        $paymentService->recharge($request->amount);

        return response()->json([
            'success' => 'Balance recharged.',
        ], Response::HTTP_CREATED);
    }
}
