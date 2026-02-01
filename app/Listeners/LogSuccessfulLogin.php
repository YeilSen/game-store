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
            // 🔑 AÑADIR activity_type (string para LOGIN, LOGOUT, etc.) - Soluciona el error actual
            $table->string('activity_type', 20)->after('user_id');
            
            // AÑADIMOS status y user_agent, que se necesitan para la funcionalidad completa del log
            $table->string('status', 20)->default('SUCCESS')->after('activity_type');
            $table->text('user_agent')->nullable()->after('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar las tres columnas añadidas en caso de rollback
        Schema::table('logs', function (Blueprint $table) {
            $table->dropColumn(['activity_type', 'status', 'user_agent']);
        });
    }
};