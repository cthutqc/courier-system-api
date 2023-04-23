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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->integer('amount');
            $table->foreignId('order_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->enum('type', ['Receipts', 'Penalty', 'Pending', 'Withdrawal'])->default('Receipts');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_transactions');
    }
};
