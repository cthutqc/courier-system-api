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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();

            $table->integer('amount')->default(0);
            $table->foreignIdFor(\App\Models\Product::class)->nullable()->constrained();
            $table->foreignIdFor(\App\Models\Rate::class)->nullable()->constrained();

            $table->timestamps();
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
        Schema::dropIfExists('product_prices');
    }
};
