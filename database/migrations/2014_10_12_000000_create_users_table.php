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
            $table->string('ci', 20)->unique();
            $table->string('name', 100); // Cambia el tamaño del campo 'name'
            $table->string('last_name', 100); // Cambia el tamaño del campo 'last_name'
            $table->string('email', 100)->unique(); // Cambia el tamaño del campo 'email'
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('rol_id')->constrained('rol')->onUpdate('cascade')->nullable()->onDelete('set null');
            $table->string('phone', 20)->nullable();
            $table->date('birthdate');
            $table->string('country', 30)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('urlPhoto')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
