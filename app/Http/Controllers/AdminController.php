<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginLog;
use App\Models\User; 
use App\Models\Game;
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
    
    // Métodos existentes
    public function index() {
        // Ver usuarios para darlos de baja
        $users = User::where('is_admin', false)->get();
        return view('admin.users.index', compact('users')); 
    }

    /**
     * Mostrar formulario para crear juego (ACTUALIZADO con nuevos campos)
     */
    public function createGame()
    {
        $categories = ['Acción', 'Aventura', 'Deportes', 'Estrategia', 'RPG', 'Carreras'];
        return view('admin.create-game', compact('categories'));
    }

    /**
     * Guardar juego en la base de datos (ACTUALIZADO)
     */
    public function storeGame(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string',
            'status' => 'required|in:available,out_of_stock,discontinued',
            'discount_percent' => 'nullable|integer|min:0|max:100'
        ]);

        // Guardar imagen
        $path = $request->file('image')->store('games', 'public');

        // Preparar datos
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $path,
            'category' => $request->category,
            'status' => $request->status,
            'discount_percent' => $request->discount_percent ?? 0
        ];

        // Calcular precio con descuento si aplica
        if ($request->discount_percent > 0) {
            $discount = ($request->price * $request->discount_percent) / 100;
            $data['discounted_price'] = $request->price - $discount;
        }

        Game::create($data);

        return redirect()->back()->with('success', 'Juego subido con éxito 🎮');
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
                        ->paginate(20);

        return view('admin.login-logs', compact('logs'));
    }

    // =====================================================
    // 🔥 NUEVAS FUNCIONES PARA GESTIÓN DE JUEGOS 🔥
    // =====================================================

   

    /**
     * Mostrar formulario para editar juego
     */
    public function editGame($id)
    {
        $game = Game::withTrashed()->findOrFail($id);
        $categories = ['Acción', 'Aventura', 'Deportes', 'Estrategia', 'RPG', 'Carreras'];
        
        return view('admin.edit', compact('game', 'categories'));
    }

    /**
     * Actualizar juego en la base de datos
     */
    public function updateGame(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string',
            'status' => 'required|in:available,out_of_stock,discontinued',
            'discount_percent' => 'nullable|integer|min:0|max:100'
        ]);

        $game = Game::withTrashed()->findOrFail($id);

        // Preparar datos
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'status' => $request->status,
            'discount_percent' => $request->discount_percent ?? 0
        ];

        // Calcular precio con descuento
        if ($request->discount_percent > 0) {
            $discount = ($request->price * $request->discount_percent) / 100;
            $data['discounted_price'] = $request->price - $discount;
        } else {
            $data['discounted_price'] = null;
        }

        // Si hay nueva imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior (opcional)
            if ($game->image_path && file_exists(storage_path('app/public/' . $game->image_path))) {
                unlink(storage_path('app/public/' . $game->image_path));
            }
            
            $path = $request->file('image')->store('games', 'public');
            $data['image_path'] = $path;
        }

        $game->update($data);

        return redirect()->back()
                        ->with('success', 'Juego actualizado correctamente');                         
    }

    /**
     * Eliminar juego (Soft Delete)
     */
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return redirect()->back()->with('success', 'Juego eliminado correctamente');
    }

    /**
     * Restaurar juego eliminado
     */
    public function restoreGame($id)
    {
        $game = Game::withTrashed()->findOrFail($id);
        $game->restore();

        return redirect()->route('admin.games.index')
                         ->with('success', 'Juego restaurado correctamente');
    }

    /**
     * Cambiar estado del juego (Disponible/Agotado/Descontinuado)
     */
    public function changeGameStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:available,out_of_stock,discontinued'
        ]);

        $game = Game::findOrFail($id);
        $game->status = $request->status;
        $game->save();

        return redirect()->back()->with('success', 'Estado del juego actualizado');
    }

    /**
     * Aplicar descuento a un juego
     */
    public function applyDiscount(Request $request, $id)
    {
        $request->validate([
            'discount_percent' => 'required|integer|min:0|max:100'
        ]);

        $game = Game::findOrFail($id);
        $game->discount_percent = $request->discount_percent;
        
        // Calcular precio con descuento
        if ($request->discount_percent > 0) {
            $discount = ($game->price * $request->discount_percent) / 100;
            $game->discounted_price = $game->price - $discount;
        } else {
            $game->discounted_price = null;
        }
        
        $game->save();

        return redirect()->back()
                        ->with('success', 'Juego actualizado correctamente');        
    }

    /**
     * Quitar descuento de un juego
     */
    public function removeDiscount($id)
    {
        $game = Game::findOrFail($id);
        $game->discount_percent = 0;
        $game->discounted_price = null;
        $game->save();

        return redirect()->back()->with('success', 'Descuento eliminado');
    }
}