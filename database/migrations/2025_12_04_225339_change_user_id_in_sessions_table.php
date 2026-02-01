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
        // Usamos Schema::table para modificar la tabla existente 'sessions'
        Schema::table('sessions', function (Blueprint $table) {
            // 🔑 CORRECCIÓN: Cambiamos el tipo de la columna user_id a string
            $table->string('user_id', 60)->nullable()->change();
            // Nota: El método 'change()' requiere la dependencia 'doctrine/dbal'
            // Si la migración falla, es probable que debas instalarla.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No podemos saber el tipo de dato original exacto, 
        // pero asumiremos que era un BIGINT para el rollback (típico de Laravel).
        Schema::table('sessions', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable()->change();
        });
    }
};