<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'bank_name',
        'account_number',
        'transaction_reference',
        'card_last_four',
        'card_brand',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Generar número de orden único
    public static function generateOrderNumber()
    {
        $prefix = 'ORD-';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        
        return $prefix . $date . '-' . $random;
    }

    // Estados posibles
    public static function getStatuses()
    {
        return [
            'pending' => 'Pendiente',
            'processing' => 'Procesando',
            'completed' => 'Completado',
            'cancelled' => 'Cancelado',
            'failed' => 'Fallido'
        ];
    }

    public static function getPaymentStatuses()
    {
        return [
            'pending' => 'Pendiente',
            'paid' => 'Pagado',
            'failed' => 'Fallido',
            'refunded' => 'Reembolsado'
        ];
    }
}