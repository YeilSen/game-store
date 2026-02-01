<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login; // ⬅️ Importamos el evento de Laravel para el inicio de sesión
use App\Listeners\LogSuccessfulLogin; // ⬅️ Importamos nuestro Listener personalizado

class EventServiceProvider extends ServiceProvider
{
    /**
     * El mapa de event listeners para la aplicación.
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // 🔑 LÍNEA CLAVE: Conecta el evento Login con nuestro Listener 🔑
        Login::class => [
            LogSuccessfulLogin::class,
        ],
    ];

    /**
     * Determina si los eventos y listeners deben ser descubiertos automáticamente.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}