<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Campos asignables
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',

        // Baneo y seguridad
        'is_permanently_banned',
        'banned_at',
        'banned_until',
        'last_login_attempt_at',
    ];

    /**
     * Campos ocultos
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',

            'is_admin' => 'boolean',

            // Seguridad
            'is_permanently_banned' => 'boolean',
            'banned_at' => 'datetime',
            'banned_until' => 'datetime',
            'last_login_attempt_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Historial de compras del usuario
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}