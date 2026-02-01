@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tu Carrito de Compras</h1>

    @php $total = 0 @endphp

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('cart'))
        <table class="table table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Juego</th>
                    <th class="text-center">Precio Unitario</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('cart') as $id => $details)
                    @php $subtotal = $details['price'] * $details['quantity']; $total += $subtotal @endphp
                    <tr>
                        <td data-th="Juego">
                            <div class="row align-items-center">
                                <div class="col-sm-3 hidden-xs">
                                    <img src="{{ asset('storage/' . $details['image']) }}" width="50" height="50" class="img-fluid rounded me-3"/>
                                </div>
                                <div class="col-sm-9">
                                    <h4 class="nomargin">{{ $details['name'] }}</h4>
                                </div>
                            </div>
                        </td>
                        <td data-th="Precio" class="text-center">${{ number_format($details['price'], 2) }}</td>
                        <td data-th="Cantidad" class="text-center">{{ $details['quantity'] }}</td>
                        <td data-th="Subtotal" class="text-end">${{ number_format($subtotal, 2) }}</td>
                        {{-- NOTA: Si quieres el botón "Quitar", necesitarías una ruta DELETE/POST extra --}}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td class="text-end"><strong>${{ number_format($total, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('catalog') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Seguir Comprando
            </a>
            
            {{-- Formulario para CONFIRMACIÓN DE PAGO (vacía el carrito) --}}
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button class="btn btn-primary btn-lg">
                    Confirmar Pago y Vaciar Carrito
                </button>
            </form>
        </div>
    @else
        <div class="alert alert-info text-center">
            Tu carrito está vacío. ¡Añade algunos juegos!
        </div>
        <a href="{{ route('catalog') }}" class="btn btn-primary">Volver al Catálogo</a>
    @endif
</div>
@endsection