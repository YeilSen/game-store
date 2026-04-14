<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Compra - Rayonic</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            color: #000000;
            padding: 10px;
            width: 80mm;
            margin: 0 auto;
        }
        
        .ticket {
            border: 1px dashed #cccccc;
            padding: 10px;
        }
        
        .header {
            text-align: center;
            border-bottom: 1px dashed #cccccc;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .header h1 {
            font-size: 18px;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10px;
            color: #666666;
        }
        
        .info-section {
            margin-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
        }
        
        .divider {
            border-top: 1px dotted #cccccc;
            margin: 10px 0;
        }
        
        .items-table {
            width: 100%;
            margin-bottom: 15px;
        }
        
        .items-table th {
            text-align: left;
            border-bottom: 1px solid #000000;
            padding-bottom: 5px;
            font-size: 11px;
        }
        
        .items-table td {
            padding: 5px 0;
        }
        
        .item-name {
            font-size: 11px;
        }
        
        .item-qty {
            text-align: center;
            width: 30px;
        }
        
        .item-price {
            text-align: right;
            width: 60px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #000000;
            font-weight: bold;
            font-size: 14px;
        }
        
        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #cccccc;
            font-size: 10px;
            color: #666666;
        }
        
        .barcode {
            text-align: center;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
        }
        
        .thankyou {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }
        
        .text-success {
            color: #22c55e;
        }
        
        .text-danger {
            color: #dc2626;
        }
        
        .discount-badge {
            font-size: 9px;
            color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- ENCABEZADO -->
        <div class="header">
            <h1>RAYONIC</h1>
            <p>Tienda de Juegos Gamer</p>
            <p>Av. Tecnologico 123</p>
            <p>Tel: (55) 1234-5678</p>
        </div>
        
        <!-- INFORMACION DEL TICKET -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Ticket:</span>
                <span>{{ $ticket_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha:</span>
                <span>{{ $date }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Cliente:</span>
                <span>{{ $user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Correo:</span>
                <span>{{ $user->email }}</span>
            </div>
            @if($order->billing_phone)
            <div class="info-row">
                <span class="info-label">Telefono:</span>
                <span>{{ $order->billing_phone }}</span>
            </div>
            @endif
        </div>
        
        <div class="divider"></div>
        
        <!-- PRODUCTOS -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="item-qty">Cant</th>
                    <th class="item-price">Precio</th>
                    <th class="item-price">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                @php
                    $game = $item->game;
                    $hasDiscount = $game && $game->has_discount && $game->discount_percent > 0;
                    $originalPrice = $hasDiscount ? $game->price : null;
                    $discountPercent = $hasDiscount ? $game->discount_percent : 0;
                    $finalPrice = $item->unit_price;
                @endphp
                <tr>
                    <td class="item-name">
                        {{ $game ? $game->name : 'Producto no disponible' }}
                        @if($hasDiscount)
                        <br><span class="discount-badge">Descuento: -{{ $discountPercent }}%</span>
                        @endif
                    </td>
                    <td class="item-qty">{{ $item->quantity }}</td>
                    <td class="item-price">
                        @if($hasDiscount)
                            <span style="text-decoration: line-through; color: #999; font-size: 9px;">${{ number_format($originalPrice, 2) }}</span>
                            <br>
                            <span>${{ number_format($finalPrice, 2) }}</span>
                        @else
                            ${{ number_format($finalPrice, 2) }}
                        @endif
                    </td>
                    <td class="item-price">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="divider"></div>
        
        <!-- TOTAL -->
        <div class="total-row">
            <span>TOTAL</span>
            <span>${{ number_format($total, 2) }}</span>
        </div>
        
        <div class="divider"></div>
        
        <!-- METODO DE PAGO -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Metodo de pago:</span>
                <span>
                    @if($order->payment_method == 'credit_card')
                        Tarjeta de Credito/Debito
                    @elseif($order->payment_method == 'bank_transfer')
                        Transferencia Bancaria
                    @else
                        {{ ucfirst($order->payment_method) }}
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Estado:</span>
                <span class="text-success">
                    @if($order->status == 'completed')
                        Completado
                    @elseif($order->status == 'pending')
                        Pendiente
                    @else
                        {{ ucfirst($order->status) }}
                    @endif
                </span>
            </div>
        </div>
        
        <!-- CODIGO DE REFERENCIA -->
        <div class="barcode">
            {{ $ticket_number }}
        </div>
        
        <!-- PIE DE PAGINA -->
        <div class="footer">
            <p>Gracias por tu compra</p>
            <p>Este comprobante es tu ticket de compra</p>
            <p>Soporte: soporte@rayonic.com</p>
        </div>
        
        <div class="thankyou">
            Vuelve pronto
        </div>
    </div>
</body>
</html>