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
        Schema::table('login_logs', function (Blueprint $table) {
            // 🔑 Modifica la columna 'user_id' para que sea NULLABLE.
            // Esto permite registrar intentos de inicio de sesión fallidos
            // incluso si el email no corresponde a un usuario existente.
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('login_logs', function (Blueprint $table) {
            // Revertir a NOT NULL.
            // Esto fallará si hay registros con user_id=NULL.
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};