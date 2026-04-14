<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function generateTicket($orderNumber)
    {
        // Buscar por order_number en lugar de id
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
    
    public function previewTicket($orderNumber)
    {
        // Buscar por order_number en lugar de id
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
}