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
        'unit_price', 
        'image_path',
        'category',
        'status',
        'discount_percent',
        'discounted_price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'discount_percent' => 'integer'
    ];

    // Accessor para obtener el precio base (normaliza unit_price a price)
    public function getPriceAttribute($value)
    {
        if (is_null($value) && $this->unit_price) {
            return $this->unit_price;
        }
        return $value;
    }

    // Precio final con descuento (el que se paga realmente)
    public function getFinalPriceAttribute()
    {
        $basePrice = $this->unit_price ?? $this->price ?? 0;
        $discount = $this->discount_percent ?? 0;
        
        if ($discount > 0) {
            return round($basePrice - ($basePrice * $discount / 100), 2);
        }
        return round($basePrice, 2);
    }

    // Precio original (sin descuento)
    public function getOriginalPriceAttribute()
    {
        return round($this->unit_price ?? $this->price ?? 0, 2);
    }

    // Ahorro por descuento
    public function getSavingsAttribute()
    {
        if ($this->has_discount) {
            return round($this->original_price - $this->final_price, 2);
        }
        return 0;
    }

    // Verificar si tiene descuento
    public function getHasDiscountAttribute()
    {
        return ($this->discount_percent && $this->discount_percent > 0);
    }

    // Accessor para obtener la URL de la imagen
    public function getImageAttribute()
    {
        if ($this->image_path) {
            return $this->image_path;
        }
        return 'games/default.jpg';
    }

    // ==================== SCOPES ====================
    
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