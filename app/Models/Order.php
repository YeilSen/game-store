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

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Usuario dueño de la orden
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Productos comprados
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS AUXILIARES
    |--------------------------------------------------------------------------
    */

    // Generar número de orden único
    public static function generateOrderNumber()
    {
        return 'ORD-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    // Estados de orden
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

    // Estados de pago
    public static function getPaymentStatuses()
    {
        return [
            'pending' => 'Pendiente',
            'paid' => 'Pagado',
            'failed' => 'Fallido',
            'refunded' => 'Reembolsado'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (para mostrar bonito en vistas)
    |--------------------------------------------------------------------------
    */

    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total_amount, 2);
    }

    public function getStatusLabelAttribute()
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    public function getPaymentStatusLabelAttribute()
    {
        return self::getPaymentStatuses()[$this->payment_status] ?? $this->payment_status;
    }
    
}