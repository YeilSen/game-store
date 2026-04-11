@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="text-white mb-4">🧾 MIS COMPRAS</h2>

    @forelse($orders as $order)

        <div class="card mb-4" style="background:#0f172a; border-radius:15px; border:1px solid #6366f1;">
            
            <div class="card-header text-white">
                <strong>Orden:</strong> {{ $order->order_number }} |
                <strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y') }} |
                <strong>Total:</strong> ${{ $order->total_amount }}
            </div>

            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr style="color:white;">
                            <th>Juego</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr style="color:white;">
                                <td>{{ $item->game->name ?? 'Juego eliminado' }}</td>
                                <td>${{ $item->price }}</td>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    @empty
        <p class="text-white">No tienes compras aún.</p>
    @endforelse

</div>
@endsection