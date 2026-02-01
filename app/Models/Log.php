<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     */
    protected $table = 'logs';

    /**
     * Los atributos que se pueden asignar masivamente (campos que se llenan con Log::create).
     */
    protected $fillable = [
        'user_id',
        'activity_type',
        'ip_address',
        'details',
        'status',      // ⬅️ AÑADIDO
        'user_agent',  // ⬅️ AÑADIDO
    ];

    /**
     * Define la relación: Un log pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        // Asegúrate de que tu modelo User se llama App\Models\User
        return $this->belongsTo(User::class);
    }
}