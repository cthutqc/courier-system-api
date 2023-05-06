<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\Partner;

/**
 * @group Заказчик
 *
 * @subgroup Контрагенты
 */
class PartnerController extends Controller
{
    /**
     * Список контрагентов.
     */
    public function index()
    {
        return Partner::where('user_id', auth()->user()->id)->get();
    }

    /**
     * Создание нового контрагента.
     */
    public function store(PartnerRequest $request)
    {
        $partner = Partner::create($request->validated());

        $partner->customer()->associate(auth()->user());

        $partner->save();

        return response()->json([
            'success' => 'Partner created.',
        ]);
    }

    /**
     * Информация о контрагенте.
     */
    public function show(Partner $partner)
    {
        return $partner;
    }

    /**
     * Обновление информации о контрагенте.
     */
    public function update(PartnerRequest $request, Partner $partner)
    {
        $partner->update($request->validated());

        return response()->json([
            'success' => 'Partner updated.',
        ]);
    }

    /**
     * Удаление контрагента.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return response()->json([
            'success' => 'Partner deleted.',
        ]);
    }
}
