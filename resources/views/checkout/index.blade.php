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
                {{-- Formulario de pago --}}
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
                                                       placeholder="+1234567890"
                                                       style="
                                                            background: rgba(30, 41, 59, 0.8);
                                                            border: 1px solid rgba(99, 102, 241, 0.3);
                                                            color: #ffffff;
                                                       ">
                                                <label for="billing_phone" style="color: #94a3b8;">Teléfono</label>
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
                                                <label for="billing_address" style="color: #94a3b8;">Dirección</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Sección de tarjeta de crédito (inicialmente visible) --}}
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
                                                   value="{{ old('card_number') }}"
                                                   required
                                                   placeholder="1234 5678 9012 3456"
                                                   maxlength="19"
                                                   pattern="[0-9\s]{13,19}"
                                                   style="
                                                        background: rgba(30, 41, 59, 0.8);
                                                        border: 1px solid rgba(99, 102, 241, 0.3);
                                                        color: #ffffff;
                                                        letter-spacing: 1px;
                                                   ">
                                            <label for="card_number" style="color: #94a3b8;">Número de Tarjeta *</label>
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
                                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ old('card_exp_month') == $i ? 'selected' : '' }}>
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
                                                        <option value="{{ $i }}" {{ old('card_exp_year') == $i ? 'selected' : '' }}>
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
                                                       pattern="[0-9]{3,4}"
                                                       style="
                                                            background: rgba(30, 41, 59, 0.8);
                                                            border: 1px solid rgba(99, 102, 241, 0.3);
                                                            color: #ffffff;
                                                       ">
                                                <label for="card_cvv" style="color: #94a3b8;">CVV *</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Sección de transferencia bancaria (inicialmente oculta) --}}
                                <div id="bank-transfer-section" style="display: none;">
                                    <h6 class="mb-3" style="color: #a5f3fc; font-weight: 600;">
                                        <i class="bi bi-bank me-2"></i> Información de Transferencia
                                    </h6>
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="bank_name" 
                                                   name="bank_name"
                                                   value="{{ old('bank_name') }}"
                                                   placeholder="Nombre del Banco"
                                                   style="
                                                        background: rgba(30, 41, 59, 0.8);
                                                        border: 1px solid rgba(99, 102, 241, 0.3);
                                                        color: #ffffff;
                                                   ">
                                            <label for="bank_name" style="color: #94a3b8;">Nombre del Banco *</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="account_number" 
                                                   name="account_number"
                                                   value="{{ old('account_number') }}"
                                                   placeholder="Número de Cuenta"
                                                   style="
                                                        background: rgba(30, 41, 59, 0.8);
                                                        border: 1px solid rgba(99, 102, 241, 0.3);
                                                        color: #ffffff;
                                                   ">
                                            <label for="account_number" style="color: #94a3b8;">Número de Cuenta *</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="transaction_reference" 
                                                   name="transaction_reference"
                                                   value="{{ old('transaction_reference') }}"
                                                   placeholder="Referencia de Transacción"
                                                   style="
                                                        background: rgba(30, 41, 59, 0.8);
                                                        border: 1px solid rgba(99, 102, 241, 0.3);
                                                        color: #ffffff;
                                                   ">
                                            <label for="transaction_reference" style="color: #94a3b8;">Referencia *</label>
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
    
    #pay-button:disabled {
        opacity: 0.7;
        cursor: not-allowed;
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
        creditCardRadio.addEventListener('change', function() {
            if (this.checked) {
                creditCardSection.style.display = 'block';
                bankTransferSection.style.display = 'none';
                
                // Hacer campos requeridos
                document.getElementById('card_number').required = true;
                document.getElementById('card_exp_month').required = true;
                document.getElementById('card_exp_year').required = true;
                document.getElementById('card_cvv').required = true;
                
                // Quitar requerido de campos de transferencia
                document.getElementById('bank_name').required = false;
                document.getElementById('account_number').required = false;
                document.getElementById('transaction_reference').required = false;
            }
        });
        
        bankTransferRadio.addEventListener('change', function() {
            if (this.checked) {
                creditCardSection.style.display = 'none';
                bankTransferSection.style.display = 'block';
                
                // Quitar requerido de campos de tarjeta
                document.getElementById('card_number').required = false;
                document.getElementById('card_exp_month').required = false;
                document.getElementById('card_exp_year').required = false;
                document.getElementById('card_cvv').required = false;
                
                // Hacer campos requeridos de transferencia
                document.getElementById('bank_name').required = true;
                document.getElementById('account_number').required = true;
                document.getElementById('transaction_reference').required = true;
            }
        });
        
        // Formatear número de tarjeta
        const cardNumberInput = document.getElementById('card_number');
        cardNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 16) value = value.substring(0, 16);
            
            // Agregar espacios cada 4 dígitos
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            e.target.value = value;
        });
        
        // Formatear CVV
        const cvvInput = document.getElementById('card_cvv');
        cvvInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) value = value.substring(0, 4);
            e.target.value = value;
        });
        
        // Validar formulario antes de enviar
        form.addEventListener('submit', function(e) {
            // Validar fecha de vencimiento para tarjeta
            if (creditCardRadio.checked) {
                const currentYear = new Date().getFullYear();
                const currentMonth = new Date().getMonth() + 1;
                
                const expiryMonth = parseInt(document.getElementById('card_exp_month').value);
                const expiryYear = parseInt(document.getElementById('card_exp_year').value);
                
                if (expiryYear === currentYear && expiryMonth < currentMonth) {
                    e.preventDefault();
                    alert('La tarjeta ha expirado. Por favor, verifica la fecha de vencimiento.');
                    return false;
                }
                
                // Validar número de tarjeta (simplificado)
                const cardNumber = document.getElementById('card_number').value.replace(/\s/g, '');
                if (cardNumber.length !== 16) {
                    e.preventDefault();
                    alert('El número de tarjeta debe tener 16 dígitos.');
                    return false;
                }
                
                // Validar CVV
                const cvv = document.getElementById('card_cvv').value;
                if (cvv.length < 3 || cvv.length > 4) {
                    e.preventDefault();
                    alert('El CVV debe tener 3 o 4 dígitos.');
                    return false;
                }
            }
            
            // Mostrar loading
            payButton.disabled = true;
            payButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> PROCESANDO PAGO...';
            
            return true;
        });
    });
</script>
@endsection