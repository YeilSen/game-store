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
use Barryvdh\DomPDF\Facade\Pdf; // 👈 AGREGAR ESTA LÍNEA AL INICIO

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
        // 🔐 VALIDACIÓN DE SESIÓN (ESTA ES LA CLAVE)
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para pagar');
        }

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
            $total = 0;
            $items = [];

            foreach ($cart as $gameId => $item) {
                $game = Game::find($gameId);

                if (!$game) {
                    throw new \Exception("El juego con ID {$gameId} no existe.");
                }

                if ($game->trashed() || $game->status != 'available') {
                    throw new \Exception("El juego {$game->name} no está disponible.");
                }

                $finalPrice = $item['price'];
                $subtotal = $finalPrice * $item['quantity'];
                $total += $subtotal;

                $items[] = [
                    'game_id' => $gameId,
                    'quantity' => $item['quantity'],
                    'unit_price' => $finalPrice,
                    'subtotal' => $subtotal
                ];
            }

            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'completed',
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid',
                'billing_name' => $request->billing_name,
                'billing_email' => $request->billing_email,
                'billing_phone' => $request->billing_phone,
                'billing_address' => $request->billing_address,
                'notes' => $request->notes,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'game_id' => $item['game_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal']
                ]);
            }

            session()->forget('cart');

            DB::commit();

            return redirect()->route('checkout.success', ['order' => $order->order_number])
                ->with('success', '¡Pago exitoso!');
                
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error al procesar el pago: ' . $e->getMessage());
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
    
    // 👇 👇 👇 NUEVOS MÉTODOS PARA TICKET PDF (AGREGAR AL FINAL) 👇 👇 👇
    
    // Generar ticket PDF de la orden
    public function downloadTicket($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $order->load('items.game');
        
        $subtotal = $order->items->sum('subtotal');
        $tax = $subtotal * 0.16;
        
        $data = [
            'order' => $order,
            'user' => $order->user,
            'date' => now()->format('d/m/Y H:i:s'),
            'ticket_number' => $order->order_number,
            'items' => $order->items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $order->total_amount
        ];
        
        $pdf = Pdf::loadView('pdf.ticket', $data);
        $pdf->setPaper([0, 0, 226.77, 600], 'portrait');
        
        return $pdf->download('ticket-' . $order->order_number . '.pdf');
    }
    
    // Vista previa del ticket en navegador
    public function previewTicket($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $order->load('items.game');
        
        $subtotal = $order->items->sum('subtotal');
        $tax = $subtotal * 0.16;
        
        $data = [
            'order' => $order,
            'user' => $order->user,
            'date' => now()->format('d/m/Y H:i:s'),
            'ticket_number' => $order->order_number,
            'items' => $order->items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $order->total_amount
        ];
        
        return view('pdf.ticket', $data);
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