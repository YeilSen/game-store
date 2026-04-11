@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="
                background: rgba(15, 23, 42, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(99, 102, 241, 0.2);
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            ">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-cookie" style="font-size: 3rem; color: #22d3ee;"></i>
                        <h1 class="gaming-font mt-3" style="
                            background: linear-gradient(45deg, #22d3ee, #a855f7);
                            -webkit-background-clip: text;
                            background-clip: text;
                            color: transparent;
                        ">
                            Política de Cookies
                        </h1>
                    </div>
                    
                    <div class="text-light" style="line-height: 1.8;">
                        <h4 class="text-cyan-400">¿Qué son las cookies?</h4>
                        <p>Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas nuestro sitio web. Nos ayudan a recordar tus preferencias y mejorar tu experiencia de navegación.</p>
                        
                        <h4 class="text-purple-400 mt-4">Tipos de cookies que utilizamos</h4>
                        <ul>
                            <li><strong>🍪 Cookies esenciales:</strong> Necesarias para el funcionamiento básico del sitio (inicio de sesión, carrito de compras).</li>
                            <li><strong>📊 Cookies de análisis:</strong> Nos ayudan a entender cómo usas nuestro sitio para mejorarlo.</li>
                            <li><strong>⚙️ Cookies de preferencias:</strong> Guardan tus preferencias de navegación y configuración.</li>
                        </ul>
                        
                        <h4 class="text-cyan-400 mt-4">¿Cómo gestionar las cookies?</h4>
                        <p>Puedes aceptar o rechazar las cookies no esenciales mediante el aviso que aparece al ingresar al sitio. También puedes configurar tu navegador para bloquearlas.</p>
                        
                        <h4 class="text-purple-400 mt-4">Cookies de terceros</h4>
                        <p>Utilizamos servicios como Google Analytics para mejorar nuestro servicio. Estas empresas pueden utilizar cookies propias.</p>
                        
                        <div class="alert mt-4" style="background: rgba(34, 211, 238, 0.1); border: 1px solid rgba(34, 211, 238, 0.3);">
                            <i class="bi bi-info-circle me-2"></i>
                            Al usar nuestro sitio, aceptas el uso de cookies esenciales para su correcto funcionamiento.
                        </div>
                    </div>
                    
                    <div class="text-center mt-5">
                        <a href="{{ url('/') }}" class="btn" style="
                            background: linear-gradient(45deg, #22d3ee, #6366f1);
                            border: none;
                            color: #0f172a;
                            font-weight: 600;
                            padding: 12px 30px;
                            border-radius: 12px;
                        ">
                            <i class="bi bi-arrow-left me-2"></i> Volver al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection