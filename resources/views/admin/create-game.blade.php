@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                    🎮 SUBIR NUEVO JUEGO 🎮
                </h1>
                <p class="text-light" style="opacity: 0.8; font-size: 1rem;">
                    Añade un nuevo título al catálogo gaming
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
            
            @if ($errors->any())
                <div class="alert mb-4" style="
                    background: linear-gradient(135deg, rgba(239, 68, 68, 0.9), rgba(185, 28, 28, 0.9));
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(239, 68, 68, 0.3);
                    border-left: 4px solid #ef4444;
                    color: white;
                    box-shadow: 0 5px 15px rgba(239, 68, 68, 0.2);
                    border-radius: 12px;
                    padding: 15px;
                ">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                        <div>
                            <strong>Por favor, corrige los siguientes errores:</strong>
                            <ul class="mb-0 mt-2 ps-3" style="opacity: 0.9;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Card del formulario --}}
            <div class="card" style="
                background: rgba(15, 23, 42, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(99, 102, 241, 0.2);
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                overflow: hidden;
            ">
                <div class="card-body p-4">
                    {{-- El enctype="multipart/form-data" es crucial para subir archivos --}}
                    <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data" id="gameForm">
                        @csrf
                        
                        {{-- Campo Nombre --}}
                        <div class="mb-4">
                            <label for="name" class="form-label" style="
                                color: #22d3ee;
                                font-weight: 600;
                                font-size: 0.9rem;
                                letter-spacing: 0.5px;
                                margin-bottom: 8px;
                                display: block;
                            ">
                                <i class="bi bi-controller me-1"></i> NOMBRE DEL JUEGO
                            </label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}" style="
                                background: rgba(15, 23, 42, 0.6);
                                border: 1px solid rgba(99, 102, 241, 0.2);
                                border-radius: 12px;
                                padding: 14px;
                                color: #e2e8f0;
                                font-size: 1rem;
                                transition: all 0.3s ease;
                            ">
                        </div>

                        {{-- Campo Descripción --}}
                        <div class="mb-4">
                            <label for="description" class="form-label" style="
                                color: #a855f7;
                                font-weight: 600;
                                font-size: 0.9rem;
                                letter-spacing: 0.5px;
                                margin-bottom: 8px;
                                display: block;
                            ">
                                <i class="bi bi-card-text me-1"></i> DESCRIPCIÓN
                            </label>
                            <textarea class="form-control" id="description" name="description" rows="4" required style="
                                background: rgba(15, 23, 42, 0.6);
                                border: 1px solid rgba(99, 102, 241, 0.2);
                                border-radius: 12px;
                                padding: 14px;
                                color: #e2e8f0;
                                font-size: 1rem;
                                transition: all 0.3s ease;
                                resize: vertical;
                            ">{{ old('description') }}</textarea>
                        </div>

                        {{-- Campo Precio --}}
                        <div class="mb-4">
                            <label for="price" class="form-label" style="
                                color: #6366f1;
                                font-weight: 600;
                                font-size: 0.9rem;
                                letter-spacing: 0.5px;
                                margin-bottom: 8px;
                                display: block;
                            ">
                                <i class="bi bi-currency-dollar me-1"></i> PRECIO ($)
                            </label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required value="{{ old('price') }}" style="
                                background: rgba(15, 23, 42, 0.6);
                                border: 1px solid rgba(99, 102, 241, 0.2);
                                border-radius: 12px;
                                padding: 14px;
                                color: #e2e8f0;
                                font-size: 1rem;
                                transition: all 0.3s ease;
                            ">
                        </div>

                        {{-- Campo Categoría --}}
                        <div class="mb-4">
                            <label for="category" class="form-label" style="
                                color: #22d3ee;
                                font-weight: 600;
                                font-size: 0.9rem;
                                letter-spacing: 0.5px;
                                margin-bottom: 8px;
                                display: block;
                            ">
                                <i class="bi bi-tag me-1"></i> CATEGORÍA
                            </label>
                            <select name="category" id="category" class="form-control" style="
                                background: rgba(15, 23, 42, 0.6);
                                border: 1px solid rgba(99, 102, 241, 0.2);
                                border-radius: 12px;
                                padding: 14px;
                                color: #e2e8f0;
                                font-size: 1rem;
                                transition: all 0.3s ease;
                            ">
                                <option value="" style="background: #1e293b;">Seleccionar categoría</option>
                                <option value="Acción" style="background: #1e293b;" {{ old('category') == 'Acción' ? 'selected' : '' }}>Acción</option>
                                <option value="Aventura" style="background: #1e293b;" {{ old('category') == 'Aventura' ? 'selected' : '' }}>Aventura</option>
                                <option value="Deportes" style="background: #1e293b;" {{ old('category') == 'Deportes' ? 'selected' : '' }}>Deportes</option>
                                <option value="Estrategia" style="background: #1e293b;" {{ old('category') == 'Estrategia' ? 'selected' : '' }}>Estrategia</option>
                                <option value="RPG" style="background: #1e293b;" {{ old('category') == 'RPG' ? 'selected' : '' }}>RPG</option>
                                <option value="Carreras" style="background: #1e293b;" {{ old('category') == 'Carreras' ? 'selected' : '' }}>Carreras</option>
                            </select>
                        </div>

                        {{-- Campo Estado --}}
                        <div class="mb-4">
                            <label for="status" class="form-label" style="
                                color: #a855f7;
                                font-weight: 600;
                                font-size: 0.9rem;
                                letter-spacing: 0.5px;
                                margin-bottom: 8px;
                                display: block;
                            ">
                                <i class="bi bi-circle-square me-1"></i> ESTADO DEL JUEGO
                            </label>
                            <select name="status" id="status" class="form-control" style="
                                background: rgba(15, 23, 42, 0.6);
                                border: 1px solid rgba(99, 102, 241, 0.2);
                                border-radius: 12px;
                                padding: 14px;
                                color: #e2e8f0;
                                font-size: 1rem;
                                transition: all 0.3s ease;
                            ">
                                <option value="available" style="background: #1e293b;" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Disponible</option>
                                <option value="out_of_stock" style="background: #1e293b;" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Agotado</option>
                                <option value="discontinued" style="background: #1e293b;" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Descontinuado</option>
                            </select>
                            <div class="form-text mt-2" style="color: #94a3b8; font-size: 0.85rem;">
                                <i class="bi bi-info-circle me-1"></i> Define si el juego está disponible para compra
                            </div>
                        </div>

                        {{-- Campo Descuento --}}
                        <div class="mb-4">
                            <label for="discount_percent" class="form-label" style="
                                color: #6366f1;
                                font-weight: 600;
                                font-size: 0.9rem;
                                letter-spacing: 0.5px;
                                margin-bottom: 8px;
                                display: block;
                            ">
                                <i class="bi bi-percent me-1"></i> DESCUENTO (%)
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="discount_percent" name="discount_percent" 
                                       min="0" max="100" value="{{ old('discount_percent', 0) }}" style="
                                    background: rgba(15, 23, 42, 0.6);
                                    border: 1px solid rgba(99, 102, 241, 0.2);
                                    border-radius: 12px 0 0 12px;
                                    padding: 14px;
                                    color: #e2e8f0;
                                    font-size: 1rem;
                                    transition: all 0.3s ease;
                                ">
                                <span class="input-group-text" style="
                                    background: rgba(15, 23, 42, 0.6);
                                    border: 1px solid rgba(99, 102, 241, 0.2);
                                    border-left: none;
                                    border-radius: 0 12px 12px 0;
                                    color: #22d3ee;
                                    font-weight: 600;
                                ">%</span>
                            </div>
                            <div class="form-text mt-2" style="color: #94a3b8; font-size: 0.85rem;">
                                <i class="bi bi-info-circle me-1"></i> Ingresa 0 si no tiene descuento. El precio final se calculará automáticamente.
                            </div>
                            
                            {{-- Vista previa del precio con descuento --}}
                            <div id="discountPreview" class="mt-3 p-3 rounded" style="
                                background: rgba(34, 211, 238, 0.1);
                                border: 1px solid rgba(34, 211, 238, 0.3);
                                display: none;
                            ">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="color: #e2e8f0;">Precio original:</span>
                                    <span id="originalPriceDisplay" style="color: #94a3b8; text-decoration: line-through;">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span style="color: #e2e8f0; font-weight: 600;">Precio final:</span>
                                    <span id="finalPriceDisplay" style="color: #22d3ee; font-weight: 900; font-size: 1.2rem;">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span style="color: #e2e8f0;">Ahorras:</span>
                                    <span id="savingsDisplay" style="color: #22c55e; font-weight: 600;">$0.00</span>
                                </div>
                            </div>
                        </div>

                        {{-- Campo Imagen --}}
                        <div class="mb-4">
                            <label for="image" class="form-label" style="
                                color: #22d3ee;
                                font-weight: 600;
                                font-size: 0.9rem;
                                letter-spacing: 0.5px;
                                margin-bottom: 8px;
                                display: block;
                            ">
                                <i class="bi bi-image me-1"></i> IMAGEN DEL JUEGO
                            </label>
                            <input type="file" class="form-control" id="image" name="image" required accept="image/*" style="
                                background: rgba(15, 23, 42, 0.6);
                                border: 1px solid rgba(99, 102, 241, 0.2);
                                border-radius: 12px;
                                padding: 14px;
                                color: #e2e8f0;
                                font-size: 1rem;
                                transition: all 0.3s ease;
                            ">
                            <div class="form-text mt-2" style="color: #94a3b8; font-size: 0.85rem;">
                                <i class="bi bi-info-circle me-1"></i> Sube una imagen JPG, PNG o GIF. Tamaño máximo: 5MB.
                            </div>
                            
                            {{-- Vista previa de imagen --}}
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <div class="border rounded-lg p-3" style="
                                    border-color: rgba(99, 102, 241, 0.3) !important;
                                    background: rgba(15, 23, 42, 0.4);
                                ">
                                    <p class="text-sm mb-2" style="color: #cbd5e1;">
                                        <i class="bi bi-eye me-1"></i> Vista previa:
                                    </p>
                                    <img id="previewImage" class="rounded-lg" style="
                                        max-width: 200px;
                                        max-height: 150px;
                                        object-fit: cover;
                                        border: 1px solid rgba(99, 102, 241, 0.2);
                                    ">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 mt-3 gaming-font" id="submitBtn" style="
                            background: linear-gradient(45deg, #22d3ee, #6366f1, #a855f7);
                            background-size: 200% 200%;
                            border: none;
                            border-radius: 12px;
                            padding: 16px;
                            color: #0f172a;
                            font-weight: 900;
                            letter-spacing: 1px;
                            transition: all 0.3s ease;
                            position: relative;
                            overflow: hidden;
                            animation: gradientShift 3s ease infinite;
                            cursor: pointer;
                        ">
                            <i class="bi bi-upload me-2"></i> SUBIR JUEGO
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animaciones y efectos */
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    /* Efectos para inputs y textareas */
    .form-control:focus,
    select.form-control:focus {
        outline: none;
        border-color: rgba(34, 211, 238, 0.6) !important;
        box-shadow: 
            0 0 0 3px rgba(34, 211, 238, 0.1),
            inset 0 0 10px rgba(34, 211, 238, 0.1) !important;
        transform: translateY(-1px);
    }
    
    /* Estilo para selects */
    select.form-control option {
        background-color: #1e293b;
        color: #e2e8f0;
    }
    
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
    
    /* Efecto de brillo en botón submit */
    .btn[type="submit"]:hover {
        box-shadow: 
            0 10px 25px rgba(34, 211, 238, 0.4),
            0 0 20px rgba(139, 92, 246, 0.3) !important;
    }
    
    .btn[type="submit"]::after {
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
    
    .btn[type="submit"]:hover::after {
        left: 140%;
        opacity: 1;
    }
    
    /* Efecto para botón de volver */
    a.btn:hover {
        background: rgba(99, 102, 241, 0.2) !important;
        border-color: rgba(34, 211, 238, 0.7) !important;
        color: #67e8f9 !important;
        transform: translateX(-3px);
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
    
    .col-md-8 {
        animation: fadeIn 0.6s ease-out;
    }
    
    /* Scrollbar personalizada */
    textarea::-webkit-scrollbar {
        width: 8px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: rgba(15, 23, 42, 0.3);
        border-radius: 4px;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: linear-gradient(45deg, #22d3ee, #6366f1);
        border-radius: 4px;
    }
    
    /* Input group */
    .input-group-text {
        background: rgba(15, 23, 42, 0.6) !important;
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
            padding: 12px !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Vista previa de imagen
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        
        if (imageInput) {
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        if (previewImage) previewImage.src = e.target.result;
                        if (imagePreview) imagePreview.style.display = 'block';
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        // =====================================================
        // 🔥 Calculadora de descuentos en tiempo real
        // =====================================================
        const priceInput = document.getElementById('price');
        const discountInput = document.getElementById('discount_percent');
        const discountPreview = document.getElementById('discountPreview');
        const originalPriceDisplay = document.getElementById('originalPriceDisplay');
        const finalPriceDisplay = document.getElementById('finalPriceDisplay');
        const savingsDisplay = document.getElementById('savingsDisplay');
        
        if (priceInput && discountInput) {
            function calculateDiscount() {
                const price = parseFloat(priceInput.value) || 0;
                const discount = parseInt(discountInput.value) || 0;
                
                if (price > 0) {
                    const discountedPrice = price - (price * discount / 100);
                    const savings = price - discountedPrice;
                    
                    if (originalPriceDisplay) originalPriceDisplay.textContent = '$' + price.toFixed(2);
                    if (finalPriceDisplay) finalPriceDisplay.textContent = '$' + discountedPrice.toFixed(2);
                    if (savingsDisplay) savingsDisplay.textContent = '$' + savings.toFixed(2);
                    
                    if (discountPreview) discountPreview.style.display = 'block';
                } else {
                    if (discountPreview) discountPreview.style.display = 'none';
                }
            }
            
            priceInput.addEventListener('input', calculateDiscount);
            discountInput.addEventListener('input', calculateDiscount);
            
            // Calcular al cargar si hay valores
            calculateDiscount();
        }
        
        // =====================================================
        // 🔥 PROTECCIÓN CONTRA DOBLE CLIC - VERSIÓN CORREGIDA
        // =====================================================
        const form = document.getElementById('gameForm');
        const submitBtn = document.getElementById('submitBtn');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                console.log('Formulario enviado'); // Para debug
                
                // Validar precio positivo
                if (priceInput) {
                    const price = parseFloat(priceInput.value);
                    if (price <= 0) {
                        e.preventDefault();
                        alert('El precio debe ser mayor a 0');
                        return false;
                    }
                }
                
                // Validar descuento
                if (discountInput) {
                    const discount = parseInt(discountInput.value) || 0;
                    if (discount < 0 || discount > 100) {
                        e.preventDefault();
                        alert('El descuento debe estar entre 0 y 100');
                        return false;
                    }
                }
                
                // Validar categoría
                const category = document.getElementById('category');
                if (category && !category.value) {
                    if (!confirm('¿No quieres seleccionar una categoría? Puedes continuar, pero es recomendable categorizar los juegos.')) {
                        e.preventDefault();
                        return false;
                    }
                }
                
                // Validar tamaño de imagen
                if (imageInput && imageInput.files[0]) {
                    if (imageInput.files[0].size > 5 * 1024 * 1024) {
                        e.preventDefault();
                        alert('La imagen no debe exceder los 5MB');
                        return false;
                    }
                }
                
                // 🔥 CORRECCIÓN: Deshabilitar después de TODAS las validaciones
                // Usar setTimeout para asegurar que el formulario se envíe
                setTimeout(function() {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> SUBIENDO...';
                    submitBtn.style.opacity = '0.8';
                    submitBtn.style.cursor = 'not-allowed';
                }, 100);
                
                return true; // PERMITIR EL ENVÍO
            });
        }
        
        // =====================================================
        // 🔥 Efectos visuales
        // =====================================================
        
        // Efecto focus en inputs
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-1px)';
            });
            
            input.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Efecto ripple para botón submit (solo si no está deshabilitado)
        if (submitBtn) {
            submitBtn.addEventListener('click', function(e) {
                if (this.disabled) return;
                
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
                    z-index: 9999;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    if (ripple && ripple.parentNode) {
                        ripple.remove();
                    }
                }, 600);
            });
        }
        
        // Añadir CSS para ripple si no existe
        if (!document.querySelector('#ripple-style')) {
            const style = document.createElement('style');
            style.id = 'ripple-style';
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    });
</script>
@endsection