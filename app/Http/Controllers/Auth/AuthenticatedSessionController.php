<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\SecurityLog;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; // 💡 ¡Asegúrate de que esta línea esté presente!

class AuthenticatedSessionController extends Controller
{
    // 🔑 Configuración del Baneo Temporal (5 intentos, 10 minutos)
    protected const MAX_ATTEMPTS = 5;
    protected const LOCKOUT_MINUTES = 10;

    /**
     * Muestra la vista de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Maneja la solicitud de autenticación entrante.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validación básica
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Buscar el usuario por email
        $user = User::where('email', $request->email)->first();

        // 🔑 REGISTRO TEMPORAL (Inicio del Intento): Guardar la hora del intento en la base de datos
        if ($user) {
            $user->last_login_attempt_at = Carbon::now();
            $user->save();
        }

        // 2. Comprobar Bloqueo Temporal ANTES de intentar el login
        if ($user && $user->banned_until && $user->banned_until->isFuture()) {
            $minutesRemaining = $user->banned_until->diffInMinutes(Carbon::now()) + 1;
            
            // Registrar intento fallido por estar bloqueado temporalmente
            $this->createPermanentLog($user->id, $request->ip(), 'failure', 'Intento de acceso bloqueado temporalmente.');
            
            throw ValidationException::withMessages([
                'email' => "Demasiados intentos. Estás bloqueado por aproximadamente {$minutesRemaining} minutos más. Por favor, espera."
            ]);
        }
        
        // 3. Intento de autenticación de Laravel
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            
            // ÉXITO: Iniciar sesión, limpiar contador de fallos
            $request->session()->regenerate();
            $this->clearLockout($user); // Reiniciar el contador de fallos
            
            // 🚨 MANTENEMOS ESTA LÓGICA COMENTADA PARA EL DIAGNÓSTICO
            /*
            $newToken = Str::random(60);
            Auth::user()->forceFill(['remember_token' => $newToken,])->save();
            $request->session()->put('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d', $newToken);
            */
            
            // Registrar Log permanente del éxito
            $this->createPermanentLog(Auth::id(), $request->ip(), 'success', 'Inicio de sesión exitoso.');

            // 💡 DIAGNÓSTICO CRÍTICO: Registramos el éxito ANTES de redirigir.
            Log::debug('LOGIN SUCESSO! ID de usuario autenticado: ' . Auth::id() . '. Redirigiendo a: ' . route('dashboard'));
            
            return redirect()->intended(route('dashboard', absolute: false));

        } else {
            
            // FALLO: Incrementar contador y aplicar baneo si se excede
            $this->incrementLockout($user);

            // Registrar Log permanente del fallo. Usamos 0 si no se encontró el usuario.
            $userId = $user ? $user->id : 0;
            $this->createPermanentLog($userId, $request->ip(), 'failure', 'Fallo de credenciales para email: ' . $request->email);

            // 4. Preparar mensaje de notificación (cuántos intentos quedan)
            if ($user) {
                if ($user->banned_until && $user->banned_until->isFuture()) {
                    $message = "Credenciales incorrectas. Has superado el límite de " . self::MAX_ATTEMPTS . " intentos. Bloqueado por " . self::LOCKOUT_MINUTES . " minutos.";
                } elseif ($user->failed_attempts > 0) {
                    $attemptsLeft = self::MAX_ATTEMPTS - $user->failed_attempts;
                    $message = "Credenciales incorrectas. Intentos restantes: {$attemptsLeft} antes del bloqueo temporal.";
                } else {
                    $message = 'Credenciales incorrectas.';
                }
            } else {
                $message = 'Credenciales incorrectas.';
            }

            throw ValidationException::withMessages([
                'email' => $message,
            ]);
        }
    }
    
    /**
     * Cierra la sesión del usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Registrar Log permanente de cierre de sesión
        if (Auth::check()) {
            $this->createPermanentLog(Auth::id(), $request->ip(), 'success', 'Cierre de sesión.');
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    // --- Funciones Auxiliares para el Baneo ---

    protected function clearLockout(?User $user): void
    {
        if (!$user) return;
        $user->failed_attempts = 0;
        $user->banned_until = null;
        $user->save();
    }

    protected function incrementLockout(?User $user): void
    {
        if (!$user) return; 

        $user->failed_attempts++;

        if ($user->failed_attempts >= self::MAX_ATTEMPTS) {
            $user->banned_until = Carbon::now()->addMinutes(self::LOCKOUT_MINUTES);
            $user->failed_attempts = 0;
        }
        $user->save();
    }

    protected function createPermanentLog(?int $userId, string $ip, string $status, string $description): void
    {
        $activityType = ($status === 'success') ? 'LOGIN' : 'FAILED_LOGIN';
        $loginStatus = ($status === 'success') ? 'SUCCESS' : 'FAILURE'; 
        
        if (class_exists(SecurityLog::class)) {
            try {
                SecurityLog::create([
                    'user_id'       => $userId,
                    'activity_type' => $activityType,
                    'ip_address'    => $ip,
                    'user_agent'    => request()->userAgent(),
                    'login_status'  => $loginStatus,
                    'details'       => $description
                ]);
            } catch (\Exception $e) {
                Log::error("Error al crear SecurityLog: " . $e->getMessage());
            }
        }
    }
}