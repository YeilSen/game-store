<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'game_id',
        'game_name',
        'quantity',
        'unit_price',
        'image',
        'subtotal'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relación con orden
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relación con juego
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}