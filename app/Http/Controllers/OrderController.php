<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // HISTORIAL
    public function index()
    {
        $orders = Order::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // GUARDAR COMPRA (CON PRECIOS CORRECTOS Y DESCUENTOS)
    public function store(Request $request)
    {
        $cart = session('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->back()->with('error', 'Carrito vacío');
        }

        $total = 0;

        // Calcular total con precios CORRECTOS (con descuento)
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // CREAR ORDEN
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => $request->payment_method ?? 'CRYPTO • GAMER PAY',
        ]);

        // GUARDAR ITEMS CON PRECIO CORRECTO (INCLUYE DESCUENTO)
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'game_id' => $id,
                'game_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],  // PRECIO CON DESCUENTO
                'original_price' => $item['original_price'] ?? $item['price'],
                'discount' => $item['discount'] ?? 0,
                'image' => $item['image'] ?? null,
            ]);
        }

        // LIMPIAR CARRITO
        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Compra realizada correctamente');
    }

    // ESTADÍSTICAS
    public function stats()
    {
        $orders = auth()->user()->orders;

        $totalSpent = $orders->sum('total_amount');
        $totalOrders = $orders->count();

        return view('orders.stats', compact('totalSpent', 'totalOrders'));
    }

    // MIS COMPRAS
    public function myOrders()
    {
        $orders = Order::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('orders.my', compact('orders'));
    }

    // TICKET DE UNA ORDEN ESPECÍFICA
    public function showTicket($orderId)
    {
        // Buscar la orden con sus items
        $order = Order::with('items')->findOrFail($orderId);
        
        // Verificar que la orden pertenece al usuario autenticado
        if ($order->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este ticket');
        }
        
        // Preparar datos para el ticket
        $orderData = [
            'id' => $order->order_number,
            'fecha' => $order->created_at->format('Y-m-d H:i:s'),
            'estado' => $this->getEstadoTexto($order),
            'metodo' => $order->payment_method ?? 'CRYPTO • GAMER PAY',
            'items' => $order->items->map(function($item) {
                return [
                    'nombre' => $item->game_name ?? $item->name ?? 'Juego',
                    'cantidad' => $item->quantity,
                    'precio_unitario' => floatval($item->price),
                    'moneda' => 'MXN'
                ];
            }),
            'total' => floatval($order->total_amount),
            'descuento_aplicado' => $order->items->contains(function($item) {
                return ($item->discount ?? 0) > 0;
            }),
            'codigo_promo' => 'NINGUNO'
        ];
        
        // Renderizar la vista del ticket con los datos
        return view('orders.ticket', compact('orderData'));
    }
    
    // Método auxiliar para el texto del estado
    private function getEstadoTexto($order)
    {
        if ($order->status === 'completed' && $order->payment_status === 'paid') {
            return 'PAGADO / CONFIRMADO';
        }
        return strtoupper($order->status);
    }
}