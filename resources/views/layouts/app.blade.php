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
        
        /* ESTILOS UNIFORMES PARA TODOS LOS BOTONES */
        .nav-link {
            color: #e2e8f0 !important;
            font-weight: 500;
            padding: 8px 15px !important;
            margin: 0 5px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            background: transparent;
        }
        
        .nav-link:hover {
            color: white !important;
            background: rgba(99, 102, 241, 0.2) !important;
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
        
        /* BOTON DE INICIO */
        .home-btn {
            background: rgba(34, 211, 238, 0.1);
            border: 1px solid rgba(34, 211, 238, 0.3);
            border-radius: 8px;
            padding: 8px 15px;
            color: #22d3ee;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin: 0 5px;
        }
        
        .home-btn:hover {
            background: rgba(34, 211, 238, 0.2);
            color: #a5f3fc;
            transform: translateY(-2px);
            border-color: rgba(34, 211, 238, 0.5);
        }
        
        /* RELOJ */
        .clock {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(34, 211, 238, 0.3);
            border-radius: 8px;
            padding: 8px 15px;
            font-family: 'Orbitron', monospace;
            font-size: 0.9rem;
            font-weight: 600;
            color: #22d3ee;
            letter-spacing: 1px;
            box-shadow: 0 0 10px rgba(34, 211, 238, 0.1);
            backdrop-filter: blur(5px);
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .clock i {
            font-size: 0.9rem;
        }
        
        /* CONTENEDOR DEL RELOJ Y BOTON INICIO */
        .clock-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 20px;
        }
        
        /* NAVBAR CENTRADO */
        .navbar .container {
            display: flex;
            align-items: center;
        }
        
        .navbar-collapse {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .navbar-nav {
            display: flex;
            align-items: center;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
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
        @media (max-width: 992px) {
            .clock-container {
                margin-left: 0;
                margin-top: 10px;
                justify-content: center;
            }
            
            .navbar-collapse {
                flex-direction: column;
                align-items: flex-start;
            }
        }
        
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }
            
            .nav-link {
                margin: 5px 0;
                padding: 10px 15px !important;
                width: 100%;
            }
            
            .home-btn {
                margin: 5px 0;
                width: 100%;
                justify-content: center;
            }
            
            .clock {
                width: 100%;
                justify-content: center;
                margin: 5px 0;
            }
            
            .clock-container {
                flex-direction: column;
                width: 100%;
                margin-top: 15px;
            }
            
            .dropdown-menu {
                margin-top: 10px;
                background: rgba(15, 23, 42, 0.98);
                width: 100%;
            }
        }
        
        /* ANIMACION DE ENTRADA PARA ELEMENTOS */
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
    
    {{-- BARRA DE NAVEGACION --}}
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
                            <i class="bi bi-grid"></i> Catalogo
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
                                        <a class="dropdown-item" href="{{ route('admin.bans.index') }}">
                                            <i class="bi bi-shield-x"></i> Gestionar Baneos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.orders.index') }}">
                                            <i class="bi bi-receipt"></i> Todos los Pedidos
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

                {{-- BOTON INICIO Y RELOJ --}}
                <div class="clock-container">
                    <a href="{{ route('dashboard') }}" class="home-btn">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Inicio</span>
                    </a>
                    <div class="clock" id="liveClock">
                        <i class="bi bi-clock"></i>
                        <span id="clockTime">--:--:--</span>
                        <span id="clockDate" class="ms-1" style="font-size: 0.75rem; color: #94a3b8;"></span>
                    </div>
                </div>

                {{-- RUTAS DE AUTENTICACION Y PERFIL --}}
                <ul class="navbar-nav">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesion
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
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesion
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
        // ANIMACIONES DEL NAVBAR
        // =====================================================
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach((link, index) => {
                link.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // =====================================================
        // RELOJ EN TIEMPO REAL
        // =====================================================
        function updateClock() {
            const now = new Date();
            
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;
            
            const days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
            const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            
            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const dateString = `${dayName} ${day} ${month} ${year}`;
            
            const clockTimeSpan = document.getElementById('clockTime');
            const clockDateSpan = document.getElementById('clockDate');
            
            if (clockTimeSpan) clockTimeSpan.textContent = timeString;
            if (clockDateSpan) clockDateSpan.textContent = dateString;
        }
        
        updateClock();
        setInterval(updateClock, 1000);

        // =====================================================
        // PROTECCION CONTRA DOBLE CLIC
        // =====================================================
        document.addEventListener('DOMContentLoaded', function() {
            
            // Proteger formularios (excluir logout)
            const forms = document.querySelectorAll('form:not(#logout-form)');
            
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitButton = this.querySelector('button[type="submit"]');
                    
                    if (submitButton) {
                        if (submitButton.disabled) {
                            e.preventDefault();
                            return false;
                        }
                        
                        if (!submitButton.hasAttribute('data-original-text')) {
                            submitButton.setAttribute('data-original-text', submitButton.innerHTML);
                        }
                        
                        const originalText = submitButton.innerHTML;
                        
                        submitButton.disabled = true;
                        submitButton.innerHTML = `
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Procesando...
                        `;
                        submitButton.style.opacity = '0.8';
                        submitButton.style.cursor = 'not-allowed';
                        submitButton.classList.add('btn-processing');
                        
                        setTimeout(() => {
                            if (submitButton.disabled) {
                                submitButton.disabled = false;
                                submitButton.innerHTML = submitButton.getAttribute('data-original-text') || originalText;
                                submitButton.style.opacity = '1';
                                submitButton.style.cursor = 'pointer';
                                submitButton.classList.remove('btn-processing');
                            }
                        }, 10000);
                    }
                });
            });
            
            // Proteger enlaces peligrosos
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
                    
                    setTimeout(() => {
                        this.classList.remove('disabled');
                        this.style.opacity = '1';
                        this.style.pointerEvents = 'auto';
                    }, 2000);
                });
            });
            
            // Proteger enlaces de navegacion
            const navButtons = document.querySelectorAll('a.nav-link:not(.dropdown-toggle), .home-btn');
            
            navButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (this.classList.contains('nav-processing')) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                    
                    this.classList.add('nav-processing');
                    this.style.opacity = '0.6';
                    this.style.cursor = 'wait';
                    this.style.pointerEvents = 'none';
                    
                    setTimeout(() => {
                        this.classList.remove('nav-processing');
                        this.style.opacity = '1';
                        this.style.cursor = 'pointer';
                        this.style.pointerEvents = 'auto';
                    }, 3000);
                });
            });
            
            // Proteger todos los botones .btn y enlaces comunes
            const allActionButtons = document.querySelectorAll('.btn, a.btn, button:not([type="submit"]):not(.dropdown-toggle)');
            
            allActionButtons.forEach(button => {
                if (button.classList.contains('home-btn') || 
                    button.classList.contains('nav-processing') || 
                    button.closest('.dropdown-menu')) {
                    return;
                }
                
                let isClicking = false;
                
                button.addEventListener('click', function(e) {
                    if (isClicking || this.classList.contains('action-processing')) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                    
                    isClicking = true;
                    this.classList.add('action-processing');
                    
                    const originalText = this.innerHTML;
                    const originalOpacity = this.style.opacity;
                    
                    this.style.opacity = '0.6';
                    this.style.cursor = 'wait';
                    this.style.pointerEvents = 'none';
                    
                    if (this.innerText && this.innerText.trim().length > 0 && !this.innerText.includes('...')) {
                        this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Cargando...';
                    }
                    
                    setTimeout(() => {
                        isClicking = false;
                        this.classList.remove('action-processing');
                        this.style.opacity = originalOpacity || '1';
                        this.style.cursor = 'pointer';
                        this.style.pointerEvents = 'auto';
                        this.innerHTML = originalText;
                    }, 3000);
                });
            });
        });

        // =====================================================
        // FUNCIONES GLOBALES
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
        
        .nav-processing {
            pointer-events: none !important;
            opacity: 0.6 !important;
            cursor: wait !important;
        }
        
        .action-processing {
            pointer-events: none !important;
            opacity: 0.6 !important;
            cursor: wait !important;
        }
        
        /* Spinner personalizado */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }
    </style>

    {{-- ===================================================== --}}
    {{-- AVISO DE COOKIES --}}
    {{-- ===================================================== --}}
    <div id="cookieConsent" class="cookie-consent" style="display: none;">
        <div class="cookie-content">
            <div class="cookie-icon">
                <i class="bi bi-cookie"></i>
            </div>
            <div class="cookie-text">
                <h4>Aviso de Cookies</h4>
                <p>Utilizamos cookies propias y de terceros para mejorar tu experiencia, realizar analisis y mostrarte contenido personalizado.</p>
                <p class="cookie-small">Al hacer clic en "Aceptar", consientes el uso de TODAS las cookies.</p>
            </div>
            <div class="cookie-buttons">
                <button id="acceptCookies" class="cookie-btn accept">Aceptar</button>
                <button id="declineCookies" class="cookie-btn decline">Rechazar</button>
                <a href="{{ url('/cookies-policy') }}" class="cookie-link">Mas informacion</a>
            </div>
        </div>
    </div>

    <style>
        /* Estilos del aviso de cookies */
        .cookie-consent {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: rgba(10, 10, 20, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(34, 211, 238, 0.3);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(34, 211, 238, 0.1);
            z-index: 9999;
            animation: slideUp 0.5s ease-out;
        }
        
        @keyframes slideUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .cookie-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px 25px;
        }
        
        .cookie-icon {
            font-size: 2.5rem;
            color: #22d3ee;
            background: rgba(34, 211, 238, 0.1);
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .cookie-text {
            flex: 1;
        }
        
        .cookie-text h4 {
            color: #22d3ee;
            font-family: 'Orbitron', sans-serif;
            margin-bottom: 8px;
            font-size: 1.2rem;
        }
        
        .cookie-text p {
            color: #cbd5e1;
            margin: 0;
            font-size: 0.9rem;
        }
        
        .cookie-small {
            font-size: 0.75rem !important;
            color: #94a3b8 !important;
            margin-top: 5px !important;
        }
        
        .cookie-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .cookie-btn {
            padding: 10px 24px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .cookie-btn.accept {
            background: linear-gradient(45deg, #22d3ee, #6366f1);
            color: #0f172a;
        }
        
        .cookie-btn.accept:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(34, 211, 238, 0.4);
        }
        
        .cookie-btn.decline {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fecaca;
        }
        
        .cookie-btn.decline:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: translateY(-2px);
        }
        
        .cookie-link {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .cookie-link:hover {
            color: #22d3ee;
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .cookie-content {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }
            
            .cookie-icon {
                margin: 0 auto;
            }
            
            .cookie-buttons {
                justify-content: center;
            }
        }
    </style>

    <script>
        // =====================================================
        // GESTION DE COOKIES
        // =====================================================
        document.addEventListener('DOMContentLoaded', function() {
            const cookieConsent = document.getElementById('cookieConsent');
            const acceptBtn = document.getElementById('acceptCookies');
            const declineBtn = document.getElementById('declineCookies');
            const cookieLink = document.querySelector('.cookie-link');
            
            let isProcessingCookie = false;
            let isLinkProcessing = false;
            
            function checkCookieConsent() {
                const cookiesAccepted = localStorage.getItem('cookies_accepted');
                const cookiesDeclined = localStorage.getItem('cookies_declined');
                
                if (cookiesAccepted === 'true') {
                    cookieConsent.style.display = 'none';
                } else if (cookiesDeclined === 'true') {
                    cookieConsent.style.display = 'none';
                } else {
                    cookieConsent.style.display = 'block';
                }
            }
            
            function acceptCookies() {
                if (isProcessingCookie) return;
                isProcessingCookie = true;
                
                if (acceptBtn) {
                    acceptBtn.style.opacity = '0.6';
                    acceptBtn.style.cursor = 'wait';
                    acceptBtn.style.pointerEvents = 'none';
                }
                
                localStorage.setItem('cookies_accepted', 'true');
                localStorage.removeItem('cookies_declined');
                cookieConsent.style.display = 'none';
                showToast('Has aceptado las cookies', 'success');
                
                setTimeout(() => {
                    isProcessingCookie = false;
                    if (acceptBtn) {
                        acceptBtn.style.opacity = '1';
                        acceptBtn.style.cursor = 'pointer';
                        acceptBtn.style.pointerEvents = 'auto';
                    }
                }, 1000);
            }
            
            function declineCookies() {
                if (isProcessingCookie) return;
                isProcessingCookie = true;
                
                if (declineBtn) {
                    declineBtn.style.opacity = '0.6';
                    declineBtn.style.cursor = 'wait';
                    declineBtn.style.pointerEvents = 'none';
                }
                
                localStorage.setItem('cookies_declined', 'true');
                localStorage.removeItem('cookies_accepted');
                cookieConsent.style.display = 'none';
                showToast('Solo se usaran cookies esenciales', 'info');
                
                setTimeout(() => {
                    isProcessingCookie = false;
                    if (declineBtn) {
                        declineBtn.style.opacity = '1';
                        declineBtn.style.cursor = 'pointer';
                        declineBtn.style.pointerEvents = 'auto';
                    }
                }, 1000);
            }
            
            function handleCookieLink(e) {
                if (isLinkProcessing) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
                
                isLinkProcessing = true;
                
                if (cookieLink) {
                    cookieLink.style.opacity = '0.6';
                    cookieLink.style.cursor = 'wait';
                    cookieLink.style.pointerEvents = 'none';
                }
                
                setTimeout(() => {
                    isLinkProcessing = false;
                    if (cookieLink) {
                        cookieLink.style.opacity = '1';
                        cookieLink.style.cursor = 'pointer';
                        cookieLink.style.pointerEvents = 'auto';
                    }
                }, 2000);
                
                return true;
            }
            
            function showToast(message, type = 'info') {
                const toast = document.createElement('div');
                toast.style.cssText = `
                    position: fixed;
                    bottom: 100px;
                    right: 20px;
                    background: ${type === 'success' ? 'linear-gradient(135deg, #22c55e, #16a34a)' : 'rgba(15, 23, 42, 0.95)'};
                    color: white;
                    padding: 12px 20px;
                    border-radius: 12px;
                    font-size: 0.9rem;
                    z-index: 10000;
                    animation: slideInRight 0.3s ease-out;
                    border: 1px solid rgba(255,255,255,0.2);
                    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                `;
                toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i> ${message}`;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 0.3s';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
            
            if (acceptBtn) acceptBtn.addEventListener('click', acceptCookies);
            if (declineBtn) declineBtn.addEventListener('click', declineCookies);
            if (cookieLink) cookieLink.addEventListener('click', handleCookieLink);
            
            checkCookieConsent();
        });
    </script>

    {{-- ===================================================== --}}
    {{-- PROTECCION DE FLECHAS DEL NAVEGADOR (SOLO DASHBOARD) --}}
    {{-- ===================================================== --}}
    <script>
        // Proteccion simple que NO interfiere con los dropdowns
        (function() {
            // Verificar si estamos en el dashboard
            const isDashboard = window.location.pathname === '/dashboard' || window.location.pathname === '/home';
            
            @auth
                if (isDashboard) {
                    // Agregar una entrada al historial
                    history.pushState(null, null, location.href);
                    
                    // Manejar el boton atras
                    window.addEventListener('popstate', function() {
                        // Redirigir de vuelta al dashboard
                        location.href = '{{ route("dashboard") }}';
                    });
                }
            @endauth
            
            // Prevenir acceso despues de cerrar sesion
            @guest
                const wasLoggedIn = sessionStorage.getItem('rayonic_auth') === 'true';
                const logoutTime = sessionStorage.getItem('rayonic_logout_time');
                const timeSinceLogout = logoutTime ? Date.now() - parseInt(logoutTime) : 9999;
                
                if (wasLoggedIn && timeSinceLogout < 3000) {
                    sessionStorage.removeItem('rayonic_auth');
                    sessionStorage.removeItem('rayonic_logout_time');
                    
                    const protectedPages = ['/dashboard', '/cart', '/profile', '/checkout', '/admin'];
                    if (protectedPages.some(p => window.location.pathname.includes(p))) {
                        window.location.replace('{{ route("login") }}');
                    }
                }
            @endauth
            
            // Guardar estado de autenticacion
            @auth
                sessionStorage.setItem('rayonic_auth', 'true');
            @endauth
            
            // Guardar tiempo de logout cuando se cierra sesion
            document.addEventListener('click', function(e) {
                const logoutBtn = e.target.closest('#logout-form button, form[action*="logout"] button');
                if (logoutBtn) {
                    sessionStorage.setItem('rayonic_logout_time', Date.now().toString());
                }
            });
        })();
    </script>

    {{-- ===================================================== --}}
    {{-- 🔥 PREVENIR PAGO DESPUÉS DE LOGOUT (FLECHA ATRÁS) --}}
    {{-- ===================================================== --}}
    <script>
        // Verificar cada vez que la página se carga (incluyendo cuando viene de caché)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                checkSessionAndRedirect();
            }
        });
        
        // Verificar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            checkSessionAndRedirect();
        });
        
        function checkSessionAndRedirect() {
            const isCheckoutPage = window.location.pathname.includes('/checkout');
            const isSuccessPage = window.location.pathname.includes('/checkout/success');
            
            if (isCheckoutPage || isSuccessPage) {
                fetch('/session/check', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.authenticated) {
                        showSessionExpiredMessage();
                        setTimeout(() => {
                            window.location.href = '/login';
                        }, 2000);
                    }
                })
                .catch(() => {
                    showSessionExpiredMessage();
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 2000);
                });
            }
        }
        
        function showSessionExpiredMessage() {
            const message = document.createElement('div');
            message.style.cssText = `
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: linear-gradient(135deg, #dc2626, #ef4444);
                color: white;
                padding: 25px 40px;
                border-radius: 16px;
                z-index: 100000;
                text-align: center;
                font-family: 'Orbitron', sans-serif;
                box-shadow: 0 10px 30px rgba(0,0,0,0.5);
                animation: fadeIn 0.3s ease-out;
            `;
            message.innerHTML = `
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                <h3>Sesión Expirada</h3>
                <p>Tu sesión ha expirado. Serás redirigido al inicio de sesión.</p>
                <div class="spinner-border mt-3" role="status"></div>
            `;
            document.body.appendChild(message);
            
            setTimeout(() => {
                if (message && message.parentNode) message.remove();
            }, 2000);
        }
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }
    </style>

</body>
</html>