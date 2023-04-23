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
            $table->integer('price')->default(0);

            $table->timestamps();
        });

        $products = [
            'Налоговый отчет',
            'Договор',
            'Личные документы',
        ];

        foreach ($products as $product) {

            \App\Models\Product::create([
                'name' => $product,
                'text' => fake()->text(),
                'price' => rand(100, 1500),
            ]);

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
