<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // Categoría (puede ser string simple o foreign key)
            $table->string('category')->nullable()->after('description');
            
            // Estado del juego
            $table->enum('status', ['available', 'out_of_stock', 'discontinued'])
                  ->default('available')
                  ->after('category');
            
            // Descuento (porcentaje)
            $table->integer('discount_percent')->default(0)->after('price');
            
            // Precio con descuento (calculado automáticamente)
            $table->decimal('discounted_price', 8, 2)->nullable()->after('discount_percent');
            
            // Para soft delete (opcional - para "eliminar" sin borrar)
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['category', 'status', 'discount_percent', 'discounted_price']);
            $table->dropSoftDeletes();
        });
    }
};