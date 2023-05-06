<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourierUpdateRequest;
use App\Http\Resources\CourierResource;
use App\Models\Courier;
use Illuminate\Http\Response;

/**
 * @group Админ
 *
 * @subgroup Курьеры
 */
class CourierController extends Controller
{
    /**
     * Список курьеров.
     */
    public function index()
    {
        return CourierResource::collection(Courier::all());
    }

    /**
     * Информация о курьере.
     */
    public function show(Courier $courier)
    {
        $courier->load('personal_information');

        $courier->load('contact_information');

        return CourierResource::make($courier);
    }

    /**
     * Обновление данных курьера.
     */
    public function update(CourierUpdateRequest $request, Courier $courier)
    {
        $courier->update($request->only('name', 'last_name', 'middle_name', 'email', 'phone'));

        $courier->personal_information()->update($request->only('passport_series', 'passport_number', 'passport_issued_by', 'passport_issued_date'));

        return response()->json([
            'success' => 'Courier updated.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Удаление курьера.
     */
    public function destroy(Courier $courier)
    {
        $courier->delete();

        return response()->json([
            'success' => 'Courier deleted.',
        ], Response::HTTP_OK);
    }
}
