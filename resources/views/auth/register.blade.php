<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Jugador | Universo Gaming</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: 
                radial-gradient(circle at 20% 50%, rgba(56, 189, 248, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                linear-gradient(to bottom right, #000000, #0f172a, #1e1b4b);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 20px;
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
        
        .glow-effect {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            z-index: -1;
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
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(34, 211, 238, 0.5), 0 0 40px rgba(139, 92, 246, 0.3); }
            50% { box-shadow: 0 0 30px rgba(34, 211, 238, 0.7), 0 0 60px rgba(139, 92, 246, 0.5); }
        }
        
        .gaming-font {
            font-family: 'Orbitron', sans-serif;
        }
        
        .card {
            background: rgba(10, 10, 20, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 20px;
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.6),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            z-index: 1;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }
        
        .card::before {
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
        
        .card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            padding: 1px;
            background: linear-gradient(45deg, 
                rgba(34, 211, 238, 0.3), 
                rgba(139, 92, 246, 0.3), 
                rgba(99, 102, 241, 0.3)
            );
            mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            mask-composite: exclude;
            pointer-events: none;
        }
        
        .input-field {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 15px;
            padding: 14px 16px;
            color: #f1f5f9;
            width: 100%;
        }
        
        .input-field::placeholder {
            color: #64748b;
            opacity: 0.7;
        }
        
        .input-field:focus {
            outline: none;
            border-color: rgba(34, 211, 238, 0.8);
            box-shadow: 
                0 0 0 3px rgba(34, 211, 238, 0.15),
                inset 0 0 10px rgba(34, 211, 238, 0.1);
            transform: translateY(-1px);
        }
        
        .input-field.email-field:focus {
            border-color: rgba(34, 211, 238, 0.8);
            box-shadow: 
                0 0 0 3px rgba(34, 211, 238, 0.15),
                inset 0 0 10px rgba(34, 211, 238, 0.1);
        }
        
        .input-field.password-field:focus {
            border-color: rgba(168, 85, 247, 0.8);
            box-shadow: 
                0 0 0 3px rgba(168, 85, 247, 0.15),
                inset 0 0 10px rgba(168, 85, 247, 0.1);
        }
        
        .input-field.confirm-field:focus {
            border-color: rgba(99, 102, 241, 0.8);
            box-shadow: 
                0 0 0 3px rgba(99, 102, 241, 0.15),
                inset 0 0 10px rgba(99, 102, 241, 0.1);
        }
        
        .label {
            display: block;
            font-weight: 600;
            letter-spacing: 2px;
            font-size: 12px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        
        .email-label {
            color: #22d3ee;
            text-shadow: 0 0 10px rgba(34, 211, 238, 0.5);
        }
        
        .password-label {
            color: #a855f7;
            text-shadow: 0 0 10px rgba(168, 85, 247, 0.5);
        }
        
        .confirm-label {
            color: #8b5cf6;
            text-shadow: 0 0 10px rgba(139, 92, 246, 0.5);
        }
        
        .name-label {
            color: #06b6d4;
            text-shadow: 0 0 10px rgba(6, 182, 212, 0.5);
        }
        
        .submit-btn {
            background: linear-gradient(45deg, 
                #22d3ee, 
                #8b5cf6, 
                #6366f1
            );
            background-size: 200% 200%;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            letter-spacing: 2px;
            padding: 16px;
            color: #0f172a;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-family: 'Orbitron', sans-serif;
            width: 100%;
            animation: pulse-glow 3s ease-in-out infinite, gradient-shift 3s ease infinite;
            font-size: 16px;
            margin-top: 10px;
        }
        
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 10px 25px rgba(34, 211, 238, 0.4),
                0 0 30px rgba(139, 92, 246, 0.4);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        .submit-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 20%;
            height: 200%;
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(30deg);
            transition: all 0.5s ease;
        }
        
        .submit-btn:hover::after {
            left: 140%;
        }
        
        .login-link {
            color: #67e8f9;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
            font-size: 14px;
        }
        
        .login-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: linear-gradient(90deg, #22d3ee, #8b5cf6);
            transition: width 0.3s ease;
        }
        
        .login-link:hover {
            color: #a5f3fc;
        }
        
        .login-link:hover::after {
            width: 100%;
        }
        
        .title {
            background: linear-gradient(45deg, 
                #22d3ee, 
                #8b5cf6, 
                #6366f1
            );
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 900;
            letter-spacing: 3px;
            position: relative;
            margin-bottom: 8px;
            text-align: center;
            font-size: 32px;
        }
        
        .title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, 
                transparent, 
                #22d3ee, 
                #8b5cf6, 
                transparent
            );
            border-radius: 2px;
        }
        
        .subtitle {
            color: #cbd5e1;
            font-size: 14px;
            letter-spacing: 1px;
            margin-bottom: 32px;
            text-align: center;
        }
        
        .password-hint {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .password-hint::before {
            content: 'ⓘ';
            font-size: 10px;
        }
        
        .form-container {
            padding: 40px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 24px;
            text-align: left;
        }
        
        .form-divider {
            height: 1px;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(99, 102, 241, 0.3), 
                transparent
            );
            margin: 30px 0;
        }
        
        .footer-text {
            color: #64748b;
            font-size: 12px;
            margin-top: 20px;
            text-align: center;
        }
        
        .terms-text {
            color: #94a3b8;
            font-size: 11px;
            margin-top: 15px;
            line-height: 1.4;
            text-align: center;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: left;
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fecaca;
        }
        
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #bbf7d0;
        }
        
        @media (max-width: 480px) {
            .card {
                max-width: 100%;
            }
            
            .form-container {
                padding: 30px 25px;
            }
            
            .title {
                font-size: 28px;
            }
            
            .submit-btn {
                padding: 14px;
            }
        }
    </style>
