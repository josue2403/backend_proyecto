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
        Schema::create('rol', function (Blueprint $table) {
            $table->id();  // Crea una columna 'id' autoincremental
            $table->string('rol');     // Crea una columna 'rol' de tipo string
            $table->string('desc');     // Crea una columna 'desc' de tipo string
            $table->timestamps();     // Crea las columnas 'created_at' y 'updated_at'
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol');
    }
};
