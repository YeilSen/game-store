<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Game;
use App\Models\User;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
        'quantity',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'quantity' => 'integer'
    ];

    // RELACIÓN CON GAME
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    // RELACIÓN CON USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
