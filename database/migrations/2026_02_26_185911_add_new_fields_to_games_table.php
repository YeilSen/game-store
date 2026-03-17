<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('category')->nullable()->after('description');
            $table->enum('status', ['available', 'out_of_stock', 'discontinued'])->default('available')->after('category');
            $table->integer('discount_percent')->default(0)->after('price');
            $table->decimal('discounted_price', 8, 2)->nullable()->after('discount_percent');
            $table->softDeletes(); // Esto crea la columna deleted_at
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