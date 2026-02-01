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
        // Define la estructura de la tabla 'security_logs'.
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();

            // Clave foránea al usuario, puede ser nula si el intento de login falla (antes de autenticar).
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            // Tipo de actividad (ej: 'LOGIN', 'FAILED_LOGIN', 'PASSWORD_RESET').
            $table->string('activity_type', 50);

            // Estado del login. Este es el campo crucial que faltaba para resolver el error 1364.
            $table->string('login_status', 20)->nullable(); 

            // Información técnica
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('details')->nullable(); // Descripción detallada del evento

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_logs');
    }
};
