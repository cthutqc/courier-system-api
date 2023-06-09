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
        Schema::create('courier_locations', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained();
            $table->decimal('latitude', 8, 6)->nullable();
            $table->decimal('longitude', 8, 6)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_locations');
    }
};
