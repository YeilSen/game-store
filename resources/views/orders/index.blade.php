@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- ENCABEZADO --}}
    <div class="text-center mb-5">
        <h1 class="gaming-font mb-3 neon-title">
            🎮 MIS COMPRAS 🎮
        </h1>

        <p class="text-light subtitle">
            Historial de tus pedidos realizados
        </p>
    </div>

    {{-- STATS --}}
    @if($orders->count() > 0)
    <div class="row mb-4 text-center">
        <div class="col-md-4">
            <div class="stat-card">
                <h5>Total Compras</h5>
                <h2>{{ $orders->count() }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <h5>Total Gastado</h5>
                <h2>${{ number_format($orders->sum('total'), 2) }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <h5>Última Compra</h5>
                <h2>{{ optional($orders->first())->created_at?->format('d/m/Y') ?? 'N/A' }}</h2>
            </div>
        </div>
    </div>
    @endif

    {{-- LISTA --}}
    @if($orders->count() > 0)

        @foreach($orders as $order)
        <div class="card order-card mb-4">

            {{-- HEADER --}}
            <div class="card-header order-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="order-id">
                        🧾 Orden #{{ $order->order_number ?? $order->id }}
                    </span>

                    <span class="badge status-badge">
                        {{ strtoupper($order->status ?? 'COMPLETADO') }}
                    </span>
                </div>
            </div>

            {{-- BODY --}}
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6 text-light">
                        <strong>Fecha:</strong>
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </div>

                    <div class="col-md-6 text-end total-price">
                        ${{ number_format($order->total ?? $order->total_amount, 2) }}
                    </div>
                </div>

                <hr class="divider">

                {{-- ITEMS --}}
                @foreach($order->items as $item)
                <div class="item-row d-flex justify-content-between align-items-center">

                    {{-- INFO CON IMAGEN --}}
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('storage/' . ($item->image ?? 'default.jpg')) }}"
                             style="width:60px; height:60px; border-radius:10px; object-fit:cover;">

                        <div>
                            <strong class="text-white">
                                🎮 {{ $item->game_name ?? $item->name ?? 'Juego' }}
                            </strong><br>

                            <small style="
                                color:#22d3ee;
                                font-weight:700;
                                text-shadow:0 0 8px rgba(34,211,238,0.6);
                            ">
                                Cantidad: {{ $item->quantity }}
                            </small>
                        </div>
                    </div>

                    {{-- PRECIO --}}
                    <div class="item-price">
                        ${{ number_format($item->price, 2) }}
                    </div>

                </div>
                @endforeach

                {{-- BOTONES --}}
                <div class="mt-3 d-flex justify-content-end gap-2">

                    {{-- 🎫 NUEVO BOTÓN: VER TICKET GAMER --}}
                    <a href="{{ route('orders.ticket', $order->id) }}"
                       target="_blank"
                       class="btn btn-sm"
                       style="
                            background: linear-gradient(135deg, rgba(0,255,255,0.2), rgba(0,255,255,0.05));
                            border: 1px solid #0ff;
                            color: #0ff;
                            font-weight: 600;
                            transition: all 0.3s;
                       "
                       onmouseover="this.style.boxShadow='0 0 15px rgba(0,255,255,0.5)'; this.style.transform='scale(1.05)'"
                       onmouseout="this.style.boxShadow='none'; this.style.transform='scale(1)'">
                        <i class="bi bi-ticket-perforated"></i> 🎫 TICKET GAMER
                    </a>

                    {{-- PDF REAL --}}
                    <a href="{{ route('invoice.generate', $order->id) }}"
                       class="btn btn-sm"
                       style="
                            background: rgba(34,211,238,0.2);
                            border:1px solid rgba(34,211,238,0.4);
                            color:#67e8f9;
                       ">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </a>

                </div>

            </div>
        </div>
        @endforeach

        {{-- PAGINACIÓN (si tienes) --}}
        @if(method_exists($orders, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @endif

    @else

        {{-- VACÍO --}}
        <div class="text-center py-5">
            <div class="empty-icon">
                <i class="bi bi-bag-x"></i>
            </div>

            <h4 class="gaming-font text-light mt-3">
                No tienes compras aún
            </h4>

            <a href="{{ route('catalog') }}" class="btn explore-btn mt-3">
                Explorar tienda
            </a>
        </div>

    @endif

</div>

{{-- ESTILOS PRO --}}
<style>

.neon-title {
    background: linear-gradient(45deg, #22d3ee, #a855f7, #6366f1);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    font-weight: 900;
    text-shadow: 0 0 20px rgba(34,211,238,0.4);
}

.subtitle {
    opacity: 0.8;
}

/* STATS */
.stat-card {
    background: rgba(15,23,42,0.8);
    border: 1px solid rgba(99,102,241,0.3);
    border-radius: 15px;
    padding: 15px;
    color: white;
    transition: 0.3s;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(99,102,241,0.3);
}

/* CARD */
.order-card {
    background: rgba(10,15,28,0.95);
    border: 1px solid rgba(99,102,241,0.3);
    border-radius: 20px;
    backdrop-filter: blur(10px);
    transition: 0.3s;
}
.order-card:hover {
    transform: scale(1.01);
}

/* HEADER */
.order-header {
    background: linear-gradient(45deg, rgba(34,211,238,0.15), rgba(139,92,246,0.15));
}
.order-id {
    color:#22d3ee;
    font-weight:700;
}

/* BADGE */
.status-badge {
    background: rgba(34,197,94,0.2);
    color:#86efac;
    border:1px solid rgba(34,197,94,0.3);
    padding:6px 12px;
    border-radius:10px;
}

/* ITEMS */
.item-row {
    background: rgba(30,41,59,0.6);
    border:1px solid rgba(99,102,241,0.2);
    padding:10px;
    border-radius:10px;
    margin-bottom:10px;
    transition:0.3s;
}
.item-row:hover {
    background: rgba(99,102,241,0.2);
}

/* PRECIO */
.item-price {
    color:#22d3ee;
    font-weight:700;
}

/* TOTAL */
.total-price {
    color:#22d3ee;
    font-size:1.3rem;
    font-weight:900;
}

/* BOTONES */
.explore-btn {
    background: linear-gradient(45deg,#22d3ee,#6366f1);
    border:none;
    color:#0f172a;
    font-weight:700;
    padding:10px 25px;
    border-radius:12px;
}

/* VACÍO */
.empty-icon {
    font-size:4rem;
    color:rgba(99,102,241,0.3);
}

/* DIVIDER */
.divider {
    border-color: rgba(99,102,241,0.3);
}

</style>

@endsection