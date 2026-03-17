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
                    ✏️ EDITAR JUEGO ✏️
                </h1>
                <p class="text-light" style="opacity: 0.8; font-size: 1rem;">
                    Modifica los datos del juego "{{ $game->name }}"
                </p>
            </div>

            {{-- Botones de navegación --}}
            <div class="d-flex justify-content-between mb-4">
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
                ">
                    <i class="bi bi-arrow-left"></i> Volver al Catálogo
                </a>
                
                <a href="{{ route('admin.games.create') }}" class="btn" style="
                    background: linear-gradient(45deg, #22d3ee, #6366f1);
                    border: none;
                    color: #0f172a;
                    font-weight: 600;
                    padding: 10px 20px;
                    border-radius: 10px;
                    transition: all 0.3s ease;
                ">
                    <i class="bi bi-plus-circle me-2"></i> Nuevo Juego
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
                    <form action="{{ route('admin.games.update', $game->id) }}" method="POST" enctype="multipart/form-data" id="gameForm">
                        @csrf
                        @method('PUT')
                        
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
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $game->name) }}" style="
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
                            ">{{ old('description', $game->description) }}</textarea>
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
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required value="{{ old('price', $game->price) }}" style="
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
                                <option value="Acción" style="background: #1e293b;" {{ old('category', $game->category) == 'Acción' ? 'selected' : '' }}>Acción</option>
                                <option value="Aventura" style="background: #1e293b;" {{ old('category', $game->category) == 'Aventura' ? 'selected' : '' }}>Aventura</option>
                                <option value="Deportes" style="background: #1e293b;" {{ old('category', $game->category) == 'Deportes' ? 'selected' : '' }}>Deportes</option>
                                <option value="Estrategia" style="background: #1e293b;" {{ old('category', $game->category) == 'Estrategia' ? 'selected' : '' }}>Estrategia</option>
                                <option value="RPG" style="background: #1e293b;" {{ old('category', $game->category) == 'RPG' ? 'selected' : '' }}>RPG</option>
                                <option value="Carreras" style="background: #1e293b;" {{ old('category', $game->category) == 'Carreras' ? 'selected' : '' }}>Carreras</option>
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
                                <option value="available" style="background: #1e293b;" {{ old('status', $game->status) == 'available' ? 'selected' : '' }}>Disponible</option>
                                <option value="out_of_stock" style="background: #1e293b;" {{ old('status', $game->status) == 'out_of_stock' ? 'selected' : '' }}>Agotado</option>
                                <option value="discontinued" style="background: #1e293b;" {{ old('status', $game->status) == 'discontinued' ? 'selected' : '' }}>Descontinuado</option>
                            </select>
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
                                       min="0" max="100" value="{{ old('discount_percent', $game->discount_percent ?? 0) }}" style="
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
                            
                            {{-- Vista previa del precio con descuento --}}
                            <div id="discountPreview" class="mt-3 p-3 rounded" style="
                                background: rgba(34, 211, 238, 0.1);
                                border: 1px solid rgba(34, 211, 238, 0.3);
                                display: {{ $game->has_discount ? 'block' : 'none' }};
                            ">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="color: #e2e8f0;">Precio original:</span>
                                    <span id="originalPriceDisplay" style="color: #94a3b8; text-decoration: line-through;">${{ number_format($game->price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span style="color: #e2e8f0; font-weight: 600;">Precio final:</span>
                                    <span id="finalPriceDisplay" style="color: #22d3ee; font-weight: 900; font-size: 1.2rem;">${{ number_format($game->final_price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span style="color: #e2e8f0;">Ahorras:</span>
                                    <span id="savingsDisplay" style="color: #22c55e; font-weight: 600;">${{ number_format($game->savings_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Imagen actual --}}
                        <div class="mb-4">
                            <label class="form-label" style="
                                color: #22d3ee;
                                font-weight: 600;
                                font-size: 0.9rem;
                                letter-spacing: 0.5px;
                                margin-bottom: 8px;
                                display: block;
                            ">
                                <i class="bi bi-image me-1"></i> IMAGEN ACTUAL
                            </label>
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $game->image_path) }}" 
                                     alt="{{ $game->name }}"
                                     style="max-width: 200px; max-height: 150px; border-radius: 10px; border: 2px solid rgba(99, 102, 241, 0.3);">
                            </div>
                            
                            <label for="image" class="form-label" style="
                                color: #22d3ee;
                                font-weight: 600;
                                font-size: 0.9rem;
                                letter-spacing: 0.5px;
                                margin-bottom: 8px;
                                display: block;
                            ">
                                <i class="bi bi-arrow-up-circle me-1"></i> CAMBIAR IMAGEN (opcional)
                            </label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" style="
                                background: rgba(15, 23, 42, 0.6);
                                border: 1px solid rgba(99, 102, 241, 0.2);
                                border-radius: 12px;
                                padding: 14px;
                                color: #e2e8f0;
                                font-size: 1rem;
                                transition: all 0.3s ease;
                            ">
                            <div class="form-text mt-2" style="color: #94a3b8; font-size: 0.85rem;">
                                <i class="bi bi-info-circle me-1"></i> Deja vacío para mantener la imagen actual.
                            </div>
                            
                            {{-- Vista previa de nueva imagen --}}
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <div class="border rounded-lg p-3" style="
                                    border-color: rgba(99, 102, 241, 0.3) !important;
                                    background: rgba(15, 23, 42, 0.4);
                                ">
                                    <p class="text-sm mb-2" style="color: #cbd5e1;">
                                        <i class="bi bi-eye me-1"></i> Nueva imagen:
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

                        {{-- Botones de acción --}}
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn flex-grow-1 gaming-font" style="
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
                            ">
                                <i class="bi bi-save me-2"></i> GUARDAR CAMBIOS
                            </button>
                            
                            <a href="{{ route('catalog') }}" class="btn" style="
                                background: rgba(239, 68, 68, 0.1);
                                border: 1px solid rgba(239, 68, 68, 0.3);
                                color: #fca5a5;
                                font-weight: 600;
                                padding: 16px 25px;
                                border-radius: 12px;
                                transition: all 0.3s ease;
                            ">
                                <i class="bi bi-x-lg me-2"></i> CANCELAR
                            </a>
                        </div>
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
    }
    
    /* Botón guardar */
    button[type="submit"]:hover {
        box-shadow: 
            0 10px 25px rgba(34, 211, 238, 0.4),
            0 0 20px rgba(139, 92, 246, 0.3) !important;
    }
    
    button[type="submit"]::after {
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
    
    button[type="submit"]:hover::after {
        left: 140%;
        opacity: 1;
    }
    
    /* Botón cancelar */
    a.btn:hover {
        background: rgba(239, 68, 68, 0.2) !important;
        color: #fecaca !important;
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
        
        .d-flex.gap-3 {
            flex-direction: column;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Vista previa de nueva imagen
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                
                reader.readAsDataURL(this.files[0]);
            } else {
                imagePreview.style.display = 'none';
            }
        });
        
        // Calculadora de descuentos en tiempo real
        const priceInput = document.getElementById('price');
        const discountInput = document.getElementById('discount_percent');
        const discountPreview = document.getElementById('discountPreview');
        const originalPriceDisplay = document.getElementById('originalPriceDisplay');
        const finalPriceDisplay = document.getElementById('finalPriceDisplay');
        const savingsDisplay = document.getElementById('savingsDisplay');
        
        function calculateDiscount() {
            const price = parseFloat(priceInput.value) || 0;
            const discount = parseInt(discountInput.value) || 0;
            
            if (price > 0 && discount > 0) {
                const discountedPrice = price - (price * discount / 100);
                const savings = price - discountedPrice;
                
                originalPriceDisplay.textContent = '$' + price.toFixed(2);
                finalPriceDisplay.textContent = '$' + discountedPrice.toFixed(2);
                savingsDisplay.textContent = '$' + savings.toFixed(2);
                
                discountPreview.style.display = 'block';
            } else if (price > 0 && discount === 0) {
                discountPreview.style.display = 'none';
            }
        }
        
        priceInput.addEventListener('input', calculateDiscount);
        discountInput.addEventListener('input', calculateDiscount);
        
        // Validación de formulario
        const form = document.getElementById('gameForm');
        const submitBtn = form.querySelector('button[type="submit"]');
        
        form.addEventListener('submit', function(e) {
            // Validar precio positivo
            const price = parseFloat(priceInput.value);
            if (price <= 0) {
                e.preventDefault();
                alert('El precio debe ser mayor a 0');
                return;
            }
            
            // Validar descuento
            const discount = parseInt(discountInput.value) || 0;
            if (discount < 0 || discount > 100) {
                e.preventDefault();
                alert('El descuento debe estar entre 0 y 100');
                return;
            }
            
            // Efecto de carga
            if (!e.defaultPrevented) {
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> GUARDANDO...';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.8';
            }
        });
        
        // Efecto focus en inputs
        const inputs = form.querySelectorAll('input, textarea, select');
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