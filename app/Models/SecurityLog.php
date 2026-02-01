<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para registrar actividades de seguridad y de inicio de sesión.
 * Mapea a la tabla 'security_logs'.
 */
class SecurityLog extends Model
{
    use HasFactory;

    // Nombre de la tabla de la base de datos: ¡CRUCIAL!
    // Esto resuelve el problema de la tabla 'logs'
    protected $table = 'security_logs';

    // Campos que pueden ser llenados masivamente
    protected $fillable = [
        'user_id',
        'activity_type',
        'login_status', // Campo que la base de datos exigía
        'ip_address',
        'user_agent',
        'details',
    ];

    /**
     * Define la relación con el usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}