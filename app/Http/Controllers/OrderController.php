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

    // GUARDAR COMPRA
    public function store(Request $request)
    {
        $cart = session('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->back()->with('error', 'Carrito vacío');
        }

        $total = 0;

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
        ]);

        // GUARDAR ITEMS
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'game_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // LIMPIAR CARRITO
        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Compra realizada correctamente');
    }
}