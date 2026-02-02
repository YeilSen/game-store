<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending'); // pending, processing, completed, cancelled, failed
            $table->string('payment_method')->nullable(); // credit_card, bank_transfer
            $table->string('payment_status')->default('pending'); // pending, paid, failed, refunded
            
            // Información de facturación (opcional)
            $table->string('billing_name')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->text('billing_address')->nullable();
            
            // Para transferencia bancaria
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('transaction_reference')->nullable();
            
            // Para tarjeta (simulado - en producción usar pasarela)
            $table->string('card_last_four')->nullable();
            $table->string('card_brand')->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};