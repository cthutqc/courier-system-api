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
        Schema::create('courier_information', function (Blueprint $table) {
            $table->id();

            $table->integer('passport_series')->nullable();
            $table->integer('passport_number')->nullable();
            $table->string('passport_issued_by')->nullable();
            $table->string('passport_issued_date')->nullable();
            $table->string('address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_information');
    }
};
