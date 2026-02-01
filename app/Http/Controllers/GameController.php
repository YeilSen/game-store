<?php

namespace App\Http\Controllers;

use App\Models\Game; // Asegúrate de importar el Modelo
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        // Obtenemos todos los juegos
        $games = Game::all();
        
        // Retornamos la vista 'catalog' (crearemos este archivo blade después)
        // Pasamos la variable $games a la vista
        return view('catalog', compact('games'));
    }
}