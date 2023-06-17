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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->integer('price')->default(0);
            $table->text('text')->nullable();
            $table->foreignId('courier_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->string('status')->default('created');
            $table->string('desired_pick_up_date')->nullable();
            $table->string('desired_delivery_date')->nullable();
            $table->string('approximate_time')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('stop_at')->nullable();
            $table->boolean('door_to_door')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
