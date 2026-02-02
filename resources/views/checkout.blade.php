@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
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
                    🛒 FINALIZAR COMPRA
                </h1>
                <p class="text-light" style="opacity: 0.8;">
                    Completa tu información de pago
                </p>
            </div>

            <div class="row">
                {{-- Resumen del carrito --}}
                <div class="col-lg-5 mb-4">
                    <div class="card h-100" style="
                        background: rgba(15, 23, 42, 0.7);
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(99, 102, 241, 0.2);
                        border-radius: 20px;
                        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                    ">
                        <div class="card-header border-0" style="
                            background: linear-gradient(45deg, rgba(34, 211, 238, 0.1), rgba(139, 92, 246, 0.1));
                            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
                        ">
                            <h5 class="mb-0 gaming-font" style="color: #22d3ee;">
                                <i class="bi bi-cart-check me-2"></i> RESUMEN DEL PEDIDO
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $subtotal = 0;
                                $cart = session('cart', []);
                            @endphp
                            
                            @foreach($cart as $gameId => $item)
                                @php
                                    $subtotal += $item['price'] * $item['quantity'];
                                @endphp
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom" style="border-color: rgba(99, 102, 241, 0.1) !important;">
                                    <div class="flex-shrink-0 me-3">
                                        <div style="width: 60px; height: 60px; border-radius: 10px; overflow: hidden;">
                                            <img src="{{ asset('storage/' . $item['image']) }}" 
                                                 alt="{{ $item['name'] }}"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1" style="color: #e2e8f0; font-size: 0.9rem;">
                                            {{ $item['name'] }}
                                        </h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span style="color: #94a3b8; font-size: 0.8rem;">
                                                {{ $item['quantity'] }} x ${{ number_format($item['price'], 2) }}
                                            </span>
                                            <span style="color: #22d3ee; font-weight: 600;">
                                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            {{-- Totales --}}
                            <div class="mt-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #cbd5e1;">Subtotal</span>
                                    <span style="color: #cbd5e1;">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #cbd5e1;">Envío</span>
                                    <span style="color: #cbd5e1;">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #cbd5e1;">Impuestos</span>
                                    <span style="color: #cbd5e1;">$0.00</span>
                                </div>
                                <hr style="border-color: rgba(99, 102, 241, 0.2);">
                                <div class="d-flex justify-content-between">
                                    <span style="color: #22d3ee; font-weight: 700; font-size: 1.1rem;">Total</span>
                                    <span style="
                                        background: linear-gradient(45deg, #22d3ee, #6366f1);
                                        -webkit-background-clip: text;
                                        background-clip: text;
                                        color: transparent;
                                        font-weight: 900;
                                        font-size: 1.3rem;
                                    ">
                                        ${{ number_format($subtotal, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Formulario de pago --}}
                <div class="col-lg-7">
                    <div class="card" style="
                        background: rgba(15, 23, 42, 0.7);
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(99, 102, 241, 0.2);
                        border-radius: 20px;
                        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                    ">
                        <div class="card-header border-0" style="
                            background: linear-gradient(45deg, rgba(34, 211, 238, 0.1), rgba(139, 92, 246, 0.1));
                            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
                        ">
                            <h5 class="mb-0 gaming-font" style="color: #a855f7;">
                                <i class="bi bi-credit-card me-2"></i> INFORMACIÓN DE PAGO
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form id="paymentForm" action="{{ route('checkout.process') }}" method="POST">
                                @csrf
                                
                                {{-- Información de facturación --}}
                                <div class="mb-4">
                                    <h6 class="mb-3" style="color: #22d3ee;">
                                        <i class="bi bi-person-badge me-2"></i> Información de Facturación
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="billing_name" 
                                                   placeholder="Nombre completo *"
                                                   required
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" 
                                                   class="form-control" 
                                                   name="billing_email" 
                                                   placeholder="Email *"
                                                   required
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="billing_phone" 
                                                   placeholder="Teléfono"
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="billing_address" 
                                                   placeholder="Dirección"
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                        </div>
                                    </div>
                                </div>

                                {{-- Método de pago --}}
                                <div class="mb-4">
                                    <h6 class="mb-3" style="color: #a855f7;">
                                        <i class="bi bi-wallet2 me-2"></i> Método de Pago
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="payment-methods">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" 
                                                           type="radio" 
                                                           name="payment_method" 
                                                           id="credit_card" 
                                                           value="credit_card" 
                                                           checked
                                                           style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.3);">
                                                    <label class="form-check-label" for="credit_card" style="color: #cbd5e1;">
                                                        <i class="bi bi-credit-card-2-front me-2"></i> Tarjeta de Crédito/Débito
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" 
                                                           type="radio" 
                                                           name="payment_method" 
                                                           id="bank_transfer" 
                                                           value="bank_transfer"
                                                           style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.3);">
                                                    <label class="form-check-label" for="bank_transfer" style="color: #cbd5e1;">
                                                        <i class="bi bi-bank me-2"></i> Transferencia Bancaria
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Sección Tarjeta de Crédito --}}
                                <div id="creditCardSection" class="payment-section">
                                    <h6 class="mb-3" style="color: #22d3ee;">
                                        <i class="bi bi-credit-card-fill me-2"></i> Información de Tarjeta
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <input type="text" 
                                                   class="form-control card-number" 
                                                   name="card_number" 
                                                   placeholder="Número de tarjeta *"
                                                   maxlength="19"
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                            <div class="card-icons mt-2">
                                                <i class="bi bi-cc-visa me-2" style="color: #6366f1; font-size: 1.5rem;"></i>
                                                <i class="bi bi-cc-mastercard me-2" style="color: #f59e0b; font-size: 1.5rem;"></i>
                                                <i class="bi bi-cc-amex" style="color: #10b981; font-size: 1.5rem;"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="card_exp_month" 
                                                   placeholder="MM *"
                                                   maxlength="2"
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="card_exp_year" 
                                                   placeholder="YYYY *"
                                                   maxlength="4"
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="card_cvv" 
                                                   placeholder="CVV *"
                                                   maxlength="4"
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="card_holder" 
                                                   placeholder="Nombre en la tarjeta *"
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                        </div>
                                    </div>
                                </div>

                                {{-- Sección Transferencia Bancaria --}}
                                <div id="bankTransferSection" class="payment-section" style="display: none;">
                                    <h6 class="mb-3" style="color: #22d3ee;">
                                        <i class="bi bi-bank2 me-2"></i> Información de Transferencia
                                    </h6>
                                    <div class="alert mb-4" style="
                                        background: rgba(34, 211, 238, 0.1);
                                        border: 1px solid rgba(34, 211, 238, 0.3);
                                        border-radius: 12px;
                                        color: #67e8f9;
                                        padding: 15px;
                                    ">
                                        <h6 class="mb-2">
                                            <i class="bi bi-info-circle me-2"></i> Instrucciones para transferencia:
                                        </h6>
                                        <p class="mb-0 small">
                                            1. Realiza la transferencia a nuestra cuenta bancaria<br>
                                            2. Incluye el número de referencia en el formulario<br>
                                            3. Tu pedido será procesado una vez confirmemos el pago
                                        </p>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="bank_name" 
                                                   placeholder="Nombre del banco *"
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="account_number" 
                                                   placeholder="Número de cuenta *"
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="transaction_reference" 
                                                   placeholder="Referencia de transferencia *"
                                                   style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;">
                                        </div>
                                    </div>
                                </div>

                                {{-- Notas --}}
                                <div class="mb-4">
                                    <textarea class="form-control" 
                                              name="notes" 
                                              rows="2" 
                                              placeholder="Notas adicionales (opcional)"
                                              style="background: rgba(15, 23, 42, 0.6); border-color: rgba(99, 102, 241, 0.2); color: #e2e8f0;"></textarea>
                                </div>

                                {{-- Botón de pago --}}
                                <button type="submit" class="btn w-100 gaming-font" style="
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
                                    <i class="bi bi-lock-fill me-2"></i> PROCEDER AL PAGO
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animaciones */
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    /* Efectos para inputs */
    .form-control {
        transition: all 0.3s ease !important;
        border-radius: 10px !important;
        padding: 12px 15px !important;
    }
    
    .form-control:focus {
        outline: none;
        border-color: rgba(34, 211, 238, 0.6) !important;
        box-shadow: 
            0 0 0 3px rgba(34, 211, 238, 0.1),
            inset 0 0 10px rgba(34, 211, 238, 0.1) !important;
        transform: translateY(-1px);
    }
    
    /* Checkboxes */
    .form-check-input {
        width: 18px;
        height: 18px;
        margin-top: 0.2rem;
    }
    
    .form-check-input:checked {
        background-color: #22d3ee !important;
        border-color: #22d3ee !important;
    }
    
    /* Radio buttons */
    .form-check-input[type="radio"] {
        border-radius: 50%;
    }
    
    .form-check-label {
        cursor: pointer;
    }
    
    /* Secciones de pago */
    .payment-section {
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Formato para número de tarjeta */
    .card-number {
        letter-spacing: 1px;
    }
    
    /* Botón submit */
    .btn[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 10px 25px rgba(34, 211, 238, 0.4),
            0 0 20px rgba(139, 92, 246, 0.3) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Alternar entre métodos de pago
        const creditCardRadio = document.getElementById('credit_card');
        const bankTransferRadio = document.getElementById('bank_transfer');
        const creditCardSection = document.getElementById('creditCardSection');
        const bankTransferSection = document.getElementById('bankTransferSection');
        
        creditCardRadio.addEventListener('change', function() {
            if (this.checked) {
                creditCardSection.style.display = 'block';
                bankTransferSection.style.display = 'none';
            }
        });
        
        bankTransferRadio.addEventListener('change', function() {
            if (this.checked) {
                creditCardSection.style.display = 'none';
                bankTransferSection.style.display = 'block';
            }
        });
        
        // Formato para número de tarjeta
        const cardNumberInput = document.querySelector('.card-number');
        cardNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(.{4})/g, '$1 ').trim();
            e.target.value = value.substring(0, 19);
        });
        
        // Validación de formulario
        const form = document.getElementById('paymentForm');
        const submitBtn = form.querySelector('button[type="submit"]');
        
        form.addEventListener('submit', function(e) {
            // Validar campos según método de pago
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            
            if (paymentMethod === 'credit_card') {
                const cardNumber = document.querySelector('input[name="card_number"]').value;
                const expMonth = document.querySelector('input[name="card_exp_month"]').value;
                const expYear = document.querySelector('input[name="card_exp_year"]').value;
                const cvv = document.querySelector('input[name="card_cvv"]').value;
                
                if (cardNumber.replace(/\s/g, '').length < 16) {
                    e.preventDefault();
                    alert('Por favor, ingresa un número de tarjeta válido (16 dígitos).');
                    return;
                }
                
                if (expMonth < 1 || expMonth > 12) {
                    e.preventDefault();
                    alert('El mes de expiración debe estar entre 1 y 12.');
                    return;
                }
                
                if (expYear < new Date().getFullYear()) {
                    e.preventDefault();
                    alert('El año de expiración no puede ser anterior al actual.');
                    return;
                }
                
                if (cvv.length < 3) {
                    e.preventDefault();
                    alert('Por favor, ingresa un CVV válido.');
                    return;
                }
            } else if (paymentMethod === 'bank_transfer') {
                const reference = document.querySelector('input[name="transaction_reference"]').value;
                if (!reference.trim()) {
                    e.preventDefault();
                    alert('Por favor, ingresa la referencia de transferencia.');
                    return;
                }
            }
            
            // Efecto de carga
            if (!e.defaultPrevented) {
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> PROCESANDO PAGO...';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.8';
            }
        });
        
        // Efecto ripple para botón
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
        
        // Añadir CSS para ripple
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
    });
</script>
@endsection