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
            🚫 CONTROL DE USUARIOS BANEADOS
        </h1>
        <p class="text-light" style="opacity: 0.8; font-size: 1rem;">
            Gestiona los usuarios con bloqueo temporal en el sistema
        </p>
    </div>

    {{-- Mensajes de estado --}}
    @if (session('success'))
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

    @if ($bannedUsers->isEmpty())
        <div class="alert text-center py-5" style="
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        ">
            <div class="mb-4" style="font-size: 4rem; color: rgba(34, 211, 238, 0.3);">
                <i class="bi bi-shield-check"></i>
            </div>
            <h4 class="gaming-font mb-3" style="color: #e2e8f0;">
                🎮 NO HAY USUARIOS BANEADOS 🎮
            </h4>
            <p class="text-light mb-4" style="opacity: 0.7; max-width: 500px; margin: 0 auto;">
                Todos los usuarios están en buen estado. ¡El sistema funciona correctamente!
            </p>
        </div>
    @else
        <div class="card" style="
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        ">
            <div class="card-header border-0 p-4" style="
                background: linear-gradient(45deg, rgba(239, 68, 68, 0.1), rgba(185, 28, 28, 0.1));
                border-bottom: 1px solid rgba(239, 68, 68, 0.2);
            ">
                <h5 class="mb-0 gaming-font d-flex align-items-center" style="color: #f87171;">
                    <i class="bi bi-shield-x fs-4 me-2"></i>
                    USUARIOS BANEADOS ({{ $bannedUsers->count() }})
                </h5>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(239, 68, 68, 0.2);">
                                <th style="color: #e2e8f0; font-weight: 600; padding: 20px;">ID</th>
                                <th style="color: #e2e8f0; font-weight: 600; padding: 20px;">EMAIL</th>
                                <th style="color: #e2e8f0; font-weight: 600; padding: 20px;">BANEADO HASTA</th>
                                <th style="color: #e2e8f0; font-weight: 600; padding: 20px;">ACCIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bannedUsers as $user)
                                @php
                                    $bannedUntil = \Carbon\Carbon::parse($user->banned_until);
                                    $isExpired = $bannedUntil->isPast();
                                    $remainingTime = $isExpired ? 'Expirado' : $bannedUntil->diffForHumans();
                                @endphp
                                <tr style="border-bottom: 1px solid rgba(239, 68, 68, 0.1);">
                                    <td style="padding: 20px;">
                                        <span class="badge" style="
                                            background: rgba(34, 211, 238, 0.1);
                                            color: #22d3ee;
                                            padding: 5px 10px;
                                            border-radius: 8px;
                                            font-size: 0.9rem;
                                        ">
                                            #{{ $user->id }}
                                        </span>
                                    </td>
                                    <td style="padding: 20px;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle me-2" style="color: #94a3b8; font-size: 1.2rem;"></i>
                                            <span style="color: #e2e8f0; font-weight: 500;">{{ $user->email }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 20px;">
                                        <div class="d-flex flex-column">
                                            <span style="
                                                color: #f87171;
                                                font-weight: 700;
                                                font-size: 1rem;
                                            ">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $bannedUntil->format('d/m/Y H:i:s') }}
                                            </span>
                                            <small style="color: #94a3b8; font-size: 0.8rem;">
                                                {{ $remainingTime }}
                                            </small>
                                        </div>
                                    </td>
                                    <td style="padding: 20px;">
                                        <form method="POST" action="{{ route('admin.bans.unban') }}" 
                                              onsubmit="return confirm('¿Estás seguro de que quieres desbanear a {{ $user->email }}?');">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <button type="submit" class="btn" style="
                                                background: linear-gradient(45deg, #22d3ee, #6366f1);
                                                border: none;
                                                color: #0f172a;
                                                font-weight: 600;
                                                padding: 8px 16px;
                                                border-radius: 8px;
                                                transition: all 0.3s ease;
                                                font-size: 0.9rem;
                                                display: inline-flex;
                                                align-items: center;
                                                gap: 6px;
                                            ">
                                                <i class="bi bi-unlock"></i> Desbanear
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Footer con estadísticas --}}
            <div class="card-footer border-0 p-4" style="
                background: rgba(15, 23, 42, 0.4);
                border-top: 1px solid rgba(239, 68, 68, 0.2);
            ">
                <div class="row text-center">
                    <div class="col-4">
                        <span style="color: #94a3b8; font-size: 0.8rem;">TOTAL BANEADOS</span>
                        <h4 style="color: #22d3ee; font-weight: 900;">{{ $bannedUsers->count() }}</h4>
                    </div>
                    <div class="col-4">
                        <span style="color: #94a3b8; font-size: 0.8rem;">EXPIRAN HOY</span>
                        <h4 style="color: #f87171; font-weight: 900;">
                            {{ $bannedUsers->filter(function($user) {
                                return \Carbon\Carbon::parse($user->banned_until)->isToday();
                            })->count() }}
                        </h4>
                    </div>
                    <div class="col-4">
                        <span style="color: #94a3b8; font-size: 0.8rem;">BANEOS ACTIVOS</span>
                        <h4 style="color: #a855f7; font-weight: 900;">
                            {{ $bannedUsers->filter(function($user) {
                                return !\Carbon\Carbon::parse($user->banned_until)->isPast();
                            })->count() }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Botón de volver --}}
        <div class="text-center mt-4">
            <a href="{{ route('admin.users.index') }}" class="btn" style="
                background: rgba(15, 23, 42, 0.7);
                border: 1px solid rgba(99, 102, 241, 0.3);
                color: #22d3ee;
                font-weight: 600;
                padding: 10px 25px;
                border-radius: 10px;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            ">
                <i class="bi bi-arrow-left"></i> Volver a Gestión de Usuarios
            </a>
        </div>
    @endif
</div>

<style>
    /* Efectos hover para botones */
    .btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease !important;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(34, 211, 238, 0.3) !important;
    }
    
    button[type="submit"]:hover {
        background: linear-gradient(45deg, #22d3ee, #6366f1) !important;
        box-shadow: 0 10px 25px rgba(34, 211, 238, 0.4) !important;
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
    
    /* Scrollbar personalizada */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: rgba(15, 23, 42, 0.3);
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(45deg, #22d3ee, #6366f1);
        border-radius: 4px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .gaming-font {
            font-size: 1.5rem !important;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        td, th {
            padding: 15px !important;
        }
        
        .btn {
            padding: 6px 12px !important;
            font-size: 0.8rem !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto de brillo en botones de desbanear
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Actualizar contadores en tiempo real (opcional)
        function updateStats() {
            // Aquí podrías agregar lógica AJAX para actualizar stats
        }
    });
</script>
@endsection