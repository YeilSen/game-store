<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;

class InvoiceController extends Controller
{
    public function generate($id)
    {
        $order = Order::with('items')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.invoice', compact('order'));

        return $pdf->download('factura_orden_' . $order->id . '.pdf');
    }
}