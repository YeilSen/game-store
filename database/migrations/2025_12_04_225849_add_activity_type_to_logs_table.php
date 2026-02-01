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
        // Modificamos la tabla 'logs'
        Schema::table('logs', function (Blueprint $table) {
            // 🔑 AÑADIR activity_type (string para LOGIN, LOGOUT, etc.)
            $table->string('activity_type', 20)->after('user_id');
            
            // Si las columnas 'status' y 'user_agent' también faltan, puedes descomentar estas líneas:
            // $table->string('status', 20)->default('SUCCESS')->after('activity_type');
            // $table->text('user_agent')->nullable()->after('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la columna en caso de rollback
        Schema::table('logs', function (Blueprint $table) {
            $table->dropColumn('activity_type');
        });
    }
};