</head>

<body>
    <!-- Efectos de fondo -->
    <div class="glow-effect glow-cyan"></div>
    <div class="glow-effect glow-purple"></div>
    
    <div class="card">
        <div class="form-container">
            <h2 class="title gaming-font">
                REGISTRO DE JUGADOR
            </h2>
            
            <p class="subtitle">
                Únete al universo gaming
            </p>
            
            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Error:</strong>
                    <ul class="mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Nombre -->
                <div class="form-group">
                    <label class="label name-label gaming-font">
                        NOMBRE DE JUGADOR
                    </label>
                    <input type="text" name="name" 
                        class="input-field email-field"
                        placeholder="Tu nombre o apodo"
                        required autofocus
                        value="{{ old('name') }}">
                </div>
                
                <!-- Email -->
                <div class="form-group">
                    <label class="label email-label gaming-font">
                        CORREO ELECTRÓNICO
                    </label>
                    <input type="email" name="email" 
                        class="input-field email-field"
                        placeholder="jugador@ejemplo.com"
                        required
                        value="{{ old('email') }}">
                </div>
                
                <!-- Contraseña -->
                <div class="form-group">
                    <div class="flex justify-between items-center">
                        <label class="label password-label gaming-font">
                            CONTRASEÑA
                        </label>
                    </div>
                    <input type="password" name="password" 
                        class="input-field password-field"
                        required
                        placeholder="Mínimo 8 caracteres">
                    <div class="password-hint">
                        Mínimo 8 caracteres con letras y números
                    </div>
                </div>
                
                <!-- Confirmar Contraseña -->
                <div class="form-group">
                    <label class="label confirm-label gaming-font">
                        CONFIRMAR CONTRASEÑA
                    </label>
                    <input type="password" name="password_confirmation" 
                        class="input-field confirm-field"
                        required
                        placeholder="Repite tu contraseña">
                </div>
                
                <button type="submit"
                    class="submit-btn gaming-font">
                    CREAR CUENTA
                </button>
                
                <div class="form-divider"></div>
                
                <div class="login-section">
                    <a href="{{ route('login') }}"
                       class="login-link">
                        ¿Ya tienes cuenta? Inicia sesión aquí
                    </a>
                </div>
                
                <div class="terms-text">
                    Al registrarte, aceptas nuestros <a href="#" class="text-cyan-400 hover:text-cyan-300">Términos de Servicio</a> y <a href="#" class="text-purple-400 hover:text-purple-300">Política de Privacidad</a>
                </div>
            </form>
            
            <div class="footer-text">
                © 2024 Universo Gaming. Todos los derechos reservados.
            </div>
        </div>
    </div>
    
    <script>
        // Validación del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = document.querySelector('input[name="name"]').value.trim();
            const email = document.querySelector('input[name="email"]').value.trim();
            const password = document.querySelector('input[name="password"]').value;
            const confirm = document.querySelector('input[name="password_confirmation"]').value;
            
            // Validar nombre
            if (name.length < 2) {
                e.preventDefault();
                alert('El nombre debe tener al menos 2 caracteres');
                return false;
            }
            
            // Validar email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Por favor ingresa un email válido');
                return false;
            }
            
            // Validar contraseña
            if (password.length < 8) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 8 caracteres');
                return false;
            }
            
            // Validar que coincidan
            if (password !== confirm) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return false;
            }
            
            // Mostrar loading en el botón
            const btn = document.querySelector('.submit-btn');
            btn.disabled = true;
            btn.innerHTML = 'CREANDO CUENTA...';
            
            return true;
        });
    </script>
</body>
</html>