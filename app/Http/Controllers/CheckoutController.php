<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Game;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Mostrar formulario de checkout
    public function showCheckout()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }
        
        // Calcular total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        
        return view('checkout', compact('cart', 'total', 'paymentMethods'));
    }
    
    // Procesar el pago
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:credit_card,bank_transfer',
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email',
            'billing_phone' => 'nullable|string|max:20',
            'billing_address' => 'nullable|string',
            
            // Para tarjeta
            'card_number' => 'required_if:payment_method,credit_card',
            'card_exp_month' => 'required_if:payment_method,credit_card|integer|between:1,12',
            'card_exp_year' => 'required_if:payment_method,credit_card|integer|min:' . date('Y'),
            'card_cvv' => 'required_if:payment_method,credit_card|digits_between:3,4',
            
            // Para transferencia
            'bank_name' => 'required_if:payment_method,bank_transfer',
            'account_number' => 'required_if:payment_method,bank_transfer',
            'transaction_reference' => 'required_if:payment_method,bank_transfer',
        ]);
        
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }
        
        DB::beginTransaction();
        
        try {
            // Calcular total
            $total = 0;
            $items = [];
            
            foreach ($cart as $gameId => $item) {
                $game = Game::find($gameId);
                if (!$game) {
                    throw new \Exception("El juego con ID {$gameId} no existe.");
                }
                
                $subtotal = $game->price * $item['quantity'];
                $total += $subtotal;
                
                $items[] = [
                    'game_id' => $gameId,
                    'quantity' => $item['quantity'],
                    'unit_price' => $game->price,
                    'subtotal' => $subtotal
                ];
            }
            
            // Crear la orden
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'billing_name' => $request->billing_name,
                'billing_email' => $request->billing_email,
                'billing_phone' => $request->billing_phone,
                'billing_address' => $request->billing_address,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'transaction_reference' => $request->transaction_reference,
                'card_last_four' => $request->payment_method == 'credit_card' ? substr($request->card_number, -4) : null,
                'card_brand' => $request->payment_method == 'credit_card' ? $this->getCardBrand($request->card_number) : null,
                'notes' => $request->notes,
            ]);
            
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
            
            // Aquí iría la lógica real de pago con Stripe, PayPal, etc.
            // Por ahora simulamos pago exitoso
            $order->update([
                'status' => 'completed',
                'payment_status' => 'paid'
            ]);
            
            // Limpiar carrito
            session()->forget('cart');
            
            DB::commit();
            
            return redirect()->route('checkout.success', ['order' => $order->order_number])
                ->with('success', '¡Pago procesado exitosamente!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al procesar el pago: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    // Página de éxito
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
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