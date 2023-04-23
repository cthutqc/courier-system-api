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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('sure_name')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active')->default(false);
            $table->rememberToken();

            $table->timestamps();
        });

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'toserg81@mail.ru',
            'password' => 'password',
            'active' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
