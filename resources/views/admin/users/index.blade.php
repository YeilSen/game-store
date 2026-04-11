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
            👥 GESTIÓN DE USUARIOS
        </h1>
        <p class="text-light" style="opacity: 0.8; font-size: 1rem;">
            Administra los usuarios registrados en la plataforma
        </p>
    </div>

    {{-- Botón de volver --}}
    <div class="mb-4">
        <a href="{{ route('catalog') }}" class="btn" style="
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: #22d3ee;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        ">
            <i class="bi bi-arrow-left"></i> Volver al Catálogo
        </a>
    </div>

    {{-- Mensajes de estado --}}
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

    @if ($users->isEmpty())
        <div class="alert text-center py-5" style="
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        ">
            <div class="mb-4" style="font-size: 4rem; color: rgba(34, 211, 238, 0.3);">
                <i class="bi bi-people"></i>
            </div>
            <h4 class="gaming-font mb-3" style="color: #e2e8f0;">
                🎮 NO HAY USUARIOS REGISTRADOS 🎮
            </h4>
            <p class="text-light mb-4" style="opacity: 0.7; max-width: 500px; margin: 0 auto;">
                (Aparte de los administradores)
            </p>
        </div>
    @else
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
                    <i class="bi bi-people me-2"></i> USUARIOS REGISTRADOS ({{ $users->count() }})
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
                                <th style="color: #ffffff !important; font-weight: 700; padding: 20px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">ID</th>
                                <th style="color: #ffffff !important; font-weight: 700; padding: 20px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">NOMBRE</th>
                                <th style="color: #ffffff !important; font-weight: 700; padding: 20px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">EMAIL</th>
                                <th style="color: #ffffff !important; font-weight: 700; padding: 20px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">FECHA DE REGISTRO</th>
                                <th style="color: #ffffff !important; font-weight: 700; text-align: center; padding: 20px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">ACCIONES</th>
                             </tr>
                        </thead>
                        <tbody style="background: transparent !important;">
                            @foreach ($users as $user)
                                <tr style="border-bottom: 1px solid rgba(99, 102, 241, 0.1); background: transparent !important;">
                                    <td style="padding: 20px; background: transparent !important;">
                                        <span class="badge" style="
                                            background: rgba(34, 211, 238, 0.2);
                                            color: #22d3ee;
                                            font-size: 0.9rem;
                                            font-weight: 700;
                                            padding: 6px 12px;
                                            border-radius: 8px;
                                        ">
                                            #{{ $user->id }}
                                        </span>
                                     </td>
                                    <td style="padding: 20px; background: transparent !important;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle me-2" style="color: #a855f7; font-size: 1.2rem;"></i>
                                            <span style="color: #ffffff; font-weight: 600;">{{ $user->name }}</span>
                                        </div>
                                     </td>
                                    <td style="padding: 20px; background: transparent !important;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-envelope me-2" style="color: #22d3ee; font-size: 1rem;"></i>
                                            <span style="color: #e2e8f0;">{{ $user->email }}</span>
                                        </div>
                                     </td>
                                    <td style="padding: 20px; background: transparent !important;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar3 me-2" style="color: #10b981; font-size: 1rem;"></i>
                                            <span style="color: #cbd5e1;">{{ $user->created_at->format('d/m/Y') }}</span>
                                        </div>
                                     </td>
                                    <td style="text-align: center; padding: 20px; background: transparent !important;">
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm" style="
                                                background: rgba(239, 68, 68, 0.2);
                                                border: 1px solid rgba(239, 68, 68, 0.4);
                                                color: #fecaca;
                                                padding: 8px 16px;
                                                border-radius: 8px;
                                                font-size: 0.85rem;
                                                font-weight: 600;
                                                transition: all 0.3s ease;
                                            "
                                            onclick="return confirm('¿Estás seguro de que quieres eliminar a este usuario? Esta acción es irreversible.');">
                                                <i class="bi bi-trash me-1"></i> Eliminar
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
                border-top: 1px solid rgba(99, 102, 241, 0.2);
            ">
                <div class="row text-center">
                    <div class="col-md-4">
                        <span style="color: #94a3b8; font-size: 0.8rem;">TOTAL USUARIOS</span>
                        <h4 style="color: #22d3ee; font-weight: 900;">{{ $users->count() }}</h4>
                    </div>
                    <div class="col-md-4">
                        <span style="color: #94a3b8; font-size: 0.8rem;">REGISTRADOS ESTE MES</span>
                        <h4 style="color: #a855f7; font-weight: 900;">
                            {{ $users->filter(function($user) { return $user->created_at->isCurrentMonth(); })->count() }}
                        </h4>
                    </div>
                    <div class="col-md-4">
                        <span style="color: #94a3b8; font-size: 0.8rem;">ÚLTIMO REGISTRO</span>
                        <h4 style="color: #10b981; font-weight: 900; font-size: 1.1rem;">
                            {{ $users->max('created_at') ? $users->max('created_at')->diffForHumans() : 'N/A' }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
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
    
    /* Efecto hover en filas */
    tbody tr {
        transition: all 0.3s ease;
    }
    
    tbody tr:hover {
        background: rgba(34, 211, 238, 0.05) !important;
        transform: scale(1.01);
    }
    
    /* Efecto hover para botón eliminar */
    button[type="submit"]:hover {
        background: rgba(239, 68, 68, 0.4) !important;
        border-color: rgba(239, 68, 68, 0.6) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
    }
    
    /* Botón de volver */
    a.btn:hover {
        background: rgba(99, 102, 241, 0.2) !important;
        border-color: rgba(34, 211, 238, 0.5) !important;
        transform: translateX(-3px);
        color: #a5f3fc !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .gaming-font {
            font-size: 1.8rem !important;
        }
        
        .table-responsive {
            font-size: 0.85rem;
        }
        
        td, th {
            padding: 15px !important;
        }
        
        .btn-sm {
            padding: 6px 12px !important;
            font-size: 0.75rem !important;
        }
    }
</style>
@endsection