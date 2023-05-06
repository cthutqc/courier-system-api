<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Админ
 *
 * @subgroup Товары
 */
class ProductController extends Controller
{
    /**
     * Список заказов.
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Создание товара.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'price' => ['required'],
            'category_id' => ['required'],
        ]);

        Product::create($request->only('name', 'text', 'price', 'active', 'category_id'));

        return response()->json([
            'success' => 'Product created.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Информация о товаре.
     */
    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    /**
     * Обновление данных товара.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['required'],
            'price' => ['required'],
            'category_id' => ['required'],
        ]);

        $product->update($request->only('name', 'text', 'price', 'active', 'category_id'));

        return response()->json([
            'success' => 'Product updated.',
        ], Response::HTTP_CREATED);
    }

    /**
     * Уделание товара.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => 'Product deleted.',
        ], Response::HTTP_OK);
    }
}
