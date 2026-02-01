<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginLog;
use App\Models\User; 
use App\Models\Game; // Importar si se usa storeGame
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;

class AdminController extends Controller
{

    /**
     * Muestra la lista de usuarios para gestionar el baneo.
     */
    public function viewUsers()
    {
        // Obtener todos los usuarios, excluyendo al administrador actual.
        $users = User::where('id', '!=', auth()->id())
                     ->orderBy('id', 'asc')
                     ->paginate(15);
        
        return view('admin.users-management', compact('users'));
    }

    /**
     * Alterna el estado de baneo de un usuario (banear o desbanear permanente).
     */
    public function toggleBan(User $user)
    {
        // Lógica de baneo/desbaneo permanente...
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes banear tu propia cuenta de administrador.');
        }

        $user->is_banned = !$user->is_banned;
        $user->save();

        if ($user->is_banned) {
            DB::table('sessions')->where('user_id', $user->id)->delete();
            $message = "El usuario {$user->name} ha sido baneado permanentemente y su sesión ha sido cerrada.";
        } else {
            $message = "El usuario {$user->name} ha sido desbaneado permanentemente.";
        }

        return back()->with('success', $message);
    }
    
    /**
     * 🔑 NUEVO: Quita inmediatamente el bloqueo temporal por intentos fallidos.
     * Esta función es llamada desde la vista del administrador.
     */
    public function unbanTemp(User $user)
    {
        // Guarda de seguridad: No permitir la manipulación sobre sí mismo
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes alterar tu propio estado de bloqueo temporal.');
        }

        // 1. Verificar si tiene un bloqueo temporal activo (banned_until no es nulo y está en el futuro)
        if (!$user->banned_until || $user->banned_until->isPast()) {
            return back()->with('error', "El usuario {$user->name} no tiene un bloqueo temporal activo.");
        }

        // 2. Levantar el bloqueo y resetear el contador
        $user->banned_until = null;
        $user->failed_attempts = 0;
        $user->save();

        return back()->with('success', "El bloqueo temporal de {$user->name} ha sido levantado manualmente.");
    }
    
    // Métodos existentes (solo como referencia)
    public function index() {
        // Ver usuarios para darlos de baja
        $users = User::where('is_admin', false)->get();
        return view('admin.users.index', compact('users')); 
    }

    public function createGame() {
        return view('admin.create-game');
    }

    public function storeGame(Request $request) {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'price' => 'required|numeric'
        ]);

        // Guardar imagen
        $path = $request->file('image')->store('games', 'public');

        // NOTA: Asegúrate de que el modelo Game esté importado y exista
        Game::create([ 
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $path
        ]);

        return back()->with('success', 'Juego subido');
    }

    public function deleteUser(User $user) {
        $user->delete();
        return back()->with('success', 'Usuario eliminado');
    }

    public function viewLoginLogs()
    {
        // Obtener todos los logs y cargar la relación con el usuario (para el nombre)
        $logs = LoginLog::with('user')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20); // Paginación por si hay muchos logs

        return view('admin.login-logs', compact('logs'));
    }
}