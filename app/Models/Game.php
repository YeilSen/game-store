<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Si usas factories

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image_path'];
}