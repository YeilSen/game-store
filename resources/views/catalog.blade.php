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
            Catálogo de Juegos
        </h1>
    </div>

    {{-- Mensajes de éxito del carrito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
             style="
                background: linear-gradient(135deg, rgba(34, 197, 94, 0.9), rgba(21, 128, 61, 0.9));
                backdrop-filter: blur(10px);
                border: 1px solid rgba(34, 197, 94, 0.3);
                border-left: 4px solid #22c55e;
                color: white;
                box-shadow: 0 5px 15px rgba(34, 197, 94, 0.2);
                border-radius: 10px;
             ">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2" style="font-size: 1.1rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Botones de administración --}}
    @auth
        @if(Auth::user()->is_admin)
            <div class="mb-4 text-center">
                <a href="{{ route('admin.games.create') }}" class="btn me-2" style="
                    background: linear-gradient(45deg, #22d3ee, #6366f1);
                    border: none;
                    color: white;
                    font-weight: 600;
                    padding: 10px 20px;
                    border-radius: 8px;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 12px rgba(34, 211, 238, 0.3);
                ">
                    Añadir Nuevo Juego (Admin)
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn" style="
                    background: linear-gradient(45deg, #fbbf24, #f59e0b);
                    border: none;
                    color: #0f172a;
                    font-weight: 600;
                    padding: 10px 20px;
                    border-radius: 8px;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
                ">
                    Gestionar Usuarios (Admin)
                </a>
            </div>
        @endif
    @endauth

    {{-- Grid de juegos --}}
    <div class="row g-4">
        @forelse ($games as $game)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm" style="
                    background: rgba(15, 23, 42, 0.7);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(99, 102, 241, 0.2);
                    border-radius: 15px;
                    overflow: hidden;
                    transition: all 0.3s ease;
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
                ">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $game->image_path) }}" 
                             class="card-img-top" 
                             alt="{{ $game->name }}" 
                             style="height: 200px; object-fit: cover; width: 100%;">
                        <div class="position-absolute top-0 start-0 w-100 h-100"
                             style="
                                background: linear-gradient(to bottom, transparent 50%, rgba(15, 23, 42, 0.8));
                                opacity: 0.5;
                             "></div>
                        
                        {{-- 🔥 NUEVO: Mostrar estado en la imagen --}}
                        @if($game->status == 'out_of_stock')
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge" style="background: rgba(239, 68, 68, 0.9); color: white; padding: 5px 10px; border-radius: 6px;">
                                    AGOTADO
                                </span>
                            </div>
                        @elseif($game->status == 'discontinued')
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge" style="background: rgba(100, 116, 139, 0.9); color: white; padding: 5px 10px; border-radius: 6px;">
                                    DESCONTINUADO
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-body d-flex flex-column p-4">
                        {{-- 🔥 NUEVO: Categoría --}}
                        @if($game->category)
                            <div class="mb-2">
                                <span class="badge" style="
                                    background: rgba(34, 211, 238, 0.1);
                                    color: #22d3ee;
                                    border: 1px solid rgba(34, 211, 238, 0.3);
                                    padding: 4px 10px;
                                    border-radius: 20px;
                                    font-size: 0.8rem;
                                ">
                                    <i class="bi bi-tag me-1"></i> {{ $game->category }}
                                </span>
                            </div>
                        @endif
                        
                        <h5 class="card-title mb-3" style="
                            color: #e2e8f0;
                            font-weight: 700;
                            font-size: 1.2rem;
                            min-height: 3rem;
                        ">
                            {{ $game->name }}
                        </h5>
                        
                        <p class="card-text flex-grow-1 mb-3" style="
                            color: #94a3b8;
                            font-size: 0.9rem;
                            line-height: 1.5;
                        ">
                            {{ Str::limit($game->description, 100) }}
                        </p>
                        
                        {{-- 🔥 NUEVO: Precio con descuento --}}
                        <div class="mb-4">
                            @if($game->has_discount)
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-decoration-line-through text-muted me-2" style="color: #94a3b8 !important;">
                                            ${{ number_format($game->price, 2) }}
                                        </span>
                                        <span class="badge" style="
                                            background: linear-gradient(45deg, #ef4444, #dc2626);
                                            color: white;
                                            padding: 4px 8px;
                                            border-radius: 6px;
                                            font-size: 0.8rem;
                                        ">
                                            -{{ $game->discount_percent }}%
                                        </span>
                                    </div>
                                    <span style="
                                        background: linear-gradient(45deg, #22d3ee, #6366f1);
                                        -webkit-background-clip: text;
                                        background-clip: text;
                                        color: transparent;
                                        font-weight: 800;
                                        font-size: 1.2rem;
                                    ">
                                        ${{ number_format($game->final_price, 2) }}
                                    </span>
                                </div>
                            @else
                                <p class="card-text mb-0" style="
                                    background: linear-gradient(45deg, #22d3ee, #6366f1);
                                    -webkit-background-clip: text;
                                    background-clip: text;
                                    color: transparent;
                                    font-weight: 800;
                                    font-size: 1.2rem;
                                    text-align: right;
                                ">
                                    <strong>${{ number_format($game->price, 2) }}</strong>
                                </p>
                            @endif
                        </div>
                        
                        {{-- 🔥 NUEVO: Botones de Admin (dentro de cada juego) --}}
                        @auth
                            @if(Auth::user()->is_admin)
                                <div class="d-flex gap-2 mb-3">
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('admin.games.edit', $game->id) }}" 
                                       class="btn w-50" 
                                       style="
                                            background: linear-gradient(45deg, #22d3ee, #6366f1);
                                            border: none;
                                            color: #0f172a;
                                            font-weight: 600;
                                            padding: 8px;
                                            border-radius: 8px;
                                            transition: all 0.3s ease;
                                            font-size: 0.9rem;
                                        ">
                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                    </a>
                                    
                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('admin.games.delete', $game->id) }}" method="POST" class="w-50">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn w-100" 
                                                style="
                                                    background: rgba(239, 68, 68, 0.1);
                                                    border: 1px solid rgba(239, 68, 68, 0.3);
                                                    color: #fca5a5;
                                                    font-weight: 600;
                                                    padding: 8px;
                                                    border-radius: 8px;
                                                    transition: all 0.3s ease;
                                                    font-size: 0.9rem;
                                                "
                                                onclick="return confirm('¿Eliminar este juego?')">
                                            <i class="bi bi-trash me-1"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                        
                        {{-- Formulario para agregar al carrito --}}
                        @auth
                            @if($game->status == 'available')
                                <form action="{{ route('cart.add', $game->id) }}" method="POST" class="mt-auto">
                                    @csrf
                                    <button type="submit" class="btn w-100" style="
                                        background: linear-gradient(45deg, #10b981, #22c55e);
                                        border: none;
                                        color: white;
                                        font-weight: 600;
                                        padding: 12px;
                                        border-radius: 8px;
                                        transition: all 0.3s ease;
                                        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
                                    ">
                                        <i class="bi bi-cart-plus me-2"></i> Añadir al Carrito
                                    </button>
                                </form>
                            @else
                                <button class="btn w-100 mt-auto" disabled style="
                                    background: rgba(100, 116, 139, 0.3);
                                    border: none;
                                    color: #94a3b8;
                                    font-weight: 600;
                                    padding: 12px;
                                    border-radius: 8px;
                                    cursor: not-allowed;
                                ">
                                    <i class="bi bi-cart-x me-2"></i> No disponible
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 mt-auto" style="
                                background: transparent;
                                border: 2px solid #22d3ee;
                                color: #22d3ee;
                                font-weight: 600;
                                padding: 12px;
                                border-radius: 8px;
                                transition: all 0.3s ease;
                            ">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Inicia Sesión
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-4" style="font-size: 3rem; color: rgba(99, 102, 241, 0.3);">
                    <i class="bi bi-controller"></i>
                </div>
                <h4 class="mb-3" style="color: #cbd5e1;">
                    No hay juegos disponibles en este momento.
                </h4>
                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.games.create') }}" class="btn mt-3" style="
                            background: linear-gradient(45deg, #22d3ee, #6366f1);
                            border: none;
                            color: #0f172a;
                            font-weight: 600;
                            padding: 10px 20px;
                            border-radius: 8px;
                        ">
                            <i class="bi bi-plus-circle me-2"></i> Crear Primer Juego
                        </a>
                    @endif
                @endauth
            </div>
        @endforelse
    </div>
</div>

<style>
    /* Efectos hover para las cards */
    .card {
        transition: all 0.3s ease !important;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 
            0 15px 35px rgba(0, 0, 0, 0.3),
            0 0 15px rgba(34, 211, 238, 0.1) !important;
        border-color: rgba(34, 211, 238, 0.3) !important;
    }
    
    /* Efectos para botones */
    .btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease !important;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2) !important;
    }
    
    /* Efecto de brillo en botones */
    .btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -60%;
        width: 20%;
        height: 200%;
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(30deg);
        transition: all 0.5s ease;
        opacity: 0;
    }
    
    .btn:hover::after {
        left: 140%;
        opacity: 1;
    }
    
    /* Efecto para botón de login */
    .btn-outline-secondary:hover {
        background: rgba(34, 211, 238, 0.1) !important;
        color: #22d3ee !important;
        border-color: #22d3ee !important;
    }
    
    /* Animación de entrada para las cards */
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
    
    .col-md-4 {
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }
    
    .col-md-4:nth-child(1) { animation-delay: 0.1s; }
    .col-md-4:nth-child(2) { animation-delay: 0.2s; }
    .col-md-4:nth-child(3) { animation-delay: 0.3s; }
    .col-md-4:nth-child(4) { animation-delay: 0.4s; }
    .col-md-4:nth-child(5) { animation-delay: 0.5s; }
    .col-md-4:nth-child(6) { animation-delay: 0.6s; }
</style>

<script>
    // Efecto hover mejorado para las cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Efecto para botones
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection