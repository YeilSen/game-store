<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BanController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController; 
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; 

/*
|--------------------------------------------------------------------------
| RUTA PÚBLICA (CATÁLOGO)
|--------------------------------------------------------------------------
*/
Route::get('/', [GameController::class, 'index'])->name('catalog');

/*
|--------------------------------------------------------------------------
| RUTAS AUTENTICADAS (USUARIOS Y ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Carrito de compras
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); 
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Perfil de usuario 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard'); // 🚨 HE QUITADO ->middleware(['verified']) TEMPORALMENTE AQUÍ 🚨

    
});

/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRADOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Gestión de juegos
    Route::get('/games/create', [AdminController::class, 'createGame'])->name('games.create');
    Route::post('/games', [AdminController::class, 'storeGame'])->name('games.store');
    
    // Gestión de usuarios
    Route::get('/users', [AdminController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Logs de sesión 🔑 CORREGIDO: Usar AdminController y el método viewLoginLogs
    Route::get('/logs', [AdminController::class, 'viewLoginLogs'])->name('logs.index');
    
    // 🔑 NUEVAS RUTAS PARA EL CONTROL DE BANEO 🔑
    Route::get('/bans', [BanController::class, 'index'])->name('bans.index');
    Route::post('/bans/unban', [BanController::class, 'unban'])->name('bans.unban');
});

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';