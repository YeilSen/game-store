<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insertar categorías por defecto
        DB::table('categories')->insert([
            [
                'name' => 'Acción',
                'slug' => 'accion',
                'description' => 'Juegos de acción y aventura',
                'icon' => 'bi-joystick',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Aventura',
                'slug' => 'aventura',
                'description' => 'Juegos de aventura gráfica',
                'icon' => 'bi-compass',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Deportes',
                'slug' => 'deportes',
                'description' => 'Juegos de deportes',
                'icon' => 'bi-trophy',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Estrategia',
                'slug' => 'estrategia',
                'description' => 'Juegos de estrategia',
                'icon' => 'bi-diagram-3',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'RPG',
                'slug' => 'rpg',
                'description' => 'Juegos de rol',
                'icon' => 'bi-dice-5',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Carreras',
                'slug' => 'carreras',
                'description' => 'Juegos de carreras',
                'icon' => 'bi-car-front',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Añadir foreign key a games (si usas tabla categories)
        Schema::table('games', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
        
        Schema::dropIfExists('categories');
    }
};