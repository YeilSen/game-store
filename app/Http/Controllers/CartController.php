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

        // Calcular precio final con descuento si aplica
        $finalPrice = $game->has_discount ? $game->final_price : $game->price;

        // Si el juego ya está en el carrito, aumentamos la cantidad
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Si no está, lo agregamos con cantidad 1 y todos los datos relevantes
            $cart[$id] = [
                "name" => $game->name,
                "quantity" => 1,
                "price" => $finalPrice,  // Precio con descuento
                "original_price" => $game->price,  // Precio original (para referencia)
                "image" => $game->image_path,
                "has_discount" => $game->has_discount,
                "discount_percent" => $game->discount_percent ?? 0
            ];
        }

        // Guardamos el array actualizado en la sesión
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Juego agregado al carrito exitosamente.');
    }

    // Eliminar item del carrito
    public function remove($id)
    {
        $cart = session()->get('cart');
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Juego eliminado del carrito');
        }
        
        return redirect()->back()->with('error', 'Juego no encontrado en el carrito');
    }

    // Actualizar cantidad
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);
        
        $cart = session()->get('cart');
        
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Cantidad actualizada');
        }
        
        return redirect()->back()->with('error', 'Juego no encontrado en el carrito');
    }

    // Vaciar carrito completo
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado correctamente');
    }
    
    // Procesa la compra (Redirige al nuevo checkout)
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }
        
        // Redirigir al nuevo checkout con métodos de pago
        return redirect()->route('checkout');
    }

    // Sincronizar carrito con precios actualizados de la base de datos
    public function syncCart()
    {
        $cart = session()->get('cart', []);
        $updated = false;
        
        foreach ($cart as $id => $item) {
            $game = Game::find($id);
            
            // Si el juego no existe o está eliminado, eliminarlo del carrito
            if (!$game || $game->trashed()) {
                unset($cart[$id]);
                $updated = true;
                continue;
            }
            
            // Actualizar precio con descuento si es necesario
            $newPrice = $game->has_discount ? $game->final_price : $game->price;
            
            if ($cart[$id]['price'] != $newPrice) {
                $cart[$id]['price'] = $newPrice;
                $cart[$id]['original_price'] = $game->price;
                $cart[$id]['has_discount'] = $game->has_discount;
                $cart[$id]['discount_percent'] = $game->discount_percent ?? 0;
                $updated = true;
            }
            
            // Verificar que el juego esté disponible para compra
            if ($game->status != 'available') {
                // Marcar como no disponible o eliminarlo
                unset($cart[$id]);
                $updated = true;
            }
        }
        
        if ($updated) {
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('info', 'Carrito sincronizado con los precios actualizados');
    }
}