<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones (cambia el nombre de la columna).
     */
    public function up(): void
    {
        // Esta es la corrección clave para evitar el conflicto con la palabra reservada 'status'
        // y para que coincida con la lógica de LoginLog.php y AuthenticatedSessionController.php.
        if (Schema::hasTable('logs') && Schema::hasColumn('logs', 'status')) {
            Schema::table('logs', function (Blueprint $table) {
                $table->renameColumn('status', 'login_status');
            });
        }
    }

    /**
     * Revierte las migraciones (cambia el nombre de la columna a la original).
     */
    public function down(): void
    {
        // Revertir el cambio si es necesario
        if (Schema::hasTable('logs') && Schema::hasColumn('logs', 'login_status')) {
            Schema::table('logs', function (Blueprint $table) {
                $table->renameColumn('login_status', 'status');
            });
        }
    }
};