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
        // 🔑 NOTA: La tabla debe llamarse 'logs' para coincidir con la excepción.
        Schema::create('logs', function (Blueprint $table) { 
            $table->id();
            
            // Relación con la tabla 'users'. Si el usuario es eliminado, el log permanece 
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users') 
                  ->onDelete('set null');
            
            // 🔑 Corregido: Usamos 'status' en lugar de 'activity_type' para coincidir con el controlador.
            $table->string('status', 50)->comment('E.g., success, failure, blocked'); 
            
            $table->string('ip_address', 45)->nullable();
            
            // 🔑 Columna faltante, necesaria para registrar el navegador/SO
            $table->text('user_agent')->nullable(); 
            
            $table->text('description')->nullable(); // Cambiado de 'details' a 'description' para coincidir con el controlador (línea 162)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};