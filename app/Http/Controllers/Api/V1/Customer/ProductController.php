<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
/**
 * @group Заказчик
 *
 * @subgroup Товары
 */
class ProductController extends Controller
{
    /**
     * Список товаров с фильтром по категориям.
     */
    public function index(Request $request)
    {
        return Product::query()
            ->when($request->category_id, function ($q) use($request){
                $q->where('category_id', $request->category_id);
            })->get();
    }

    /**
     * Информация о товаре.
     */
    public function show(Product $product)
    {
        return $product;
    }
}
