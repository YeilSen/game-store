@extends('layouts.app')

@section('content')
<div class="container mt-4">
    {{-- Encabezado --}}
    <div class="text-center mb-5">
        <h1 class="gaming-font mb-3" style="
            background: linear-gradient(45deg, #22d3ee, #a855f7, #6366f1);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 900;
            letter-spacing: 1px;
            text-shadow: 0 0 20px rgba(34, 211, 238, 0.3);
            font-size: 2.2rem;
        ">
            🛒 TU CARRITO DE COMPRAS
        </h1>
        <p class="text-light" style="opacity: 0.8;">
            Revisa y finaliza tu compra
        </p>
    </div>

    @if(session('success'))
        <div class="alert mb-4" style="
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.9), rgba(21, 128, 61, 0.9));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-left: 4px solid #22c55e;
            color: white;
            box-shadow: 0 5px 15px rgba(34, 197, 94, 0.2);
            border-radius: 12px;
            padding: 15px;
        ">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2" style="font-size: 1.1rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('cart'))
        @php 
            $total = 0;
            $cart = session('cart');
            $hasUnavailable = false;
        @endphp

        <div class="row">
            {{-- Lista de juegos --}}
            <div class="col-lg-8 mb-4">
                <div class="card" style="
                    background: rgba(10, 15, 28, 0.95);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(99, 102, 241, 0.3);
                    border-radius: 20px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
                ">
                    <div class="card-header border-0" style="
                        background: linear-gradient(45deg, rgba(34, 211, 238, 0.15), rgba(139, 92, 246, 0.15));
                        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
                    ">
                        <h5 class="mb-0 gaming-font" style="color: #22d3ee;">
                            <i class="bi bi-controller me-2"></i> JUEGOS EN EL CARRITO
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0" style="background: transparent !important;">
                                <thead>
                                    <tr style="
                                        background: rgba(34, 211, 238, 0.05);
                                        border-bottom: 2px solid rgba(99, 102, 241, 0.3);
                                    ">
                                        <th style="color: #ffffff !important; font-weight: 700; padding: 20px;">JUEGO</th>
                                        <th style="color: #ffffff !important; font-weight: 700; text-align: center; padding: 20px;">PRECIO</th>
                                        <th style="color: #ffffff !important; font-weight: 700; text-align: center; padding: 20px;">CANTIDAD</th>
                                        <th style="color: #ffffff !important; font-weight: 700; text-align: right; padding: 20px;">SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody style="background: transparent !important;">
                                    @foreach($cart as $id => $details)
                                        @php 
                                            // Verificar si el juego existe en la base de datos
                                            $game = App\Models\Game::withTrashed()->find($id);
                                            $isGameDeleted = !$game || $game->trashed();
                                            $isGameOutOfStock = $game && $game->status == 'out_of_stock';
                                            $isGameDiscontinued = $game && $game->status == 'discontinued';
                                            $isUnavailable = $isGameDeleted || $isGameOutOfStock || $isGameDiscontinued;
                                            
                                            if($isUnavailable) {
                                                $hasUnavailable = true;
                                            }
                                            
                                            // Calcular precio con descuento si el juego existe
                                            $finalPrice = $details['price'];
                                            $originalPrice = $details['price'];
                                            $hasDiscount = false;
                                            $discountPercent = 0;
                                            
                                            if($game && !$isGameDeleted && $game->has_discount) {
                                                $finalPrice = $game->final_price;
                                                $originalPrice = $game->price;
                                                $hasDiscount = true;
                                                $discountPercent = $game->discount_percent;
                                            }
                                            
                                            $subtotal = $finalPrice * $details['quantity']; 
                                            if(!$isUnavailable) {
                                                $total += $subtotal;
                                            }
                                        @endphp
                                        <tr style="border-bottom: 1px solid rgba(99, 102, 241, 0.1); background: transparent !important;">
                                            <td style="padding: 20px; background: transparent !important;">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div style="
                                                            width: 80px; 
                                                            height: 80px; 
                                                            border-radius: 12px; 
                                                            overflow: hidden;
                                                            border: 2px solid rgba(99, 102, 241, 0.2);
                                                            {{ $isUnavailable ? 'opacity: 0.5;' : '' }}
                                                        ">
                                                            <img src="{{ asset('storage/' . $details['image']) }}" 
                                                                 class="w-100 h-100 object-fit-cover"
                                                                 alt="{{ $details['name'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 style="color: #ffffff !important; margin-bottom: 5px; font-weight: 700; font-size: 1rem;">
                                                            {{ $details['name'] }}
                                                            @if($isGameDeleted)
                                                                <span class="badge ms-2" style="background: rgba(239, 68, 68, 0.2); color: #fecaca; border: 1px solid rgba(239, 68, 68, 0.3);">
                                                                    <i class="bi bi-trash me-1"></i> ELIMINADO
                                                                </span>
                                                            @elseif($isGameOutOfStock)
                                                                <span class="badge ms-2" style="background: rgba(239, 68, 68, 0.2); color: #fecaca; border: 1px solid rgba(239, 68, 68, 0.3);">
                                                                    <i class="bi bi-exclamation-triangle me-1"></i> AGOTADO
                                                                </span>
                                                            @elseif($isGameDiscontinued)
                                                                <span class="badge ms-2" style="background: rgba(100, 116, 139, 0.2); color: #cbd5e1; border: 1px solid rgba(100, 116, 139, 0.3);">
                                                                    <i class="bi bi-stop-circle me-1"></i> DESCONTINUADO
                                                                </span>
                                                            @endif
                                                        </h6>
                                                        <div class="mt-2">
                                                            @if(!$isUnavailable)
                                                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm" style="
                                                                        background: rgba(239, 68, 68, 0.2);
                                                                        border: 1px solid rgba(239, 68, 68, 0.4);
                                                                        color: #fecaca;
                                                                        padding: 4px 12px;
                                                                        border-radius: 8px;
                                                                        font-size: 0.8rem;
                                                                        transition: all 0.3s ease;
                                                                    ">
                                                                        <i class="bi bi-trash me-1"></i> Eliminar
                                                                    </button>
                                                                </form>
                                                                
                                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline ms-2">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="input-group input-group-sm" style="width: 120px;">
                                                                        <input type="number" 
                                                                               name="quantity" 
                                                                               value="{{ $details['quantity'] }}" 
                                                                               min="1" 
                                                                               max="10"
                                                                               class="form-control" 
                                                                               style="
                                                                                    background: rgba(30, 41, 59, 0.8);
                                                                                    border-color: rgba(99, 102, 241, 0.3);
                                                                                    color: #ffffff !important;
                                                                                    text-align: center;
                                                                                    font-weight: 600;
                                                                                ">
                                                                        <button type="submit" class="btn" style="
                                                                            background: rgba(34, 211, 238, 0.2);
                                                                            border: 1px solid rgba(34, 211, 238, 0.4);
                                                                            color: #67e8f9;
                                                                            font-weight: 600;
                                                                        ">
                                                                            <i class="bi bi-arrow-clockwise"></i>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm" style="
                                                                        background: rgba(239, 68, 68, 0.3);
                                                                        border: 1px solid rgba(239, 68, 68, 0.5);
                                                                        color: #fecaca;
                                                                        padding: 4px 12px;
                                                                        border-radius: 8px;
                                                                        font-size: 0.8rem;
                                                                        transition: all 0.3s ease;
                                                                    ">
                                                                        <i class="bi bi-trash me-1"></i> Eliminar del carrito
                                                                    </button>
                                                                </form>
                                                                <span class="ms-2 text-muted small" style="color: #fca5a5 !important;">
                                                                    <i class="bi bi-info-circle"></i> No disponible para compra
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                              </td>
                                            <td style="text-align: center; padding: 20px; vertical-align: middle; background: transparent !important;">
                                                @if($hasDiscount && !$isUnavailable)
                                                    <div class="d-flex flex-column align-items-center">
                                                        <span style="
                                                            text-decoration: line-through;
                                                            color: #94a3b8;
                                                            font-size: 0.8rem;
                                                        ">
                                                            ${{ number_format($originalPrice, 2) }}
                                                        </span>
                                                        <span style="
                                                            background: linear-gradient(45deg, #22d3ee, #6366f1);
                                                            -webkit-background-clip: text;
                                                            background-clip: text;
                                                            color: transparent;
                                                            font-weight: 800;
                                                            font-size: 1rem;
                                                        ">
                                                            ${{ number_format($finalPrice, 2) }}
                                                        </span>
                                                        <span class="badge mt-1" style="
                                                            background: rgba(239, 68, 68, 0.2);
                                                            color: #fecaca;
                                                            font-size: 0.7rem;
                                                        ">
                                                            -{{ $discountPercent }}%
                                                        </span>
                                                    </div>
                                                @else
                                                    <span style="
                                                        background: linear-gradient(45deg, #22d3ee, #6366f1);
                                                        -webkit-background-clip: text;
                                                        background-clip: text;
                                                        color: transparent;
                                                        font-weight: 800;
                                                        font-size: 1rem;
                                                        {{ $isUnavailable ? 'opacity: 0.5;' : '' }}
                                                    ">
                                                        ${{ number_format($finalPrice, 2) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td style="text-align: center; padding: 20px; vertical-align: middle; background: transparent !important;">
                                                <span class="badge" style="
                                                    background: rgba(139, 92, 246, 0.2);
                                                    color: #d8b4fe;
                                                    font-size: 1rem;
                                                    font-weight: 700;
                                                    padding: 8px 16px;
                                                    border-radius: 10px;
                                                    border: 1px solid rgba(139, 92, 246, 0.3);
                                                    {{ $isUnavailable ? 'opacity: 0.5;' : '' }}
                                                ">
                                                    {{ $details['quantity'] }}
                                                </span>
                                            </td>
                                            <td style="text-align: right; padding: 20px; vertical-align: middle; background: transparent !important;">
                                                @if(!$isUnavailable)
                                                    <span style="
                                                        color: #22d3ee;
                                                        font-weight: 900;
                                                        font-size: 1.1rem;
                                                        text-shadow: 0 0 10px rgba(34, 211, 238, 0.3);
                                                    ">
                                                        ${{ number_format($subtotal, 2) }}
                                                    </span>
                                                @else
                                                    <span style="
                                                        color: #64748b;
                                                        font-weight: 900;
                                                        font-size: 1.1rem;
                                                    ">
                                                        $0.00
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Resumen y pago --}}
            <div class="col-lg-4">
                <div class="card mb-4" style="
                    background: rgba(10, 15, 28, 0.95);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(99, 102, 241, 0.3);
                    border-radius: 20px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
                ">
                    <div class="card-header border-0" style="
                        background: linear-gradient(45deg, rgba(34, 211, 238, 0.15), rgba(139, 92, 246, 0.15));
                        border-bottom: 1px solid rgba(99, 102, 241, 0.3);
                    ">
                        <h5 class="mb-0 gaming-font" style="color: #a855f7;">
                            <i class="bi bi-receipt me-2"></i> RESUMEN DE COMPRA
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if($hasUnavailable)
                            <div class="alert mb-3" style="
                                background: rgba(239, 68, 68, 0.1);
                                border: 1px solid rgba(239, 68, 68, 0.3);
                                border-radius: 12px;
                                color: #fecaca;
                                padding: 12px;
                                font-size: 0.85rem;
                            ">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>¡Atención!</strong> Algunos productos en tu carrito ya no están disponibles.
                                Por favor, elimínalos para continuar.
                            </div>
                        @endif

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: #e2e8f0; font-weight: 500;">Subtotal</span>
                                <span style="color: #ffffff; font-weight: 600;">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: #e2e8f0; font-weight: 500;">Envío</span>
                                <span style="color: #22c55e; font-weight: 600;">Gratis</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span style="color: #e2e8f0; font-weight: 500;">Impuestos</span>
                                <span style="color: #ffffff; font-weight: 600;">$0.00</span>
                            </div>
                            <hr style="border-color: rgba(99, 102, 241, 0.3);">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #ffffff; font-weight: 700; font-size: 1.1rem;">Total</span>
                                <span style="
                                    background: linear-gradient(45deg, #22d3ee, #6366f1, #a855f7);
                                    -webkit-background-clip: text;
                                    background-clip: text;
                                    color: transparent;
                                    font-weight: 900;
                                    font-size: 1.5rem;
                                ">
                                    ${{ number_format($total, 2) }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="alert mb-3" style="
                                background: rgba(34, 211, 238, 0.1);
                                border: 1px solid rgba(34, 211, 238, 0.3);
                                border-radius: 12px;
                                color: #67e8f9;
                                padding: 15px;
                                font-size: 0.9rem;
                            ">
                                <i class="bi bi-shield-check me-2"></i>
                                Pago 100% seguro con encriptación SSL
                            </div>
                            
                            @if($total > 0 && !$hasUnavailable)
                                <a href="{{ route('checkout') }}" class="btn checkout-btn w-100 gaming-font" style="
                                    background: linear-gradient(45deg, #22d3ee, #6366f1, #a855f7);
                                    background-size: 200% 200%;
                                    border: none;
                                    border-radius: 12px;
                                    padding: 16px;
                                    color: #0f172a;
                                    font-weight: 900;
                                    letter-spacing: 1px;
                                    transition: all 0.3s ease;
                                    position: relative;
                                    overflow: hidden;
                                    animation: gradientShift 3s ease infinite;
                                ">
                                    <i class="bi bi-credit-card me-2"></i> PROCEDER AL PAGO
                                </a>
                            @else
                                <button class="btn w-100 gaming-font" disabled style="
                                    background: rgba(100, 116, 139, 0.3);
                                    border: none;
                                    border-radius: 12px;
                                    padding: 16px;
                                    color: #94a3b8;
                                    font-weight: 900;
                                    letter-spacing: 1px;
                                    cursor: not-allowed;
                                ">
                                    <i class="bi bi-x-circle me-2"></i> NO DISPONIBLE
                                </button>
                            @endif
                            
                            <p class="text-center mt-3 mb-0" style="color: #94a3b8; font-size: 0.8rem;">
                                <i class="bi bi-lock me-1"></i>
                                Tus datos están protegidos
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Métodos de pago aceptados --}}
                <div class="card" style="
                    background: rgba(10, 15, 28, 0.95);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(99, 102, 241, 0.3);
                    border-radius: 20px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
                ">
                    <div class="card-body p-4">
                        <h6 class="mb-3 gaming-font" style="color: #22d3ee;">
                            <i class="bi bi-wallet2 me-2"></i> MÉTODOS DE PAGO
                        </h6>
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <div class="p-3 rounded" style="
                                    background: rgba(34, 211, 238, 0.05);
                                    border: 1px solid rgba(34, 211, 238, 0.2);
                                ">
                                    <i class="bi bi-credit-card-2-front" style="color: #22d3ee; font-size: 1.8rem;"></i>
                                    <p class="mb-0 mt-2" style="color: #e2e8f0; font-size: 0.85rem; font-weight: 500;">
                                        Tarjeta
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded" style="
                                    background: rgba(139, 92, 246, 0.05);
                                    border: 1px solid rgba(139, 92, 246, 0.2);
                                ">
                                    <i class="bi bi-bank" style="color: #a855f7; font-size: 1.8rem;"></i>
                                    <p class="mb-0 mt-2" style="color: #e2e8f0; font-size: 0.85rem; font-weight: 500;">
                                        Transferencia
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('catalog') }}" class="btn" style="
                background: rgba(15, 23, 42, 0.7);
                border: 1px solid rgba(99, 102, 241, 0.3);
                color: #67e8f9;
                font-weight: 600;
                padding: 12px 25px;
                border-radius: 12px;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            ">
                <i class="bi bi-arrow-left"></i> Seguir Comprando
            </a>
            
            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="
                    background: rgba(239, 68, 68, 0.2);
                    border: 1px solid rgba(239, 68, 68, 0.4);
                    color: #fecaca;
                    font-weight: 600;
                    padding: 12px 25px;
                    border-radius: 12px;
                    transition: all 0.3s ease;
                ">
                    <i class="bi bi-trash me-1"></i> Vaciar Carrito
                </button>
            </form>
        </div>

    @else
        {{-- Carrito vacío --}}
        <div class="text-center py-5">
            <div class="mb-4" style="font-size: 4rem; color: rgba(99, 102, 241, 0.3);">
                <i class="bi bi-cart-x"></i>
            </div>
            <h4 class="gaming-font mb-3" style="color: #e2e8f0;">
                🎮 TU CARRITO ESTÁ VACÍO 🎮
            </h4>
            <p class="text-light mb-4" style="opacity: 0.7; max-width: 500px; margin: 0 auto;">
                ¡Añade algunos juegos increíbles a tu carrito!
            </p>
            <a href="{{ route('catalog') }}" class="btn gaming-font" style="
                background: linear-gradient(45deg, #22d3ee, #6366f1);
                border: none;
                color: #0f172a;
                font-weight: 700;
                padding: 12px 30px;
                border-radius: 12px;
                letter-spacing: 1px;
            ">
                <i class="bi bi-arrow-right me-2"></i> Explorar Catálogo
            </a>
        </div>
    @endif
</div>

<style>
    /* Animaciones */
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    /* Forzar fondo oscuro en toda la tabla */
    .table-responsive,
    .table,
    .table thead,
    .table tbody,
    .table tr,
    .table td,
    .table th {
        background-color: transparent !important;
    }
    
    /* Forzar colores de texto */
    .table td,
    .table th {
        color: #ffffff !important;
    }
    
    /* Efectos hover para botones */
    .btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease !important;
    }
    
    .btn:hover {
        transform: translateY(-2px);
    }
    
    /* Botón de volver */
    a[href="{{ route('catalog') }}"]:hover {
        background: rgba(99, 102, 241, 0.2) !important;
        border-color: rgba(34, 211, 238, 0.5) !important;
        transform: translateX(-3px);
        color: #a5f3fc !important;
    }
    
    /* Botón vaciar carrito */
    form[action="{{ route('cart.clear') }}"] button:hover {
        background: rgba(239, 68, 68, 0.3) !important;
        border-color: rgba(239, 68, 68, 0.5) !important;
        color: #fecaca !important;
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.2);
    }
    
    /* Botones eliminar individuales */
    form[action*="remove"] button:hover {
        background: rgba(239, 68, 68, 0.3) !important;
        border-color: rgba(239, 68, 68, 0.5) !important;
        color: #fecaca !important;
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.2);
    }
    
    /* Botón principal de pago */
    .checkout-btn {
        position: relative;
        overflow: hidden;
    }
    
    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 10px 25px rgba(34, 211, 238, 0.4),
            0 0 20px rgba(139, 92, 246, 0.3) !important;
    }
    
    .checkout-btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -60%;
        width: 20%;
        height: 200%;
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(30deg);
        transition: all 0.5s ease;
        opacity: 0;
    }
    
    .checkout-btn:hover::after {
        left: 140%;
        opacity: 1;
    }
    
    /* Animación de entrada */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card {
        animation: fadeIn 0.6s ease-out;
    }
    
    /* Input quantity */
    .form-control[type="number"] {
        -moz-appearance: textfield;
    }
    
    .form-control[type="number"]::-webkit-outer-spin-button,
    .form-control[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .gaming-font {
            font-size: 1.8rem !important;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .table-responsive img {
            width: 60px !important;
            height: 60px !important;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 15px;
        }
        
        .d-flex.justify-content-between .btn {
            width: 100%;
        }
        
        .input-group {
            width: 100px !important;
        }
    }
    
    @media (max-width: 576px) {
        .table-responsive {
            font-size: 0.8rem;
        }
        
        .table-responsive h6 {
            font-size: 0.9rem !important;
        }
        
        .input-group {
            width: 90px !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto para botones de eliminar
        const deleteButtons = document.querySelectorAll('form button[type="submit"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (this.closest('form').action.includes('remove') || this.closest('form').action.includes('clear')) {
                    if (!confirm('¿Estás seguro de que quieres eliminar este item?')) {
                        e.preventDefault();
                    }
                }
            });
        });
        
        // Validar cantidad al actualizar
        const quantityInputs = document.querySelectorAll('input[name="quantity"]');
        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.value < 1) {
                    this.value = 1;
                }
                if (this.value > 10) {
                    this.value = 10;
                }
            });
        });
        
        // Efecto ripple para botón principal
        const checkoutBtn = document.querySelector('.checkout-btn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const ripple = document.createElement('span');
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.4);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                    width: 100px;
                    height: 100px;
                    top: ${y - 50}px;
                    left: ${x - 50}px;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        }
        
        // Añadir CSS para ripple
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection