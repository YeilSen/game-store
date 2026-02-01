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
        // 🔑 Asegúrate de que este nombre coincida con 'login_logs' en tu modelo
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            
            // Relación con la tabla 'users'. Si el usuario es eliminado, el log permanece 
            // y el campo 'user_id' se pone a NULL.
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users') // Asume que tu tabla de usuarios se llama 'users'
                  ->onDelete('set null');
            
            // Columna actualizada (antes 'activity_type') para alinearse con la lógica del controlador
            $table->string('status', 50)->comment('E.g., success, failure, blocked'); 
            
            $table->string('ip_address', 45)->nullable();
            
            // 🔑 Columna faltante, necesaria para registrar el navegador/SO
            $table->text('user_agent')->nullable(); 
            
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};
