<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Response;

/**
 * @group Админ
 *
 * @subgroup Заказчики
 */
class CustomerController extends Controller
{
    /**
     * Список заказчиков.
     */
    public function index()
    {
        return CustomerResource::collection(Customer::all());
    }

    /**
     * Информация о заказчике.
     */
    public function show(Customer $customer)
    {
        return CustomerResource::make($customer);
    }

    /**
     * Обновление информации о заказчике.
     */
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return response()->json([
            'success' => 'Customer updated.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Удаление заказчика.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'success' => 'Customer deleted.',
        ], Response::HTTP_OK);
    }
}
