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
        Schema::table('users', function (Blueprint $table) {
            // Columna 1: Contador de intentos fallidos (se reinicia a 0 en login exitoso o al bloquearse)
            $table->integer('failed_attempts')->default(0)->after('password');
            
            // Columna 2: Timestamp de baneo (la hora exacta en que termina el bloqueo de 10 minutos)
            $table->timestamp('banned_until')->nullable()->after('failed_attempts');
            
            // Columna 3: Registro temporal del último intento de login (para auditoría temporal)
            $table->timestamp('last_login_attempt_at')->nullable()->after('banned_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_login_attempt_at');
            $table->dropColumn('banned_until');
            $table->dropColumn('failed_attempts');
        });
    }
};