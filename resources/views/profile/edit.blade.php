@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
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
                    👤 MI PERFIL
                </h1>
                <p class="text-light" style="opacity: 0.8; font-size: 1rem;">
                    Gestiona tu información personal y configuración de cuenta
                </p>
            </div>

            {{-- Mensaje de éxito --}}
            @if (session('status') === 'profile-updated')
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
                        <span>¡Perfil actualizado correctamente!</span>
                    </div>
                </div>
            @endif

            {{-- Información del usuario --}}
            <div class="row mb-4">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card h-100" style="
                        background: rgba(15, 23, 42, 0.7);
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(34, 211, 238, 0.2);
                        border-radius: 20px;
                        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                    ">
                        <div class="card-body p-4 text-center">
                            <div class="mb-4">
                                <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center" style="
                                    width: 120px;
                                    height: 120px;
                                    background: linear-gradient(45deg, #22d3ee, #a855f7);
                                    border: 3px solid rgba(255,255,255,0.2);
                                ">
                                    <i class="bi bi-person-circle" style="font-size: 4rem; color: #0f172a;"></i>
                                </div>
                            </div>
                            
                            <h3 class="gaming-font text-white mb-2">{{ Auth::user()->name }}</h3>
                            <p class="text-light mb-3" style="opacity: 0.8;">{{ Auth::user()->email }}</p>
                            
                            <div class="mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
                                <div class="d-flex justify-content-between text-light mb-2">
                                    <span>Miembro desde:</span>
                                    <span class="fw-bold" style="color: #22d3ee;">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between text-light">
                                    <span>Rol:</span>
                                    <span class="fw-bold" style="color: {{ Auth::user()->is_admin ? '#a855f7' : '#22d3ee' }};">
                                        {{ Auth::user()->is_admin ? 'ADMINISTRADOR' : 'JUGADOR' }}
                                    </span>
                                </div>
                                
                                {{-- 🔥 BOTÓN DE HISTORIAL DE COMPRAS --}}
                                <div class="mt-4">
                                    <a href="{{ route('profile.orders') }}" class="btn w-100" style="
                                        background: linear-gradient(45deg, #22d3ee, #6366f1);
                                        border: none;
                                        color: #0f172a;
                                        font-weight: 700;
                                        padding: 12px;
                                        border-radius: 12px;
                                        transition: all 0.3s ease;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        gap: 8px;
                                    ">
                                        <i class="bi bi-clock-history"></i>
                                        VER HISTORIAL DE COMPRAS
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    {{-- Actualizar información --}}
                    <div class="card mb-4" style="
                        background: rgba(15, 23, 42, 0.7);
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(99, 102, 241, 0.2);
                        border-radius: 20px;
                        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                    ">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle p-3 me-3" style="background: rgba(34, 211, 238, 0.1);">
                                    <i class="bi bi-pencil-square" style="color: #22d3ee; font-size: 1.2rem;"></i>
                                </div>
                                <h4 class="gaming-font mb-0" style="color: #22d3ee;">INFORMACIÓN PERSONAL</h4>
                            </div>
                            
                            {{-- Formulario de información personal --}}
                            <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                                @csrf
                                @method('patch')
                                
                                <div class="mb-4">
                                    <label for="name" class="form-label">NOMBRE DE USUARIO</label>
                                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', Auth::user()->name) }}" required autofocus style="
                                        background: rgba(15, 23, 42, 0.6);
                                        border: 1px solid rgba(99, 102, 241, 0.2);
                                        border-radius: 12px;
                                        padding: 14px;
                                        color: #e2e8f0;
                                        font-size: 1rem;
                                        transition: all 0.3s ease;
                                    ">
                                    @error('name')
                                        <div class="text-danger mt-2 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label">CORREO ELECTRÓNICO</label>
                                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required style="
                                        background: rgba(15, 23, 42, 0.6);
                                        border: 1px solid rgba(99, 102, 241, 0.2);
                                        border-radius: 12px;
                                        padding: 14px;
                                        color: #e2e8f0;
                                        font-size: 1rem;
                                        transition: all 0.3s ease;
                                    ">
                                    @error('email')
                                        <div class="text-danger mt-2 small">{{ $message }}</div>
                                    @enderror
                                    
                                    @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                                        <div class="mt-2">
                                            <p class="text-sm text-light">
                                                Tu correo no está verificado.
                                                <button form="send-verification" class="btn btn-link p-0" style="color: #22d3ee;">
                                                    Haz clic aquí para reenviar el correo de verificación.
                                                </button>
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn" id="saveProfileBtn" style="
                                        background: linear-gradient(45deg, #22d3ee, #6366f1);
                                        border: none;
                                        color: #0f172a;
                                        font-weight: 700;
                                        padding: 12px 28px;
                                        border-radius: 12px;
                                        transition: all 0.3s ease;
                                    ">
                                        <i class="bi bi-save me-2"></i> GUARDAR CAMBIOS
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Actualizar contraseña --}}
                    <div class="card mb-4" style="
                        background: rgba(15, 23, 42, 0.7);
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(168, 85, 247, 0.2);
                        border-radius: 20px;
                        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                    ">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle p-3 me-3" style="background: rgba(168, 85, 247, 0.1);">
                                    <i class="bi bi-key" style="color: #a855f7; font-size: 1.2rem;"></i>
                                </div>
                                <h4 class="gaming-font mb-0" style="color: #a855f7;">CAMBIAR CONTRASEÑA</h4>
                            </div>
                            
                            {{-- Formulario de cambio de contraseña --}}
                            <form method="POST" action="{{ route('password.update') }}" id="passwordForm">
                                @csrf
                                @method('put')
                                
                                <div class="mb-4">
                                    <label for="current_password" class="form-label">CONTRASEÑA ACTUAL</label>
                                    <input id="current_password" name="current_password" type="password" class="form-control" required style="
                                        background: rgba(15, 23, 42, 0.6);
                                        border: 1px solid rgba(99, 102, 241, 0.2);
                                        border-radius: 12px;
                                        padding: 14px;
                                        color: #e2e8f0;
                                        font-size: 1rem;
                                        transition: all 0.3s ease;
                                    ">
                                    @error('current_password')
                                        <div class="text-danger mt-2 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label">NUEVA CONTRASEÑA</label>
                                    <input id="password" name="password" type="password" class="form-control" required style="
                                        background: rgba(15, 23, 42, 0.6);
                                        border: 1px solid rgba(99, 102, 241, 0.2);
                                        border-radius: 12px;
                                        padding: 14px;
                                        color: #e2e8f0;
                                        font-size: 1rem;
                                        transition: all 0.3s ease;
                                    ">
                                    <div class="form-text mt-2" style="color: #94a3b8; font-size: 0.8rem;">
                                        <i class="bi bi-info-circle me-1"></i> Mínimo 8 caracteres con letras y números
                                    </div>
                                    @error('password')
                                        <div class="text-danger mt-2 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">CONFIRMAR NUEVA CONTRASEÑA</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required style="
                                        background: rgba(15, 23, 42, 0.6);
                                        border: 1px solid rgba(99, 102, 241, 0.2);
                                        border-radius: 12px;
                                        padding: 14px;
                                        color: #e2e8f0;
                                        font-size: 1rem;
                                        transition: all 0.3s ease;
                                    ">
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn" id="changePasswordBtn" style="
                                        background: linear-gradient(45deg, #a855f7, #6366f1);
                                        border: none;
                                        color: #0f172a;
                                        font-weight: 700;
                                        padding: 12px 28px;
                                        border-radius: 12px;
                                        transition: all 0.3s ease;
                                    ">
                                        <i class="bi bi-shield-lock me-2"></i> ACTUALIZAR CONTRASEÑA
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Eliminar cuenta --}}
                    <div class="card" style="
                        background: rgba(15, 23, 42, 0.7);
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(239, 68, 68, 0.2);
                        border-radius: 20px;
                        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                    ">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle p-3 me-3" style="background: rgba(239, 68, 68, 0.1);">
                                    <i class="bi bi-exclamation-triangle" style="color: #ef4444; font-size: 1.2rem;"></i>
                                </div>
                                <h4 class="gaming-font mb-0" style="color: #ef4444;">ZONA DE PELIGRO</h4>
                            </div>
                            
                            {{-- Formulario de eliminación de cuenta --}}
                            <div class="alert mb-4" style="
                                background: rgba(239, 68, 68, 0.05);
                                border: 1px solid rgba(239, 68, 68, 0.2);
                                border-radius: 12px;
                                color: #fecaca;
                                padding: 15px;
                            ">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>¡ADVERTENCIA!</strong> Esta acción es irreversible. Todos tus datos serán eliminados permanentemente.
                            </div>

                            <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                                @csrf
                                @method('delete')
                                
                                <div class="mb-4">
                                    <label for="password_delete" class="form-label">CONTRASEÑA PARA CONFIRMAR</label>
                                    <input id="password_delete" name="password" type="password" class="form-control" required style="
                                        background: rgba(15, 23, 42, 0.6);
                                        border: 1px solid rgba(239, 68, 68, 0.3);
                                        border-radius: 12px;
                                        padding: 14px;
                                        color: #e2e8f0;
                                        font-size: 1rem;
                                        transition: all 0.3s ease;
                                    " placeholder="Ingresa tu contraseña para confirmar">
                                    @error('password', 'userDeletion')
                                        <div class="text-danger mt-2 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn" id="deleteAccountBtn" style="
                                        background: rgba(239, 68, 68, 0.2);
                                        border: 1px solid rgba(239, 68, 68, 0.4);
                                        color: #fecaca;
                                        font-weight: 700;
                                        padding: 12px 28px;
                                        border-radius: 12px;
                                        transition: all 0.3s ease;
                                    " onclick="return confirm('¿Estás SEGURO de que quieres eliminar tu cuenta? Esta acción no se puede deshacer.');">
                                        <i class="bi bi-trash me-2"></i> ELIMINAR MI CUENTA
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
    
    /* Estilos para los formularios de perfil */
    .form-control {
        background: rgba(15, 23, 42, 0.6) !important;
        border: 1px solid rgba(99, 102, 241, 0.2) !important;
        border-radius: 12px !important;
        padding: 12px 16px !important;
        color: #e2e8f0 !important;
        transition: all 0.3s ease !important;
    }
    
    .form-control:focus {
        border-color: rgba(34, 211, 238, 0.6) !important;
        box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.1) !important;
        outline: none !important;
        transform: translateY(-1px);
    }
    
    .form-label {
        color: #cbd5e1 !important;
        font-weight: 600 !important;
        font-size: 0.9rem !important;
        margin-bottom: 8px !important;
        letter-spacing: 0.5px !important;
    }
    
    /* Efectos para botones */
    .btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease !important;
    }
    
    .btn:hover {
        transform: translateY(-2px) !important;
    }
    
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
    
    .form-text {
        color: #94a3b8 !important;
    }
    
    hr {
        border-color: rgba(255,255,255,0.1) !important;
    }
    
    .text-muted {
        color: #94a3b8 !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .gaming-font {
            font-size: 1.8rem !important;
        }
        
        .card-body {
            padding: 25px !important;
        }
        
        .btn {
            width: 100%;
        }
        
        .d-flex.justify-content-end {
            justify-content: center !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Protección contra doble clic para formularios
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    if (submitBtn.disabled) {
                        e.preventDefault();
                        return false;
                    }
                    
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.7';
                    submitBtn.style.cursor = 'not-allowed';
                    
                    if (submitBtn.id === 'saveProfileBtn') {
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> GUARDANDO...';
                    } else if (submitBtn.id === 'changePasswordBtn') {
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> ACTUALIZANDO...';
                    } else if (submitBtn.id === 'deleteAccountBtn') {
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> ELIMINANDO...';
                    }
                    
                    return true;
                }
            });
        });
        
        // Efecto focus en inputs
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-1px)';
            });
            
            input.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection