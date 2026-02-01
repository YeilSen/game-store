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
            // Agregamos una columna booleana para el estado de baneo permanente
            $table->boolean('is_permanently_banned')->default(false)->after('password');
            // Opcional: una columna para registrar cuándo fue baneado
            $table->timestamp('banned_at')->nullable()->after('is_permanently_banned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('banned_at');
            $table->dropColumn('is_permanently_banned');
        });
    }
};
