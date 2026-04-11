@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="gaming-font mb-3" style="
                    background: linear-gradient(45deg, #22d3ee, #6366f1);
                    -webkit-background-clip: text;
                    background-clip: text;
                    color: transparent;
                    font-weight: 900;
                    font-size: 2.2rem;
                ">
                    <i class="bi bi-credit-card me-2"></i> FINALIZAR COMPRA
                </h1>
                <p class="text-light" style="opacity: 0.8;">
                    Completa tu información de pago
                </p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card" style="
                        background: rgba(10, 15, 28, 0.95);
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(99, 102, 241, 0.3);
                        border-radius: 20px;
                        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
                    ">
                        <div class="card-body p-4">
                            <form id="payment-form" action="{{ route('checkout.process') }}" method="POST">
                                @csrf
                                
                                {{-- Método de pago --}}
                                <div class="mb-4">
                                    <h6 class="mb-3" style="color: #a5f3fc; font-weight: 600;">
                                        <i class="bi bi-wallet2 me-2"></i> Método de Pago
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                                                <label class="form-check-label" for="credit_card" style="color: #e2e8f0;">
                                                    <i class="bi bi-credit-card me-2"></i> Tarjeta de Crédito/Débito
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                                <label class="form-check-label" for="bank_transfer" style="color: #e2e8f0;">
                                                    <i class="bi bi-bank me-2"></i> Transferencia Bancaria
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Información de contacto --}}
                                <div class="mb-4">
                                    <h6 class="mb-3" style="color: #a5f3fc; font-weight: 600;">
                                        <i class="bi bi-person-circle me-2"></i> Información de Contacto
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" 
                                                       class="form-control" 
                                                       id="billing_name" 
                                                       name="billing_name"
                                                       value="{{ Auth::user()->name ?? old('billing_name') }}"
                                                       required
                                                       placeholder="Nombre Completo"
                                                       style="
                                                            background: rgba(30, 41, 59, 0.8);
                                                            border: 1px solid rgba(99, 102, 241, 0.3);
                                                            color: #ffffff;
                                                       ">
                                                <label for="billing_name" style="color: #94a3b8;">Nombre Completo *</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="email" 
                                                       class="form-control" 
                                                       id="billing_email" 
                                                       name="billing_email"
                                                       value="{{ Auth::user()->email ?? old('billing_email') }}"
                                                       required
                                                       placeholder="correo@ejemplo.com"
                                                       style="
                                                            background: rgba(30, 41, 59, 0.8);
                                                            border: 1px solid rgba(99, 102, 241, 0.3);
                                                            color: #ffffff;
                                                       ">
                                                <label for="billing_email" style="color: #94a3b8;">Correo Electrónico *</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="tel" 
                                                       class="form-control" 
                                                       id="billing_phone" 
                                                       name="billing_phone"
                                                       value="{{ old('billing_phone') }}"
                                                       placeholder="Teléfono"
                                                       maxlength="10"
                                                       onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                       style="
                                                            background: rgba(30, 41, 59, 0.8);
                                                            border: 1px solid rgba(99, 102, 241, 0.3);
                                                            color: #ffffff;
                                                       ">
                                                <label for="billing_phone" style="color: #94a3b8;">Teléfono (Máx 10 números)</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" 
                                                       class="form-control" 
                                                       id="billing_address" 
                                                       name="billing_address"
                                                       value="{{ old('billing_address') }}"
                                                       placeholder="Dirección"
                                                       style="
                                                            background: rgba(30, 41, 59, 0.8);
                                                            border: 1px solid rgba(99, 102, 241, 0.3);
                                                            color: #ffffff;
                                                       ">
                                                <label for="billing_address" style="color: #94a3b8;">Dirección (Opcional)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Sección de tarjeta de crédito --}}
                                <div id="credit-card-section">
                                    <h6 class="mb-3" style="color: #a5f3fc; font-weight: 600;">
                                        <i class="bi bi-credit-card me-2"></i> Información de Tarjeta
                                    </h6>
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="card_number" 
                                                   name="card_number"
                                                   required
                                                   placeholder="1234 5678 9012 3456"
                                                   maxlength="19"
                                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 32"
                                                   style="
                                                        background: rgba(30, 41, 59, 0.8);
                                                        border: 1px solid rgba(99, 102, 241, 0.3);
                                                        color: #ffffff;
                                                        letter-spacing: 1px;
                                                   ">
                                            <label for="card_number" style="color: #94a3b8;">Número de Tarjeta * (16 dígitos)</label>
                                        </div>
                                        <div class="card-icons mt-2">
                                            <i class="bi bi-cc-visa me-2" style="color: #6366f1; font-size: 1.5rem;"></i>
                                            <i class="bi bi-cc-mastercard me-2" style="color: #f59e0b; font-size: 1.5rem;"></i>
                                            <i class="bi bi-cc-amex" style="color: #10b981; font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select" 
                                                        id="card_exp_month" 
                                                        name="card_exp_month"
                                                        required
                                                        style="
                                                            background: rgba(30, 41, 59, 0.8);
                                                            border: 1px solid rgba(99, 102, 241, 0.3);
                                                            color: #ffffff;
                                                        ">
                                                    <option value="" selected disabled>MM</option>
                                                    @for($i = 1; $i <= 12; $i++)
                                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <label for="card_exp_month" style="color: #94a3b8;">Mes *</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select" 
                                                        id="card_exp_year" 
                                                        name="card_exp_year"
                                                        required
                                                        style="
                                                            background: rgba(30, 41, 59, 0.8);
                                                            border: 1px solid rgba(99, 102, 241, 0.3);
                                                            color: #ffffff;
                                                        ">
                                                    <option value="" selected disabled>AAAA</option>
                                                    @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                                        <option value="{{ $i }}">
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <label for="card_exp_year" style="color: #94a3b8;">Año *</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input type="text" 
                                                       class="form-control" 
                                                       id="card_cvv" 
                                                       name="card_cvv"
                                                       required
                                                       placeholder="123"
                                                       maxlength="4"
                                                       onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                       style="
                                                            background: rgba(30, 41, 59, 0.8);
                                                            border: 1px solid rgba(99, 102, 241, 0.3);
                                                            color: #ffffff;
                                                       ">
                                                <label for="card_cvv" style="color: #94a3b8;">CVV * (3 o 4 dígitos)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Sección de transferencia bancaria --}}
                                <div id="bank-transfer-section" style="display: none;">
                                    <h6 class="mb-3" style="color: #a5f3fc; font-weight: 600;">
                                        <i class="bi bi-bank me-2"></i> Información de Transferencia
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
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="bank_name" 
                                                   name="bank_name"
                                                   placeholder="Nombre del Banco"
                                                   onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32"
                                                   style="
                                                        background: rgba(30, 41, 59, 0.8);
                                                        border: 1px solid rgba(99, 102, 241, 0.3);
                                                        color: #ffffff;
                                                   ">
                                            <label for="bank_name" style="color: #94a3b8;">Nombre del Banco * (Solo letras)</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="account_number" 
                                                   name="account_number"
                                                   placeholder="Número de Cuenta"
                                                   maxlength="20"
                                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                   style="
                                                        background: rgba(30, 41, 59, 0.8);
                                                        border: 1px solid rgba(99, 102, 241, 0.3);
                                                        color: #ffffff;
                                                   ">
                                            <label for="account_number" style="color: #94a3b8;">Número de Cuenta * (Solo números)</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="transaction_reference" 
                                                   name="transaction_reference"
                                                   placeholder="Referencia de Transacción"
                                                   style="
                                                        background: rgba(30, 41, 59, 0.8);
                                                        border: 1px solid rgba(99, 102, 241, 0.3);
                                                        color: #ffffff;
                                                   ">
                                            <label for="transaction_reference" style="color: #94a3b8;">Referencia de Transferencia *</label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Notas adicionales --}}
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <textarea class="form-control" 
                                                  id="notes" 
                                                  name="notes"
                                                  placeholder="Notas adicionales..."
                                                  style="
                                                       background: rgba(30, 41, 59, 0.8);
                                                       border: 1px solid rgba(99, 102, 241, 0.3);
                                                       color: #ffffff;
                                                       height: 100px;
                                                  ">{{ old('notes') }}</textarea>
                                        <label for="notes" style="color: #94a3b8;">Notas adicionales (opcional)</label>
                                    </div>
                                </div>

                                {{-- Botón de pago --}}
                                <div class="mt-4">
                                    <button type="submit" class="btn w-100 gaming-font" id="pay-button" style="
                                        background: linear-gradient(45deg, #22d3ee, #6366f1, #a855f7);
                                        background-size: 200% 200%;
                                        border: none;
                                        border-radius: 12px;
                                        padding: 16px;
                                        color: #0f172a;
                                        font-weight: 900;
                                        letter-spacing: 1px;
                                        transition: all 0.3s ease;
                                        animation: gradientShift 3s ease infinite;
                                    ">
                                        <i class="bi bi-lock-fill me-2"></i> PAGAR ${{ number_format($total, 2) }}
                                    </button>
                                    
                                    <p class="text-center mt-3 mb-0" style="color: #94a3b8; font-size: 0.8rem;">
                                        <i class="bi bi-shield-check me-1"></i>
                                        Pago 100% seguro - Tus datos están encriptados
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Resumen del pedido --}}
                <div class="col-lg-4">
                    <div class="card mb-4" style="
                        background: rgba(10, 15, 28, 0.95);
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(99, 102, 241, 0.3);
                        border-radius: 20px;
                        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
                    ">
                        <div class="card-header border-0" style="
                            background: linear-gradient(45deg, rgba(34, 211, 238, 0.1), rgba(139, 92, 246, 0.1));
                            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
                        ">
                            <h5 class="mb-0 gaming-font" style="color: #a855f7;">
                                <i class="bi bi-receipt me-2"></i> RESUMEN DEL PEDIDO
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                @foreach($cart as $id => $item)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #e2e8f0; font-size: 0.9rem;">
                                            {{ $item['name'] }} x{{ $item['quantity'] }}
                                        </span>
                                        <span style="color: #22d3ee; font-weight: 600;">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <hr style="border-color: rgba(99, 102, 241, 0.3);">

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #e2e8f0; font-weight: 500;">Subtotal</span>
                                    <span style="color: #ffffff; font-weight: 600;">${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #e2e8f0; font-weight: 500;">Envío</span>
                                    <span style="color: #22c55e; font-weight: 600;">Gratis</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span style="color: #e2e8f0; font-weight: 500;">Impuestos</span>
                                    <span style="color: #ffffff; font-weight: 600;">$0.00</span>
                                </div>
                            </div>

                            <hr style="border-color: rgba(99, 102, 241, 0.3);">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span style="color: #ffffff; font-weight: 700; font-size: 1.1rem;">Total</span>
                                <span style="
                                    background: linear-gradient(45deg, #22d3ee, #6366f1);
                                    -webkit-background-clip: text;
                                    background-clip: text;
                                    color: transparent;
                                    font-weight: 900;
                                    font-size: 1.3rem;
                                ">
                                    ${{ number_format($total, 2) }}
                                </span>
                            </div>

                            <div class="alert" style="
                                background: rgba(34, 211, 238, 0.1);
                                border: 1px solid rgba(34, 211, 238, 0.3);
                                border-radius: 12px;
                                color: #67e8f9;
                                padding: 12px;
                                font-size: 0.85rem;
                            ">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <div>
                                        <p class="mb-1">Política de reembolso</p>
                                        <small style="color: #a5f3fc;">30 días de garantía</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('cart.index') }}" class="btn w-100 mb-3" style="
                        background: rgba(30, 41, 59, 0.8);
                        border: 1px solid rgba(99, 102, 241, 0.3);
                        color: #67e8f9;
                        font-weight: 600;
                        padding: 12px;
                        border-radius: 12px;
                        transition: all 0.3s ease;
                    ">
                        <i class="bi bi-arrow-left me-2"></i> Volver al Carrito
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    .form-control:focus, .form-select:focus {
        background: rgba(30, 41, 59, 0.9) !important;
        border-color: rgba(34, 211, 238, 0.5) !important;
        box-shadow: 0 0 0 0.2rem rgba(34, 211, 238, 0.25) !important;
        color: #ffffff !important;
    }
    
    .form-check-input:checked {
        background-color: #22d3ee;
        border-color: #22d3ee;
    }
    
    #pay-button {
        position: relative;
        overflow: hidden;
    }
    
    #pay-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(34, 211, 238, 0.4) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('payment-form');
        const payButton = document.getElementById('pay-button');
        const creditCardSection = document.getElementById('credit-card-section');
        const bankTransferSection = document.getElementById('bank-transfer-section');
        const creditCardRadio = document.getElementById('credit_card');
        const bankTransferRadio = document.getElementById('bank_transfer');
        
        // Cambiar entre métodos de pago
        if (creditCardRadio && bankTransferRadio) {
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
        }
        
        // Formatear número de tarjeta (agregar espacios cada 4 dígitos)
        const cardNumberInput = document.getElementById('card_number');
        if (cardNumberInput) {
            cardNumberInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 16) value = value.substring(0, 16);
                value = value.replace(/(.{4})/g, '$1 ').trim();
                e.target.value = value;
            });
        }
        
        // =====================================================
        // 🔥 ENVÍO DEL FORMULARIO - SIN BLOQUEAR
        // =====================================================
        if (form) {
            form.addEventListener('submit', function(e) {
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                
                if (!paymentMethod) {
                    e.preventDefault();
                    alert('❌ Selecciona un método de pago');
                    return false;
                }
                
                // Validaciones para tarjeta de crédito
                if (paymentMethod.value === 'credit_card') {
                    const cardNumber = document.getElementById('card_number')?.value.replace(/\s/g, '') || '';
                    const expMonth = document.getElementById('card_exp_month')?.value || '';
                    const expYear = document.getElementById('card_exp_year')?.value || '';
                    const cvv = document.getElementById('card_cvv')?.value || '';
                    
                    if (cardNumber.length !== 16) {
                        e.preventDefault();
                        alert('❌ El número de tarjeta debe tener 16 dígitos');
                        return false;
                    }
                    
                    if (expMonth === '') {
                        e.preventDefault();
                        alert('❌ Selecciona el mes de expiración');
                        return false;
                    }
                    
                    if (expYear === '') {
                        e.preventDefault();
                        alert('❌ Selecciona el año de expiración');
                        return false;
                    }
                    
                    if (cvv.length < 3 || cvv.length > 4) {
                        e.preventDefault();
                        alert('❌ El CVV debe tener 3 o 4 dígitos');
                        return false;
                    }
                }
                
                // Validaciones para transferencia bancaria
                if (paymentMethod.value === 'bank_transfer') {
                    const bankName = document.getElementById('bank_name')?.value.trim() || '';
                    const accountNumber = document.getElementById('account_number')?.value.trim() || '';
                    const reference = document.getElementById('transaction_reference')?.value.trim() || '';
                    
                    if (bankName === '') {
                        e.preventDefault();
                        alert('❌ Ingresa el nombre del banco');
                        return false;
                    }
                    
                    if (accountNumber === '') {
                        e.preventDefault();
                        alert('❌ Ingresa el número de cuenta');
                        return false;
                    }
                    
                    if (reference === '') {
                        e.preventDefault();
                        alert('❌ Ingresa la referencia de transferencia');
                        return false;
                    }
                }
                
                // Validar nombre
                const name = document.getElementById('billing_name')?.value.trim() || '';
                if (name === '') {
                    e.preventDefault();
                    alert('❌ Ingresa tu nombre completo');
                    return false;
                }
                
                // Validar email
                const email = document.getElementById('billing_email')?.value.trim() || '';
                if (email === '' || !email.includes('@')) {
                    e.preventDefault();
                    alert('❌ Ingresa un correo electrónico válido');
                    return false;
                }
                
                // Mostrar loading (pero NO deshabilitar el envío)
                if (payButton) {
                    payButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> PROCESANDO PAGO...';
                    payButton.style.opacity = '0.8';
                }
                
                // Permitir envío del formulario
                return true;
            });
        }
        
        // Efecto ripple
        if (payButton) {
            payButton.addEventListener('click', function(e) {
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
                    if (ripple && ripple.parentNode) ripple.remove();
                }, 600);
            });
        }
        
        // CSS para ripple
        if (!document.querySelector('#ripple-style')) {
            const style = document.createElement('style');
            style.id = 'ripple-style';
            style.textContent = `@keyframes ripple { to { transform: scale(4); opacity: 0; } }`;
            document.head.appendChild(style);
        }
    });
</script>
@endsection