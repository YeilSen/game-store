<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class BanController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios actualmente baneados.
     */
    public function index()
    {
        // Obtener usuarios cuyo 'banned_until' es una fecha futura
        $bannedUsers = User::where('banned_until', '>', Carbon::now())
                           ->orderBy('banned_until', 'asc')
                           ->get();

        // Esta vista (admin.bans.index) es la que necesitarás crear.
        return view('admin.bans.index', compact('bannedUsers'));
    }

    /**
     * Elimina el baneo de un usuario específico.
     * La solicitud POST contendrá el 'user_id' en el cuerpo.
     */
    public function unban(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        // 1. Quitar el baneo
        $user->banned_until = null;
        
        // 2. Limpiar intentos fallidos (esto es opcional, pero buena práctica)
        $user->failed_attempts = 0;

        $user->save();

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('admin.bans.index')->with('success', "El usuario {$user->email} ha sido desbaneado manualmente.");
    }
}