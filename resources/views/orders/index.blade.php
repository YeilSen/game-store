@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- ENCABEZADO --}}
    <div class="text-center mb-5">
        <h1 class="gaming-font mb-3" style="
            background: linear-gradient(45deg, #22d3ee, #a855f7, #6366f1);
            -webkit-background-clip: text;
            color: transparent;
            font-weight: 900;
            letter-spacing: 1px;
            text-shadow: 0 0 20px rgba(34, 211, 238, 0.3);
        ">
            🎮 MIS COMPRAS 🎮
        </h1>

        <p class="text-light" style="opacity:0.8;">
            Historial de tus pedidos realizados
        </p>
    </div>

    @if($orders->count() > 0)

        @foreach($orders as $order)
        <div class="card mb-4" style="
            background: rgba(10, 15, 28, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        ">

            {{-- HEADER --}}
            <div class="card-header border-0" style="
                background: linear-gradient(45deg, rgba(34, 211, 238, 0.15), rgba(139, 92, 246, 0.15));
                border-bottom: 1px solid rgba(99, 102, 241, 0.3);
            ">
                <div class="d-flex justify-content-between align-items-center">
                    <span style="color:#22d3ee; font-weight:700;">
                        🧾 Orden #{{ $order->id }}
                    </span>

                    <span class="badge" style="
                        background: rgba(34,197,94,0.2);
                        color:#86efac;
                        border:1px solid rgba(34,197,94,0.3);
                        padding:6px 12px;
                        border-radius:10px;
                    ">
                        COMPLETADO
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

                    <div class="col-md-6 text-end">
                        <strong style="color:#22d3ee; font-size:1.2rem;">
                            ${{ number_format($order->total, 2) }}
                        </strong>
                    </div>
                </div>

                <hr style="border-color: rgba(99, 102, 241, 0.3);">

                {{-- DETALLE DE PRODUCTOS --}}
                @foreach($order->items as $item)
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded" style="
                    background: rgba(30, 41, 59, 0.6);
                    border: 1px solid rgba(99, 102, 241, 0.2);
                ">
                    <div>
                        <strong class="text-white">
                            {{ $item->game_name }}
                        </strong>
                        <br>
                        <small class="text-muted">
                            Cantidad: {{ $item->quantity }}
                        </small>
                    </div>

                    <div style="color:#22d3ee; font-weight:700;">
                        ${{ number_format($item->price, 2) }}
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        @endforeach

    @else

        {{-- VACÍO --}}
        <div class="text-center py-5">
            <div style="font-size:4rem; color:rgba(99,102,241,0.3);">
                <i class="bi bi-bag-x"></i>
            </div>

            <h4 class="gaming-font text-light mt-3">
                No tienes compras aún
            </h4>

            <a href="{{ route('catalog') }}" class="btn mt-3" style="
                background: linear-gradient(45deg, #22d3ee, #6366f1);
                border: none;
                color: #0f172a;
                font-weight: 700;
                padding: 10px 25px;
                border-radius: 12px;
            ">
                Explorar tienda
            </a>
        </div>

    @endif

</div>
@endsection