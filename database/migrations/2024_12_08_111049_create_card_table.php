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
        Schema::create('card', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->nullable()->onDelete('set null');
            $table->string('owner', 200); // Propietario de la tarjeta
            $table->string('acc_num', 100); // Número de cuenta
            $table->string('end_month', 255)->nullable(); // Mes de expiración
            $table->string('end_year', 255); // Año de expiración
            $table->string('cvv', 255)->nullable(); // Cvv de la tarjeta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card');
    }
};
