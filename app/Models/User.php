<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes; 
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        // --- Campos de Baneo y Logeo ---
        'is_permanently_banned',
        'banned_at',
        'banned_until', // <-- NECESARIO para la comprobación del controlador
        'last_login_attempt_at', // <-- NECESARIO para actualizar el intento de login
        // ---------------------------------
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Agregado por convención si tienes esta columna
            // --- Casts de Baneo y Logeo Agregados ---
            'is_permanently_banned' => 'boolean',
            'banned_at' => 'datetime',
            'banned_until' => 'datetime', // <--- ¡LA SOLUCIÓN! Asegura que sea un objeto Carbon.
            'last_login_attempt_at' => 'datetime', // Asegura que este campo también sea un Carbon.
            // ---------------------------------
        ];
    }
}