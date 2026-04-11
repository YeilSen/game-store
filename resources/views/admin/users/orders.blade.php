@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="text-light mb-4">
        📦 Historial de {{ $user->name }}
    </h2>

    @if($orders->isEmpty())
        <div class="alert alert-warning">
            Este usuario no tiene compras.
        </div>
    @else

        @foreach($orders as $order)
            <div class="card mb-3" style="background:#0f172a; color:white;">
                <div class="card-body">

                    <h5>Orden #{{ $order->order_number ?? $order->id }}</h5>

                    <p>Total: ${{ $order->total_amount }}</p>
                    <p>Estado: {{ $order->status }}</p>
                    <p>Fecha: {{ $order->created_at->format('d/m/Y H:i') }}</p>

                    <hr>

                    <h6>🎮 Juegos:</h6>
                    <ul>
                        @foreach($order->items as $item)
                            <li>
                                {{ $item->game->name ?? 'Juego eliminado' }}
                                x{{ $item->quantity }}
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        @endforeach

    @endif

</div>
@endsection