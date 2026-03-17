<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'image_path',
        'category',
        'status',
        'discount_percent',
        'discounted_price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'discount_percent' => 'integer'
    ];

    // Precio final con descuento
    public function getFinalPriceAttribute()
    {
        if ($this->discount_percent > 0) {
            return $this->price - ($this->price * $this->discount_percent / 100);
        }
        return $this->price;
    }

    // Verificar si tiene descuento
    public function getHasDiscountAttribute()
    {
        return $this->discount_percent > 0;
    }

    // Filtro para juegos disponibles
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Filtro por categoría
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Filtro para juegos con descuento
    public function scopeOnSale($query)
    {
        return $query->where('discount_percent', '>', 0);
    }

    // Búsqueda por nombre o descripción
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }
}