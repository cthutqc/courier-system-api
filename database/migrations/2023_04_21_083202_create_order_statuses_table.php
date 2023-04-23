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
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('order')->default(0);

            $table->timestamps();
        });

        $statuses = [
            'Отменен',
            'Принят',
            'Переводим',
            'Передан курьеру',
            'Курьер в пути',
            'Выполнен',
        ];

        foreach($statuses as $index => $status) {
            \App\Models\OrderStatus::create([
                'name' => $status,
                'order' => $index,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
