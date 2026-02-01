<?php

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginLog; // Importamos el modelo correcto
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Muestra la lista de logs de actividad (inicios de sesión).
     */
    public function index()
    {
        // 1. Obtener los logs, ordenados por fecha de creación descendente.
        // Usamos with('user') para cargar el usuario relacionado en la misma consulta
        // y evitar problemas de N+1.
        $logs = LoginLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20); // Paginamos para evitar cargar demasiados datos a la vez.

        // 2. Retornar la vista y pasar los logs.
        return view('admin.logs', compact('logs'));
    }
}