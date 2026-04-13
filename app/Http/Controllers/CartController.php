<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class CartController extends Controller
{
    // Mostrar carrito
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Agregar al carrito (usando accessors)
    public function addToCart($id)
    {
        $game = Game::findOrFail($id);
        
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $game->name,
                'price' => $game->final_price,           // Usa accessor
                'original_price' => $game->original_price, // Usa accessor
                'discount' => $game->discount_percent ?? 0,
                'quantity' => 1,
                'image' => $game->image_path,
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', '✓ Juego agregado al carrito');
    }

    // Actualizar cantidad
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            $quantity = max(1, (int)$request->quantity);
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Carrito actualizado');
    }

    // Remover item
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Producto eliminado');
    }

    // Limpiar carrito
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Carrito vaciado');
    }
}