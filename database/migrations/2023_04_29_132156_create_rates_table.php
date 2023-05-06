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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('delivery_time')->nullable();

            $table->timestamps();
        });

        $rates = [
            [
                'name' => 'Суточный',
                'delivery_time' => 24,
                // 'code' => \App\Models\Rate::DAILY
            ],
            [
                'name' => 'Срочный',
                'delivery_time' => 6,
                //   'code' => \App\Models\Rate::URGENT
            ],
            [
                'name' => 'Сверхсрочный',
                'delivery_time' => 1,
                //  'code' => \App\Models\Rate::EXTRA_URGENT
            ],
        ];

        foreach ($rates as $rate) {
            \App\Models\Rate::create($rate);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
