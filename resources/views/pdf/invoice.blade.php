<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket Gamer</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #020617;
            color: #e2e8f0;
        }

        .ticket {
            border: 2px solid #22d3ee;
            border-radius: 20px;
            padding: 20px;
            background: #0f172a;
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #22d3ee;
        }

        .subtitle {
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 15px;
        }

        .info {
            margin-bottom: 15px;
        }

        .info p {
            margin: 4px 0;
        }

        .items {
            margin-top: 10px;
        }

        .item {
            border-bottom: 1px dashed #334155;
            padding: 8px 0;
        }

        .item-name {
            font-weight: bold;
            color: #f1f5f9;
        }

        .qty {
            color: #38bdf8; /* 🔵 azul brillante */
            font-size: 12px;
        }

        .price {
            float: right;
            color: #22d3ee;
        }

        .total {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px solid #22d3ee;
            font-size: 18px;
            text-align: right;
            color: #22d3ee;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #64748b;
        }
    </style>
</head>

<body>

<div class="ticket">

    <div class="title">🎮 RAYONIC STORE 🎮</div>
    <div class="subtitle">COMPROBANTE DE COMPRA</div>

    <div class="info">
        <p><strong>Orden:</strong> #{{ $order->id }}</p>
        <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Estado:</strong> PAGADO</p>
    </div>

    <div class="items">
        @foreach($order->items as $item)
            <div class="item">
                <span class="item-name">
                    🎮 {{ $item->game_name ?? 'Juego' }}
                </span>

                <span class="price">
                    ${{ number_format($item->subtotal ?? ($item->price * $item->quantity), 2) }}
                </span>

                <br>

                <span class="qty">
                    Cantidad: {{ $item->quantity }}
                </span>
            </div>
        @endforeach
    </div>

    {{-- TOTAL CORREGIDO --}}
    <div class="total">
        TOTAL: ${{ number_format($order->total_amount ?? $order->items->sum('subtotal'), 2) }}
    </div>

    <div class="footer">
        ⚡ Gracias por tu compra gamer ⚡ <br>
        Rayonic Store © 2026
    </div>

</div>

</body>
</html>