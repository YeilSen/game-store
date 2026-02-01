<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --cyber-cyan: #22d3ee;
            --cyber-purple: #a855f7;
            --cyber-indigo: #6366f1;
            --dark-bg: #0a0a14;
        }
        
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
            padding: 20px;
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
        
        /* Glow effects */
        .glow-effect {
            position: fixed;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
            z-index: -1;
            pointer-events: none;
        }
        
        .glow-cyan {
            background: radial-gradient(circle, rgba(34, 211, 238, 0.7) 0%, transparent 70%);
            top: 20%;
            left: 15%;
            animation: float 8s ease-in-out infinite;
        }
        
        .glow-purple {
            background: radial-gradient(circle, rgba(168, 85, 247, 0.7) 0%, transparent 70%);
            bottom: 20%;
            right: 15%;
            animation: float 10s ease-in-out infinite reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
        
        /* Card container */
        .login-card {
            background: rgba(10, 10, 20, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(99, 102, 241, 0.2);
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
        }
        
        .login-card::before {
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
        }
        
        .login-card::after {
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
        
        /* Header */
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-icon {
            font-size: 3.5rem;
            background: linear-gradient(45deg, #22d3ee, #a855f7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 15px;
            display: block;
        }
        
        .login-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.8rem;
            background: linear-gradient(45deg, #22d3ee, #a855f7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 900;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        
        .login-subtitle {
            color: #94a3b8;
            font-size: 0.9rem;
        }
        
        /* Error messages */
        .error-container {
            margin-bottom: 25px;
        }
        
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
            color: #fca5a5;
            font-size: 0.9rem;
            animation: slideIn 0.3s ease-out;
        }
        
        .ban-message {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-left: 4px solid #ef4444;
            color: #fecaca;
            padding: 15px;
            border-radius: 12px;
        }
        
        .ban-title {
            color: #f87171;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .unlock-time {
            background: rgba(239, 68, 68, 0.2);
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
            text-align: center;
            font-weight: 700;
            color: #fca5a5;
            border: 1px dashed rgba(239, 68, 68, 0.4);
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Form elements */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            color: #cbd5e1;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        
        .form-input {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 12px;
            padding: 14px 16px;
            color: #e2e8f0;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: rgba(34, 211, 238, 0.6);
            box-shadow: 
                0 0 0 3px rgba(34, 211, 238, 0.1),
                inset 0 0 10px rgba(34, 211, 238, 0.1);
        }
        
        .form-input::placeholder {
            color: #64748b;
        }
        
        /* Options row */
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .remember-checkbox {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 2px solid rgba(99, 102, 241, 0.5);
            background: rgba(15, 23, 42, 0.6);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .remember-checkbox:checked {
            background: linear-gradient(45deg, #22d3ee, #6366f1);
            border-color: transparent;
        }
        
        .remember-label {
            color: #cbd5e1;
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .forgot-password {
            color: #22d3ee;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .forgot-password:hover {
            color: #67e8f9;
            text-decoration: none;
        }
        
        .forgot-password::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: linear-gradient(90deg, #22d3ee, #a855f7);
            transition: width 0.3s ease;
        }
        
        .forgot-password:hover::after {
            width: 100%;
        }
        
        /* Submit button */
        .submit-btn {
            width: 100%;
            background: linear-gradient(45deg, #22d3ee, #6366f1, #a855f7);
            background-size: 200% 200%;
            border: none;
            border-radius: 12px;
            padding: 16px;
            color: #0f172a;
            font-family: 'Orbitron', sans-serif;
            font-weight: 900;
            font-size: 1rem;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: gradientShift 3s ease infinite;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 10px 25px rgba(34, 211, 238, 0.3),
                0 0 20px rgba(139, 92, 246, 0.3);
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
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
            opacity: 0;
        }
        
        .submit-btn:hover::after {
            left: 140%;
            opacity: 1;
        }
        
        /* Register link */
        .register-section {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(99, 102, 241, 0.2);
        }
        
        .register-text {
            color: #94a3b8;
            font-size: 0.9rem;
        }
        
        .register-link {
            color: #a855f7;
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .register-link:hover {
            color: #d8b4fe;
        }
        
        .register-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: linear-gradient(90deg, #a855f7, #22d3ee);
            transition: width 0.3s ease;
        }
        
        .register-link:hover::after {
            width: 100%;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            body {
                padding: 15px;
            }
            
            .login-card {
                padding: 30px 25px;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
            
            .options-row {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .forgot-password {
                align-self: flex-start;
            }
        }
    </style>
</head>
<body>
    {{-- Glow effects --}}
    <div class="glow-effect glow-cyan"></div>
    <div class="glow-effect glow-purple"></div>
    
    <div class="login-card">
        {{-- Header --}}
        <div class="login-header">
            <i class="bi bi-joystick login-icon"></i>
            <h1 class="login-title">INICIAR SESIÓN</h1>
            <p class="login-subtitle">Accede a tu cuenta gamer</p>
        </div>
        
        {{-- Error messages --}}
        @if ($errors->any())
            <div class="error-container">
                @foreach ($errors->all() as $error)
                    @if (str_contains($error, 'intentos de inicio de sesión') || str_contains($error, 'demasiados intentos'))
                        <div class="ban-message">
                            <div class="ban-title">
                                <i class="bi bi-shield-x"></i>
                                🚫 ACCESO RESTRINGIDO
                            </div>
                            <p>{{ $error }}</p>
                            @php
                                $throttleKey = request()->input('email') . '|' . request()->ip();
                                $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
                                $unlockTime = $seconds > 0 ? now()->addSeconds($seconds) : null;
                            @endphp
                            @if ($unlockTime)
                                <div class="unlock-time">
                                    <i class="bi bi-clock"></i>
                                    Desbloqueo: {{ $unlockTime->format('H:i:s') }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="error-message">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            {{ $error }}
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        {{-- Login form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email field --}}
            <div class="form-group">
                <label for="email" class="form-label">CORREO ELECTRÓNICO</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                       placeholder="jugador@ejemplo.com"
                       class="form-input">
            </div>

            {{-- Password field --}}
            <div class="form-group">
                <label for="password" class="form-label">CONTRASEÑA</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="form-input">
            </div>

            {{-- Options --}}
            <div class="options-row">
                <label class="remember-me">
                    <input id="remember_me" name="remember" type="checkbox" class="remember-checkbox">
                    <span class="remember-label">Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        ¿Olvidaste la contraseña?
                    </a>
                @endif
            </div>

            {{-- Submit button --}}
            <button type="submit" class="submit-btn">
                <i class="bi bi-box-arrow-in-right"></i> INGRESAR
            </button>
        </form>

        {{-- Register link --}}
        @if (Route::has('register'))
            <div class="register-section">
                <span class="register-text">¿No tienes cuenta?</span>
                <a class="register-link" href="{{ route('register') }}">
                    Regístrate aquí
                </a>
            </div>
        @endif
    </div>

    <script>
        // Add ripple effect to button
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.querySelector('.submit-btn');
            
            submitBtn.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const ripple = document.createElement('span');
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.4);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                    width: 100px;
                    height: 100px;
                    top: ${y - 50}px;
                    left: ${x - 50}px;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
            
            // Add CSS for ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
            
            // Focus effect for inputs
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>