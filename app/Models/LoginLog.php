<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginLog extends Model
{
    use HasFactory;
    
    // 🔑 CORREGIDO: Cambiamos a 'logs' porque tu base de datos inserta en esa tabla.
    // Esto asegura que la vista lea los registros existentes.
    protected $table = 'logs';

    // Asegúrate de que todos los campos sean fillable
    protected $fillable = [
        'user_id',
        'activity_type',
        'ip_address',
        'user_agent',
        'details',
    ];

    /**
     * Relación: Un log pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}