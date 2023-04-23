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

            $table->string('address_from')->nullable();
            $table->string('address_to')->nullable();
            $table->integer('price')->default(0);
            $table->text('text')->nullable();
            $table->foreignId('courier_id')->nullable()->references('id')->on('users')->constrained();
            $table->foreignId('customer_id')->nullable()->references('id')->on('users')->constrained();
            $table->string('status')->default('created');
            $table->string('desired_pick_up_date')->nullable();
            $table->string('desired_delivery_date')->nullable();
            $table->string('approximate_time')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('stop_at')->nullable();

            $table->timestamps();
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
