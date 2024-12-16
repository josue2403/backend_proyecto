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
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // Nombre de la empresa
            $table->text('desc')->nullable(); // Descripción de la empresa
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->nullable()->onDelete('set null');
            $table->foreignId('category_id')->constrained('category')->onUpdate('cascade')->nullable()->onDelete('set null');
            $table->string('country', 100); // País
            $table->string('city', 100); // Ciudad
            $table->string('street1', 255); // Primera línea de dirección
            $table->string('street2', 255)->nullable(); // Segunda línea de dirección
            $table->string('street3', 255)->nullable(); // Tercera línea de dirección
            $table->string('state'); // Estado en la aplicación
            $table->string('urlPhoto')->nullable();
            $table->integer('popularidad')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
