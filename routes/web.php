<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BanController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController; 
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
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
    
    // Rutas para gestión del carrito
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Checkout y pagos
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'processPayment'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Perfil de usuario 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRADOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Juegos
    Route::get('/games', [AdminController::class, 'listGames'])->name('games.index');

    Route::get('/games/create', [AdminController::class, 'createGame'])->name('games.create');

    Route::post('/games', [AdminController::class, 'storeGame'])->name('games.store');

    Route::get('/games/{id}/edit', [AdminController::class, 'editGame'])->name('games.edit');

    Route::put('/games/{id}', [AdminController::class, 'updateGame'])->name('games.update');

    Route::delete('/games/{id}', [AdminController::class, 'destroy'])->name('games.delete');


    // Usuarios
    Route::get('/users', [AdminController::class, 'index'])->name('users.index');

    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');


    // Logs
    Route::get('/logs', [AdminController::class, 'viewLoginLogs'])->name('logs.index');


    // Baneos
    Route::get('/bans', [BanController::class, 'index'])->name('bans.index');

    Route::post('/bans/unban', [BanController::class, 'unban'])->name('bans.unban');

});

Route::get('/cookies-policy', function () {
    return view('cookies-policy');
})->name('cookies-policy');
/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';