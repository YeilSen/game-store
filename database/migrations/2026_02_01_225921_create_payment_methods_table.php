<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "Tarjeta de Crédito", "Transferencia Bancaria"
            $table->string('code')->unique(); // "credit_card", "bank_transfer"
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });
        
        // Insertar métodos de pago por defecto
        DB::table('payment_methods')->insert([
            [
                'name' => 'Tarjeta de Crédito/Débito',
                'code' => 'credit_card',
                'is_active' => true,
                'description' => 'Pago con tarjeta Visa, Mastercard, etc.',
                'icon' => 'bi-credit-card',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Transferencia Bancaria',
                'code' => 'bank_transfer',
                'is_active' => true,
                'description' => 'Transferencia a nuestra cuenta bancaria',
                'icon' => 'bi-bank',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};