<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rayonic | Tienda de Juegos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

        body {
            font-family:'Inter',sans-serif;
            background: radial-gradient(circle at 20% 50%, rgba(56,189,248,0.1), transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(139,92,246,0.1), transparent 50%),
                        linear-gradient(to bottom, var(--darker-bg), var(--dark-bg));
            min-height:100vh;
        }

        .navbar {
            background: rgba(10,10,20,0.9)!important;
            backdrop-filter: blur(10px);
            border-bottom:1px solid rgba(99,102,241,0.2);
        }

        .navbar-brand {
            font-family:'Orbitron',sans-serif;
            font-weight:900;
            background: linear-gradient(45deg,var(--cyber-cyan),var(--cyber-purple));
            -webkit-background-clip:text;
            color:transparent;
        }

        .nav-link {
            color:#e2e8f0!important;
        }

        .nav-link:hover {
            color:white!important;
            background: rgba(99,102,241,0.2);
            border-radius:8px;
        }

        .clock {
            background: rgba(15,23,42,0.8);
            border:1px solid rgba(34,211,238,0.3);
            border-radius:8px;
            padding:6px 12px;
            color:#22d3ee;
            font-family:'Orbitron';
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ url('/') }}">
            🎮 Rayonic
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse show" id="navbarNav">

            <!-- IZQUIERDA -->
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('catalog') }}">
                        <i class="bi bi-grid"></i> Catálogo
                    </a>
                </li>

                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.index') }}">
                        <i class="bi bi-cart3"></i> Carrito
                        @if(session('cart'))
                            <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                </li>

                <!-- 🔥 BOTÓN MIS COMPRAS -->
                <li class="nav-item">
                    <a class="nav-link text-warning" href="{{ route('orders.index') }}">
                        <i class="bi bi-bag-check"></i> Mis compras
                    </a>
                </li>

                @if(Auth::user()->is_admin)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-warning" data-bs-toggle="dropdown">
                        <i class="bi bi-shield-check"></i> Admin
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Usuarios</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.bans.index') }}">Baneos</a></li>
                    </ul>
                </li>
                @endif
                @endauth

            </ul>

            <!-- DERECHA -->
            <div class="d-flex align-items-center gap-3">

                <a href="{{ route('dashboard') }}" class="btn btn-outline-info btn-sm">
                    <i class="bi bi-house"></i> Inicio
                </a>

                <div class="clock">
                    <i class="bi bi-clock"></i>
                    <span id="clockTime">--:--:--</span>
                    <small id="clockDate"></small>
                </div>

                <ul class="navbar-nav">

                   @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Registro
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item">Cerrar sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest

                </ul>

            </div>

        </div>
    </div>
</nav>

<main class="py-4">
    @yield('content')
</main>

<script>
function updateClock(){
    const now = new Date();
    document.getElementById('clockTime').textContent = now.toLocaleTimeString();
    document.getElementById('clockDate').textContent = now.toLocaleDateString();
}
setInterval(updateClock,1000);
updateClock();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>