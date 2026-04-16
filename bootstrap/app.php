<?php


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\CheckActiveSession; // 👈 AGREGAR ESTA LÍNEA


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->web(append: [
            // 1. Manejo de Cookies y Sesión
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            
            // 2. Resolver Modelos (es decir, el modelo User)
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            
            // 3. 🔑 AUTENTICACIÓN DE SESIÓN ÚNICA (DEBE IR AQUÍ O DESPUÉS)
            \Illuminate\Session\Middleware\AuthenticateSession::class, 

        ]);

        $middleware->alias([
            'admin' => IsAdmin::class,
            'check.session' => CheckActiveSession::class, // 👈 AGREGAR ESTA LÍNEA
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();