<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rayonic | Tienda de Juegos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --cyber-cyan: #22d3ee;
            --cyber-purple: #a855f7;
            --cyber-indigo: #6366f1;
            --dark-bg: #0a0a14;
            --darker-bg: #050510;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: 
                radial-gradient(circle at 20% 50%, rgba(56, 189, 248, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
                linear-gradient(to bottom, var(--darker-bg), var(--dark-bg));
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: -1;
        }
        
        .gaming-font {
            font-family: 'Orbitron', sans-serif;
        }
        
        /* NAVBAR ESTILIZADA */
        .navbar {
            background: rgba(10, 10, 20, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.5);
            padding: 15px 0;
        }
        
        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(34, 211, 238, 0.7), 
                rgba(139, 92, 246, 0.7), 
                transparent
            );
            z-index: 2;
        }
        
        .navbar-brand {
            font-family: 'Orbitron', sans-serif;
            font-weight: 900;
            font-size: 1.8rem;
            background: linear-gradient(45deg, var(--cyber-cyan), var(--cyber-purple));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 20px rgba(34, 211, 238, 0.3);
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            text-shadow: 0 0 30px rgba(34, 211, 238, 0.5);
            transform: translateY(-1px);
        }
        
        .nav-link {
            color: #e2e8f0 !important;
            font-weight: 500;
            padding: 8px 15px !important;
            margin: 0 5px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: white !important;
            background: rgba(99, 102, 241, 0.1);
            transform: translateY(-2px);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--cyber-cyan), var(--cyber-purple));
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        .nav-link.text-warning {
            color: #fbbf24 !important;
            background: rgba(251, 191, 36, 0.1);
        }
        
        .nav-link.text-warning:hover {
            background: rgba(251, 191, 36, 0.2);
        }
        
        /* DROPDOWN ESTILIZADO */
        .dropdown-menu {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            padding: 10px 0;
        }
        
        .dropdown-item {
            color: #e2e8f0;
            padding: 10px 20px;
            transition: all 0.3s ease;
            border-radius: 6px;
            margin: 2px 10px;
            width: auto;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(90deg, rgba(34, 211, 238, 0.1), rgba(139, 92, 246, 0.1));
            color: white;
            transform: translateX(5px);
        }
        
        .dropdown-divider {
            border-color: rgba(99, 102, 241, 0.2);
            margin: 8px 0;
        }
        
        /* BADGE PARA EL CARRITO */
        .badge.bg-danger {
            background: linear-gradient(45deg, #ef4444, #dc2626) !important;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
            font-size: 0.7rem;
            padding: 4px 8px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        /* TOGGLER BUTTON */
        .navbar-toggler {
            border: 1px solid rgba(99, 102, 241, 0.3);
            padding: 5px 10px;
            transition: all 0.3s ease;
        }
        
        .navbar-toggler:hover {
            border-color: var(--cyber-cyan);
            box-shadow: 0 0 10px rgba(34, 211, 238, 0.5);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='%2322d3ee' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z'/%3E%3C/svg");
        }
        
        /* CONTENIDO PRINCIPAL */
        main {
            padding-top: 20px !important;
            min-height: calc(100vh - 180px);
        }
        
        /* EFECTOS DE GLOW PARA EL FONDO */
        .glow-effect {
            position: fixed;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.2;
            z-index: -1;
            pointer-events: none;
        }
        
        .glow-cyan {
            background: radial-gradient(circle, rgba(34, 211, 238, 0.7) 0%, transparent 70%);
            top: 10%;
            left: 10%;
            animation: float 8s ease-in-out infinite;
        }
        
        .glow-purple {
            background: radial-gradient(circle, rgba(168, 85, 247, 0.7) 0%, transparent 70%);
            bottom: 10%;
            right: 10%;
            animation: float 10s ease-in-out infinite reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
        
        /* RESPONSIVIDAD */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }
            
            .nav-link {
                margin: 5px 0;
                padding: 10px 15px !important;
            }
            
            .dropdown-menu {
                margin-top: 10px;
                background: rgba(15, 23, 42, 0.98);
            }
        }
        
        /* ANIMACIÓN DE ENTRADA PARA ELEMENTOS */
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    {{-- EFECTOS DE FONDO --}}
    <div class="glow-effect glow-cyan"></div>
    <div class="glow-effect glow-purple"></div>
    
    {{-- BARRA DE NAVEGACIÓN --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fade-in">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                🎮 Rayonic
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalog') }}">
                            <i class="bi bi-grid"></i> Catálogo
                        </a>
                    </li>
                    
                    @auth
                        @if(Auth::user()->is_admin)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-warning" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-shield-check"></i> Panel Admin
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                            <i class="bi bi-people"></i> Usuarios
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.logs.index') }}">
                                            <i class="bi bi-clock-history"></i> Logs de Sesión
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.bans.index') }}">
                                            <i class="bi bi-shield-x"></i> Gestionar Baneos
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart3"></i> Carrito
                                @if(session('cart') && count(session('cart')) > 0)
                                    <span class="badge bg-danger rounded-pill">{{ count(session('cart')) }}</span>
                                @endif
                            </a>
                        </li>
                    @endauth
                </ul>

                {{-- RUTAS DE AUTENTICACIÓN Y PERFIL --}}
                <ul class="navbar-nav">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                                </a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="bi bi-person-plus"></i> Registrarse
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-gear me-2"></i> Mi Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="py-4 fade-in">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Scripts de Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
        // =====================================================
        // 🔥 ANIMACIONES DEL NAVBAR 🔥
        // =====================================================
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach((link, index) => {
                link.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // =====================================================
        // 🔥 PROTECCIÓN CONTRA DOBLE CLIC (TODO EL SISTEMA) 🔥
        // =====================================================
        document.addEventListener('DOMContentLoaded', function() {
            
            // =====================================================
            // 1️⃣ PROTEGER TODOS LOS FORMULARIOS
            // =====================================================
            const forms = document.querySelectorAll('form');
            
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    
                    // Buscar el botón submit dentro de este formulario
                    const submitButton = this.querySelector('button[type="submit"]');
                    
                    if (submitButton) {
                        // Verificar si ya está deshabilitado (para evitar loops)
                        if (submitButton.disabled) {
                            e.preventDefault();
                            return false;
                        }
                        
                        // Guardar el texto original (para restaurarlo después)
                        if (!submitButton.hasAttribute('data-original-text')) {
                            submitButton.setAttribute('data-original-text', submitButton.innerHTML);
                        }
                        
                        const originalText = submitButton.innerHTML;
                        
                        // Deshabilitar el botón
                        submitButton.disabled = true;
                        
                        // Cambiar el texto (con icono de carga de Bootstrap)
                        submitButton.innerHTML = `
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Procesando...
                        `;
                        
                        // Mantener el estilo original (para no perder el diseño)
                        submitButton.style.opacity = '0.8';
                        submitButton.style.cursor = 'not-allowed';
                        
                        // Agregar clase para estilos adicionales
                        submitButton.classList.add('btn-processing');
                        
                        // Opcional: Re-habilitar después de 5 segundos (solo si hay error)
                        // Esto es útil si el servidor tarda o si algo falla
                        setTimeout(() => {
                            if (submitButton.disabled) {
                                submitButton.disabled = false;
                                submitButton.innerHTML = submitButton.getAttribute('data-original-text') || originalText;
                                submitButton.style.opacity = '1';
                                submitButton.style.cursor = 'pointer';
                                submitButton.classList.remove('btn-processing');
                            }
                        }, 5000);
                    }
                });
            });
            
            // =====================================================
            // 2️⃣ PROTEGER ENLACES PELIGROSOS
            // (como eliminar, vaciar carrito, etc.)
            // =====================================================
            const dangerousLinks = document.querySelectorAll('a[onclick*="confirm"], a.delete-link, .btn-danger, [data-confirm]');
            
            dangerousLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.classList.contains('disabled')) {
                        e.preventDefault();
                        return false;
                    }
                    
                    this.classList.add('disabled');
                    this.style.opacity = '0.6';
                    this.style.pointerEvents = 'none';
                    
                    // Si el enlace tiene confirmación, esperamos
                    if (this.hasAttribute('onclick') && this.getAttribute('onclick').includes('confirm')) {
                        // No hacemos nada, la confirmación ya maneja
                    } else {
                        // Re-habilitar después de 2 segundos
                        setTimeout(() => {
                            this.classList.remove('disabled');
                            this.style.opacity = '1';
                            this.style.pointerEvents = 'auto';
                        }, 2000);
                    }
                });
            });
        });

        // =====================================================
        // 🔥 FUNCIÓN GLOBAL PARA RE-HABILITAR BOTONES (útil para AJAX)
        // =====================================================
        window.enableSubmitButtons = function(formId) {
            const form = document.getElementById(formId);
            if (form) {
                const btn = form.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = btn.getAttribute('data-original-text') || 'Enviar';
                    btn.style.opacity = '1';
                    btn.style.cursor = 'pointer';
                    btn.classList.remove('btn-processing');
                }
            }
        };

        // =====================================================
        // 🔥 FUNCIÓN PARA DESHABILITAR BOTÓN MANUALMENTE
        // =====================================================
        window.disableSubmitButton = function(formId, message = 'Procesando...') {
            const form = document.getElementById(formId);
            if (form) {
                const btn = form.querySelector('button[type="submit"]');
                if (btn) {
                    if (!btn.hasAttribute('data-original-text')) {
                        btn.setAttribute('data-original-text', btn.innerHTML);
                    }
                    btn.disabled = true;
                    btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> ${message}`;
                    btn.style.opacity = '0.8';
                    btn.style.cursor = 'not-allowed';
                    btn.classList.add('btn-processing');
                }
            }
        };
    </script>

    <style>
        /* Estilos adicionales para botones en procesamiento */
        .btn-processing {
            cursor: not-allowed !important;
            pointer-events: none !important;
            position: relative;
            overflow: hidden;
        }
        
        .btn-processing::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        /* Estilo para enlaces deshabilitados */
        .disabled {
            pointer-events: none;
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Spinner personalizado */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }
    </style>
</body>
</html>