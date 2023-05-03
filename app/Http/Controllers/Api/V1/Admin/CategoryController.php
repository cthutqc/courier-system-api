<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Админ
 *
 * @subgroup Категории товаров
 */
class CategoryController extends Controller
{
    /**
     * Список категорий.
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Создание категории.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'
        ]);

        Category::create($request->only('name'));
    }

    /**
     * Инфомация о категории.
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Обновление информации о категории.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'
        ]);

        Category::create($request->only('name'));
    }

    /**
     * Удаление категории.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'success' => 'Category deleted.',
        ], Response::HTTP_OK);
    }
}
