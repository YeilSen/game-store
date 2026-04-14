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

    {{-- ===================================================== --}}
    {{-- 🔥 CARRUSEL DE JUEGOS CON DESCUENTOS (CON AUTOPLAY) --}}
    {{-- ===================================================== --}}
    @php
        $discountGames = $games->where('has_discount', true)->where('status', 'available')->take(10);
    @endphp
    
    @if($discountGames->count() > 0)
    <div class="discount-section mb-5 fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="discount-badge-header">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <span>OFERTAS ESPECIALES</span>
                </div>
                <div class="discount-timer">
                    <i class="bi bi-clock-history"></i>
                    <span>Ofertas por tiempo limitado</span>
                </div>
            </div>
            <a href="#ofertas" class="view-all-link" onclick="document.querySelector('.categories-bar').scrollIntoView({behavior: 'smooth'});">
                Ver todas <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="position-relative">
            <div class="discount-carousel-container">
                <button class="carousel-nav prev-btn" id="prevDiscount">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <div class="discount-carousel" id="discountCarousel">
                    <div class="carousel-track" id="discountTrack">
                        @foreach($discountGames as $game)
                            <div class="discount-card" data-category="{{ $game->category }}">
                                <div class="discount-badge">-{{ $game->discount_percent }}% OFF</div>
                                <img src="{{ asset('storage/' . $game->image_path) }}" 
                                     alt="{{ $game->name }}" 
                                     class="discount-img">
                                <div class="discount-info">
                                    <h5>{{ $game->name }}</h5>
                                    <div class="price-container">
                                        <span class="original-price">${{ number_format($game->price, 2) }}</span>
                                        <span class="discount-price">${{ number_format($game->final_price, 2) }}</span>
                                    </div>
                                    <button class="add-to-cart-discount" 
                                            data-id="{{ $game->id }}" 
                                            data-name="{{ $game->name }}" 
                                            data-price="{{ $game->final_price }}">
                                        <i class="bi bi-cart-plus"></i> Añadir al carrito
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button class="carousel-nav next-btn" id="nextDiscount">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ===================================================== --}}
    {{-- 🔥 BARRA DE CATEGORÍAS (FILTRO RÁPIDO) --}}
    {{-- ===================================================== --}}
    <div class="categories-bar mb-5 fade-in">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-tags-fill" style="color: #22d3ee; font-size: 1.5rem;"></i>
                <span class="gaming-font fw-bold" style="color: #22d3ee;">Categorías:</span>
            </div>
            <div class="d-flex flex-wrap gap-2" id="categoryFilter">
                <button class="category-btn active" data-category="all">
                    <i class="bi bi-grid-3x3-gap-fill me-1"></i> Todos
                </button>
                @php
                    // 🔥 CORREGIDO: Mostrar TODAS las categorías de TODOS los juegos
                    $uniqueCategories = $games->pluck('category')->unique()->filter()->values();
                @endphp
                @foreach($uniqueCategories as $cat)
                    <button class="category-btn" data-category="{{ $cat }}">
                        <i class="bi bi-tag me-1"></i> {{ ucfirst($cat) }}
                    </button>
                @endforeach
            </div>
            <div class="games-count" style="color: #94a3b8; font-size: 0.85rem;">
                <i class="bi bi-controller me-1"></i> 
                <span id="gameCount">{{ $games->count() }}</span> juegos
            </div>
        </div>
    </div>

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
    <div class="row g-4" id="gamesGrid">
        {{-- 🔥 CORREGIDO: Mostrar TODOS los juegos sin filtrar por status --}}
        @forelse ($games as $game)
            <div class="col-md-4 mb-4 game-item" data-category="{{ $game->category }}" data-name="{{ $game->name }}" data-price="{{ $game->has_discount ? $game->final_price : $game->price }}">
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
                        
                        {{-- Mostrar estado en la imagen --}}
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
                        {{-- Categoría --}}
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
                        
                        {{-- Precio con descuento --}}
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
                        
                        {{-- Botones de Admin (dentro de cada juego) --}}
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
    /* ===================================================== */
    /* 🔥 ESTILOS PARA EL CARRUSEL DE DESCUENTOS */
    /* ===================================================== */
    .discount-section {
        background: linear-gradient(135deg, rgba(34, 211, 238, 0.05), rgba(168, 85, 247, 0.05));
        border-radius: 24px;
        padding: 20px;
        border: 1px solid rgba(34, 211, 238, 0.2);
    }
    
    .discount-badge-header {
        background: linear-gradient(45deg, #22d3ee, #a855f7);
        padding: 8px 20px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: bold;
        color: #0f172a;
        font-family: 'Orbitron', sans-serif;
        animation: pulse 2s infinite;
    }
    
    .discount-timer {
        background: rgba(0, 0, 0, 0.5);
        padding: 8px 16px;
        border-radius: 30px;
        color: #fbbf24;
        font-size: 0.85rem;
    }
    
    .view-all-link {
        color: #22d3ee;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .view-all-link:hover {
        color: #a5f3fc;
        transform: translateX(5px);
    }
    
    .discount-carousel-container {
        position: relative;
        margin: 20px 0;
    }
    
    .discount-carousel {
        overflow: hidden;
        border-radius: 16px;
    }
    
    .carousel-track {
        display: flex;
        transition: transform 0.5s ease-in-out;
        gap: 20px;
    }
    
    .discount-card {
        flex: 0 0 280px;
        background: rgba(10, 10, 20, 0.8);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(34, 211, 238, 0.3);
        transition: all 0.3s ease;
        position: relative;
    }
    
    .discount-card:hover {
        transform: translateY(-5px);
        border-color: #22d3ee;
        box-shadow: 0 10px 30px rgba(34, 211, 238, 0.2);
    }
    
    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(45deg, #ef4444, #dc2626);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: bold;
        color: white;
        z-index: 1;
    }
    
    .discount-img {
        width: 100%;
        height: 280px;
        object-fit: cover;
    }
    
    .discount-info {
        padding: 15px;
    }
    
    .discount-info h5 {
        color: white;
        font-size: 1rem;
        margin-bottom: 10px;
    }
    
    .price-container {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 12px;
    }
    
    .original-price {
        color: #94a3b8;
        text-decoration: line-through;
        font-size: 0.85rem;
    }
    
    .discount-price {
        color: #22d3ee;
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    .add-to-cart-discount {
        width: 100%;
        background: rgba(34, 211, 238, 0.1);
        border: 1px solid rgba(34, 211, 238, 0.3);
        border-radius: 8px;
        padding: 8px;
        color: #22d3ee;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .add-to-cart-discount:hover {
        background: rgba(34, 211, 238, 0.2);
        transform: translateY(-2px);
    }
    
    .carousel-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(15, 23, 42, 0.9);
        border: 1px solid rgba(34, 211, 238, 0.5);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #22d3ee;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .carousel-nav:hover {
        background: rgba(34, 211, 238, 0.2);
        transform: translateY(-50%) scale(1.1);
    }
    
    .prev-btn {
        left: -20px;
    }
    
    .next-btn {
        right: -20px;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    /* ===================================================== */
    /* 🔥 ESTILOS PARA LA BARRA DE CATEGORÍAS */
    /* ===================================================== */
    .categories-bar {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(34, 211, 238, 0.2);
        border-radius: 50px;
        padding: 12px 24px;
        margin-bottom: 30px;
    }
    
    .category-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(34, 211, 238, 0.2);
        border-radius: 30px;
        padding: 8px 18px;
        color: #cbd5e1;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .category-btn:hover {
        background: rgba(34, 211, 238, 0.2);
        border-color: #22d3ee;
        color: #22d3ee;
        transform: translateY(-2px);
    }
    
    .category-btn.active {
        background: linear-gradient(45deg, #22d3ee, #6366f1);
        border-color: transparent;
        color: #0f172a;
        box-shadow: 0 0 15px rgba(34, 211, 238, 0.5);
    }
    
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
    
    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    
    .game-item {
        transition: all 0.3s ease;
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    .game-item.hidden-category {
        display: none !important;
    }
    
    /* Mensaje de filtro */
    .filter-message {
        animation: fadeIn 0.3s ease-out;
    }
    
    @media (max-width: 768px) {
        .categories-bar {
            border-radius: 20px;
        }
        
        .category-btn {
            padding: 6px 12px;
            font-size: 0.75rem;
        }
        
        .carousel-nav {
            width: 30px;
            height: 30px;
        }
        
        .prev-btn {
            left: -10px;
        }
        
        .next-btn {
            right: -10px;
        }
        
        .discount-card {
            flex: 0 0 240px;
        }
        
        .discount-img {
            height: 240px;
        }
    }
</style>

<script>
    // =====================================================
    // 🔥 CARRUSEL DE DESCUENTOS CON AUTOPLAY
    // =====================================================
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('discountTrack');
        const prevBtn = document.getElementById('prevDiscount');
        const nextBtn = document.getElementById('nextDiscount');
        
        if (track && prevBtn && nextBtn && track.children.length > 0) {
            let currentIndex = 0;
            let autoPlayInterval;
            const cards = track.children;
            const cardWidth = cards[0]?.offsetWidth + 20 || 300;
            const carouselContainer = document.querySelector('.discount-carousel');
            const visibleCards = Math.floor(carouselContainer?.offsetWidth / cardWidth) || 3;
            const maxIndex = Math.max(0, cards.length - visibleCards);
            
            function updateCarousel() {
                track.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
            }
            
            function nextSlide() {
                if (currentIndex < maxIndex) {
                    currentIndex++;
                    updateCarousel();
                } else {
                    currentIndex = 0;
                    updateCarousel();
                }
            }
            
            function prevSlide() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateCarousel();
                } else {
                    currentIndex = maxIndex;
                    updateCarousel();
                }
            }
            
            function startAutoPlay() {
                if (autoPlayInterval) clearInterval(autoPlayInterval);
                autoPlayInterval = setInterval(nextSlide, 4000);
            }
            
            function stopAutoPlay() {
                if (autoPlayInterval) {
                    clearInterval(autoPlayInterval);
                    autoPlayInterval = null;
                }
            }
            
            prevBtn.addEventListener('click', function() {
                stopAutoPlay();
                prevSlide();
                startAutoPlay();
            });
            
            nextBtn.addEventListener('click', function() {
                stopAutoPlay();
                nextSlide();
                startAutoPlay();
            });
            
            const carouselContainerDiv = document.querySelector('.discount-carousel-container');
            if (carouselContainerDiv) {
                carouselContainerDiv.addEventListener('mouseenter', stopAutoPlay);
                carouselContainerDiv.addEventListener('mouseleave', startAutoPlay);
            }
            
            startAutoPlay();
            
            window.addEventListener('resize', function() {
                const newCardWidth = cards[0]?.offsetWidth + 20 || 300;
                const newVisibleCards = Math.floor(carouselContainer?.offsetWidth / newCardWidth) || 3;
                const newMaxIndex = Math.max(0, cards.length - newVisibleCards);
                if (currentIndex > newMaxIndex) {
                    currentIndex = newMaxIndex;
                    updateCarousel();
                }
            });
        }
    });
    
    // =====================================================
    // 🔥 FILTRO POR CATEGORÍAS
    // =====================================================
    document.addEventListener('DOMContentLoaded', function() {
        const categoryBtns = document.querySelectorAll('.category-btn');
        const gameItems = document.querySelectorAll('.game-item');
        const gameCountSpan = document.getElementById('gameCount');
        const gamesGrid = document.getElementById('gamesGrid');
        
        function updateGameCount() {
            const visibleGames = document.querySelectorAll('.game-item:not(.hidden-category)');
            if (gameCountSpan) {
                gameCountSpan.textContent = visibleGames.length;
            }
        }
        
        function showFilterMessage(category) {
            const oldMsg = document.querySelector('.filter-message');
            if (oldMsg) oldMsg.remove();
            
            const visibleGames = document.querySelectorAll('.game-item:not(.hidden-category)');
            
            if (visibleGames.length === 0 && gamesGrid) {
                const msg = document.createElement('div');
                msg.className = 'filter-message text-center py-5 w-100';
                msg.style.gridColumn = '1 / -1';
                msg.innerHTML = `
                    <div class="mb-4" style="font-size: 3rem; color: rgba(99, 102, 241, 0.3);">
                        <i class="bi bi-search"></i>
                    </div>
                    <h4 style="color: #cbd5e1;">No hay juegos en la categoría "${category}"</h4>
                    <p style="color: #94a3b8;">Prueba con otra categoría</p>
                `;
                gamesGrid.appendChild(msg);
            }
        }
        
        categoryBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                categoryBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const category = this.getAttribute('data-category');
                const categoryName = this.textContent.trim().replace(/[^\w\s]/g, '');
                
                gameItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');
                    
                    if (category === 'all' || itemCategory === category) {
                        item.classList.remove('hidden-category');
                        item.style.animation = 'none';
                        setTimeout(() => {
                            item.style.animation = 'fadeIn 0.5s ease-out forwards';
                        }, 10);
                    } else {
                        item.classList.add('hidden-category');
                    }
                });
                
                updateGameCount();
                
                if (category !== 'all') {
                    showFilterMessage(categoryName);
                } else {
                    const oldMsg = document.querySelector('.filter-message');
                    if (oldMsg) oldMsg.remove();
                }
            });
        });
        
        updateGameCount();
    });
    
    // =====================================================
    // 🔥 AÑADIR AL CARRITO (DESDE CARRUSEL)
    // =====================================================
    document.addEventListener('DOMContentLoaded', function() {
        const discountButtons = document.querySelectorAll('.add-to-cart-discount');
        
        discountButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const gameId = this.getAttribute('data-id');
                if (gameId) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ url("/cart/add") }}/' + gameId;
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
@endsection