<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Game;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    // Mostrar formulario de checkout
    public function showCheckout()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }
        
        // Calcular total con precios actualizados desde la BD (con descuentos)
        $total = 0;
        $updatedCart = [];
        
        foreach ($cart as $id => $item) {
            $game = Game::find($id);
            if ($game && !$game->trashed() && $game->status == 'available') {
                // Usar precio con descuento si existe
                $finalPrice = $game->has_discount ? $game->final_price : $game->price;
                $updatedCart[$id] = $item;
                $updatedCart[$id]['price'] = $finalPrice;
                $updatedCart[$id]['original_price'] = $game->price;
                $updatedCart[$id]['has_discount'] = $game->has_discount;
                $updatedCart[$id]['discount_percent'] = $game->discount_percent ?? 0;
                $total += $finalPrice * $item['quantity'];
            } else {
                // Si el juego no existe o no está disponible, eliminarlo del carrito
                unset($cart[$id]);
            }
        }
        
        // Actualizar el carrito en sesión con los precios correctos
        session()->put('cart', $updatedCart);
        
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        
        return view('checkout', compact('updatedCart', 'total', 'paymentMethods'));
    }
    
    // Procesar el pago
    public function processPayment(Request $request)
    {
        // DEPURACIÓN
        Log::info('=== INICIO PROCESAMIENTO PAGO ===');
        Log::info('Datos recibidos:', $request->all());
        
        $cart = session('cart', []);
        Log::info('Carrito:', $cart);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }
        
        $request->validate([
            'payment_method' => 'required|in:credit_card,bank_transfer',
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email',
            'billing_phone' => 'nullable|string|max:20',
            'billing_address' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Calcular total con precios CON descuento
            $total = 0;
            $items = [];
            
            foreach ($cart as $gameId => $item) {
                $game = Game::find($gameId);
                if (!$game) {
                    throw new \Exception("El juego con ID {$gameId} no existe.");
                }
                
                // Verificar que el juego esté disponible
                if ($game->trashed() || $game->status != 'available') {
                    throw new \Exception("El juego {$game->name} no está disponible para compra.");
                }
                
                // Calcular precio final con descuento (usar el precio del carrito que ya está actualizado)
                $finalPrice = $item['price']; // El precio ya viene con descuento del showCheckout
                $subtotal = $finalPrice * $item['quantity'];
                $total += $subtotal;
                
                $items[] = [
                    'game_id' => $gameId,
                    'quantity' => $item['quantity'],
                    'unit_price' => $finalPrice,
                    'original_price' => $game->price,
                    'subtotal' => $subtotal,
                    'has_discount' => $game->has_discount,
                    'discount_percent' => $game->discount_percent ?? 0
                ];
            }
            
            Log::info('Total calculado CON descuentos: ' . $total);
            
            // Crear número de orden manualmente
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            
            // Crear la orden (con el total CORRECTO con descuentos)
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'total_amount' => $total, // Este es el total CON descuentos
                'status' => 'completed',
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid',
                'billing_name' => $request->billing_name,
                'billing_email' => $request->billing_email,
                'billing_phone' => $request->billing_phone,
                'billing_address' => $request->billing_address,
                'notes' => $request->notes,
            ]);
            
            Log::info('Orden creada ID: ' . $order->id . ' - Número: ' . $order->order_number . ' - Total: $' . $total);
            
            // Crear items de la orden
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'game_id' => $item['game_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal']
                ]);
            }
            
            Log::info('Items creados: ' . count($items));
            
            // Limpiar carrito
            session()->forget('cart');
            
            DB::commit();
            
            Log::info('Pago exitoso, redirigiendo a éxito');
            
            return redirect()->route('checkout.success', ['order' => $order->order_number])
                ->with('success', '¡Pago procesado exitosamente!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en checkout: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Error al procesar el pago: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    // Página de éxito
    public function success($orderNumber)
    {
        Log::info('Página de éxito para orden: ' . $orderNumber);
        
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        // Limpiar carrito por si acaso
        session()->forget('cart');
            
        return view('checkout-success', compact('order'));
    }
    
    // Método privado para determinar marca de tarjeta
    private function getCardBrand($cardNumber)
    {
        $cardNumber = preg_replace('/\D/', '', $cardNumber);
        
        // Visa
        if (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $cardNumber)) {
            return 'Visa';
        }
        
        // Mastercard
        if (preg_match('/^5[1-5][0-9]{14}$/', $cardNumber)) {
            return 'Mastercard';
        }
        
        // American Express
        if (preg_match('/^3[47][0-9]{13}$/', $cardNumber)) {
            return 'American Express';
        }
        
        return 'Desconocida';
    }
}