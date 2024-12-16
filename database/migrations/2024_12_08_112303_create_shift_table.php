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
        Schema::create('shift', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // Nombre del turno
            $table->text('desc')->nullable(); // Descripción del turno
            $table->foreignId('company_id')->constrained('company')->onUpdate('cascade')->nullable()->onDelete('set null');
            $table->decimal('price', 8, 2); // Precio con 2 decimales
            $table->timestamp('start_date')->nullable(); // Fecha/hora de inicio de turno (timestamp)
            $table->timestamp('end_date')->nullable(); // Fecha/hora de fin de turno (timestamp)
            $table->string('state')->nullable(); // Estado del turno
            $table->string('urlPhoto')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift');
    }
};
