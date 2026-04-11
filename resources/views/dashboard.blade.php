@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Mensaje de bienvenida personalizado --}}
            <div class="card mb-4" style="
                background: linear-gradient(135deg, #22d3ee, #6366f1, #a855f7);
                border: none;
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                overflow: hidden;
            ">
                <div class="card-body p-5">
                    <h1 class="gaming-font text-white mb-3" style="font-size: 2.2rem; text-shadow: 0 0 20px rgba(255,255,255,0.5);">
                        🎮 ¡Bienvenido a Rayonic, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-white mb-0" style="opacity: 0.9; font-size: 1.1rem;">
                        Nos alegra tenerte de vuelta en la mejor tienda de videojuegos.
                    </p>
                </div>
            </div>

            {{-- Tarjeta de información de la compañía --}}
            <div class="card mb-4" style="
                background: rgba(15, 23, 42, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(99, 102, 241, 0.2);
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                overflow: hidden;
            ">
                <div class="card-body p-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle p-3 me-3" style="background: rgba(34, 211, 238, 0.1);">
                            <i class="bi bi-info-circle-fill" style="color: #22d3ee; font-size: 1.5rem;"></i>
                        </div>
                        <h2 class="gaming-font mb-0" style="
                            background: linear-gradient(45deg, #22d3ee, #a855f7);
                            -webkit-background-clip: text;
                            background-clip: text;
                            color: transparent;
                            font-size: 2rem;
                        ">
                            SOBRE RAYONIC
                        </h2>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-8">
                            <p class="text-light mb-4" style="font-size: 1rem; line-height: 1.6;">
                                <span class="text-cyan-400 fw-bold">Rayonic</span> nació en 2024 con una misión clara: 
                                <span class="fw-bold" style="color: #a855f7;">llevar la mejor experiencia gaming a todos los rincones de Latinoamérica</span>. 
                                Somos más que una tienda, somos una comunidad de jugadores apasionados.
                            </p>
                            
                            <p class="text-light mb-4" style="font-size: 1rem; line-height: 1.6;">
                                En nuestra tienda encontrarás los títulos más recientes, clásicos inolvidables y joyas independientes, 
                                todo a precios competitivos y con ofertas exclusivas para nuestros miembros.
                            </p>
                        </div>
                        <div class="col-lg-4">
                            <div class="p-4 rounded-3" style="background: rgba(34, 211, 238, 0.05); border: 1px solid rgba(34, 211, 238, 0.2);">
                                <h5 class="gaming-font text-center mb-3" style="color: #22d3ee;">ESTADÍSTICAS</h5>
                                <div class="text-center mb-3">
                                    <div class="display-4 fw-bold" style="color: #22d3ee;">+500</div>
                                    <div class="text-light">Juegos disponibles</div>
                                </div>
                                <div class="text-center mb-3">
                                    <div class="display-4 fw-bold" style="color: #a855f7;">24/7</div>
                                    <div class="text-light">Soporte al cliente</div>
                                </div>
                                <div class="text-center">
                                    <div class="display-4 fw-bold" style="color: #6366f1;">100%</div>
                                    <div class="text-light">Compra segura</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tarjetas de información del usuario --}}
            <div class="row mb-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="card h-100" style="
                        background: rgba(15, 23, 42, 0.7);
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(34, 211, 238, 0.2);
                        border-radius: 20px;
                        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                    ">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle p-3 me-3" style="background: rgba(34, 211, 238, 0.1);">
                                    <i class="bi bi-person-circle" style="color: #22d3ee; font-size: 1.5rem;"></i>
                                </div>
                                <h3 class="gaming-font mb-0" style="color: #22d3ee;">TU ACTIVIDAD</h3>
                            </div>
                            
                            <div class="mb-3 p-3 rounded-3" style="background: rgba(255,255,255,0.05);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-light">Miembro desde:</span>
                                    <span class="fw-bold" style="color: #22d3ee;">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-3 p-3 rounded-3" style="background: rgba(255,255,255,0.05);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-light">Última sesión:</span>
                                    <span class="fw-bold" style="color: #a855f7;">{{ Auth::user()->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            
                            <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.05);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-light">Rol:</span>
                                    <span class="fw-bold" style="color: {{ Auth::user()->is_admin ? '#a855f7' : '#22d3ee' }};">
                                        {{ Auth::user()->is_admin ? 'ADMINISTRADOR' : 'JUGADOR' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100" style="
                        background: rgba(15, 23, 42, 0.7);
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(168, 85, 247, 0.2);
                        border-radius: 20px;
                        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                    ">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle p-3 me-3" style="background: rgba(168, 85, 247, 0.1);">
                                    <i class="bi bi-calendar-event" style="color: #a855f7; font-size: 1.5rem;"></i>
                                </div>
                                <h3 class="gaming-font mb-0" style="color: #a855f7;">PRÓXIMAMENTE</h3>
                            </div>
                            
                            <div class="mb-3 p-3 rounded-3" style="background: rgba(255,255,255,0.05);">
                                <p class="mb-0">
                                    <span style="color: #22d3ee; font-size: 1.2rem;">🎮</span>
                                    <span class="text-light ms-2">Lanzamientos de la semana: <span class="fw-bold" style="color: #22d3ee;">3 nuevos títulos</span></span>
                                </p>
                            </div>
                            
                            <div class="mb-3 p-3 rounded-3" style="background: rgba(255,255,255,0.05);">
                                <p class="mb-0">
                                    <span style="color: #ef4444; font-size: 1.2rem;">🔥</span>
                                    <span class="text-light ms-2">Ofertas flash: <span class="fw-bold" style="color: #ef4444;">30% de descuento en RPGs</span></span>
                                </p>
                            </div>
                            
                            <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.05);">
                                <p class="mb-0">
                                    <span style="color: #fbbf24; font-size: 1.2rem;">🏆</span>
                                    <span class="text-light ms-2">Torneo Rayonic: <span class="fw-bold" style="color: #fbbf24;">Inscripciones abiertas</span></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Acciones rápidas --}}
            <div class="card" style="
                background: rgba(15, 23, 42, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(99, 102, 241, 0.2);
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            ">
                <div class="card-body p-5">
                    <h2 class="gaming-font text-center mb-4" style="
                        background: linear-gradient(45deg, #22d3ee, #a855f7);
                        -webkit-background-clip: text;
                        background-clip: text;
                        color: transparent;
                        font-size: 2rem;
                    ">
                        ¿QUÉ DESEAS HACER HOY?
                    </h2>
                    
                    <div class="row g-4">
                        <div class="col-md-4">
                            <a href="{{ route('catalog') }}" class="text-decoration-none action-card">
                                <div class="p-4 text-center rounded-4 transition-all" style="
                                    background: rgba(34, 211, 238, 0.1);
                                    border: 1px solid rgba(34, 211, 238, 0.3);
                                    transition: all 0.3s ease;
                                    cursor: pointer;
                                ">
                                    <div style="font-size: 3rem; margin-bottom: 1rem;">🎮</div>
                                    <h4 class="gaming-font" style="color: #22d3ee;">Explorar Catálogo</h4>
                                    <p class="text-light small">Descubre los últimos lanzamientos</p>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-4">
                            <a href="{{ route('cart.index') }}" class="text-decoration-none action-card">
                                <div class="p-4 text-center rounded-4 transition-all" style="
                                    background: rgba(16, 185, 129, 0.1);
                                    border: 1px solid rgba(16, 185, 129, 0.3);
                                    transition: all 0.3s ease;
                                    cursor: pointer;
                                ">
                                    <div style="font-size: 3rem; margin-bottom: 1rem;">🛒</div>
                                    <h4 class="gaming-font" style="color: #10b981;">Ver Carrito</h4>
                                    <p class="text-light small">Revisa tus juegos seleccionados</p>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-4">
                            <a href="{{ route('profile.edit') }}" class="text-decoration-none action-card">
                                <div class="p-4 text-center rounded-4 transition-all" style="
                                    background: rgba(168, 85, 247, 0.1);
                                    border: 1px solid rgba(168, 85, 247, 0.3);
                                    transition: all 0.3s ease;
                                    cursor: pointer;
                                ">
                                    <div style="font-size: 3rem; margin-bottom: 1rem;">👤</div>
                                    <h4 class="gaming-font" style="color: #a855f7;">Mi Perfil</h4>
                                    <p class="text-light small">Actualiza tu información</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    @if(Auth::user()->is_admin)
                        <div class="mt-5 pt-4" style="border-top: 1px solid rgba(99, 102, 241, 0.3);">
                            <h4 class="gaming-font text-center mb-4" style="color: #fbbf24;">PANEL DE ADMINISTRADOR</h4>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <a href="{{ route('admin.games.create') }}" class="btn admin-btn w-100" style="
                                        background: linear-gradient(45deg, #22d3ee, #6366f1);
                                        border: none;
                                        color: #0f172a;
                                        font-weight: 600;
                                        padding: 12px;
                                        border-radius: 12px;
                                        transition: all 0.3s ease;
                                    ">
                                        <i class="bi bi-plus-circle me-2"></i> Subir Juego
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('admin.users.index') }}" class="btn admin-btn w-100" style="
                                        background: linear-gradient(45deg, #a855f7, #6366f1);
                                        border: none;
                                        color: white;
                                        font-weight: 600;
                                        padding: 12px;
                                        border-radius: 12px;
                                        transition: all 0.3s ease;
                                    ">
                                        <i class="bi bi-people me-2"></i> Usuarios
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('admin.bans.index') }}" class="btn admin-btn w-100" style="
                                        background: linear-gradient(45deg, #ef4444, #dc2626);
                                        border: none;
                                        color: white;
                                        font-weight: 600;
                                        padding: 12px;
                                        border-radius: 12px;
                                        transition: all 0.3s ease;
                                    ">
                                        <i class="bi bi-shield-x me-2"></i> Baneos
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-all {
        transition: all 0.3s ease;
    }
    
    .gaming-font {
        font-family: 'Orbitron', sans-serif;
    }
    
    .card {
        animation: fadeIn 0.6s ease-out;
    }
    
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
    
    /* Hover effects para las tarjetas de acción */
    .action-card .rounded-4 {
        transition: all 0.3s ease;
    }
    
    .action-card:hover .rounded-4 {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(34, 211, 238, 0.3);
    }
    
    /* Protección visual para botones */
    .action-card.disabled-link,
    .admin-btn.disabled-btn {
        pointer-events: none;
        opacity: 0.6;
    }
</style>

<script>
    // Protección adicional para los botones del dashboard
    document.addEventListener('DOMContentLoaded', function() {
        // Proteger las tarjetas de acción
        const actionCards = document.querySelectorAll('.action-card');
        let isProcessingCard = false;
        
        actionCards.forEach(card => {
            card.addEventListener('click', function(e) {
                if (isProcessingCard) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
                
                isProcessingCard = true;
                
                // Efecto visual
                const div = this.querySelector('.rounded-4');
                const originalText = div.innerHTML;
                
                div.style.opacity = '0.6';
                div.style.cursor = 'wait';
                div.style.pointerEvents = 'none';
                
                setTimeout(() => {
                    isProcessingCard = false;
                    div.style.opacity = '1';
                    div.style.cursor = 'pointer';
                    div.style.pointerEvents = 'auto';
                }, 3000);
            });
        });
        
        // Proteger los botones de admin
        const adminBtns = document.querySelectorAll('.admin-btn');
        let isProcessingAdmin = false;
        
        adminBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (isProcessingAdmin) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
                
                isProcessingAdmin = true;
                
                const originalText = this.innerHTML;
                this.style.opacity = '0.6';
                this.style.cursor = 'wait';
                this.style.pointerEvents = 'none';
                this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Cargando...';
                
                setTimeout(() => {
                    isProcessingAdmin = false;
                    this.style.opacity = '1';
                    this.style.cursor = 'pointer';
                    this.style.pointerEvents = 'auto';
                    this.innerHTML = originalText;
                }, 3000);
            });
        });
    });
</script>
@endsection