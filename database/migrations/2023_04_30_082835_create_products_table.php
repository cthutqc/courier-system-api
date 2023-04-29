<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('text')->nullable();
            $table->foreignIdFor(\App\Models\Category::class)->nullable()->constrained();
            $table->boolean('active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });

        $products = [
            'Налоговый отчет',
            'Договор',
            'Личные документы',
        ];

        foreach ($products as $product) {

            $newProduct = \App\Models\Product::create([
                'name' => $product,
                'text' => fake()->text(),
                'category_id' => 1,
            ]);

            \App\Models\Rate::all()->each(function ($rate) use ($newProduct){

                \App\Models\ProductPrice::create([
                    'product_id' => $newProduct->id,
                    'rate_id' => $rate->id,
                    'amount' => rand(120, 1500),
                ]);

            });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
