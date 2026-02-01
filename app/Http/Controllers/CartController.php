<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Muestra lo que hay en el carrito
    public function index()
    {
        // Obtiene el carrito de la sesión. Si no existe, devuelve un array vacío.
        $cart = session()->get('cart', []);
        
        return view('cart.index', compact('cart'));
    }

    // Agrega un juego al carrito
    public function addToCart($id)
    {
        // Buscamos el juego por ID. Si no existe, da error 404 automático.
        $game = Game::findOrFail($id);

        // Obtenemos el carrito actual
        $cart = session()->get('cart', []);

        // Si el juego ya está en el carrito, aumentamos la cantidad
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Si no está, lo agregamos con cantidad 1
            $cart[$id] = [
                "name" => $game->name,
                "quantity" => 1,
                "price" => $game->price,
                "image" => $game->image_path
            ];
        }

        // Guardamos el array actualizado en la sesión
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Juego agregado al carrito exitosamente.');
    }

    // Procesa la compra (Limpiar carrito)
    public function checkout()
    {
        // Borramos la clave 'cart' de la sesión
        session()->forget('cart');

        // Retornamos la vista de confirmación
        return view('checkout.success');
    }
}
