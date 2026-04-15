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

```
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

                        @auth
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
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="billing_name" 
                                                   name="billing_name"
                                                   value="{{ Auth::user()->name ?? old('billing_name') }}"
                                                   required
                                                   placeholder="Nombre Completo">
                                            <label>Nombre Completo *</label>
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
                                                   placeholder="correo@ejemplo.com">
                                            <label>Correo Electrónico *</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Botón de pago --}}
                            <div class="mt-4">
                                <button type="submit" class="btn w-100 gaming-font" id="pay-button">
                                    <i class="bi bi-lock-fill me-2"></i> PAGAR ${{ number_format($total, 2) }}
                                </button>
                            </div>

                        </form>

                        @else
                        <div class="text-center p-5">
                            <h5 class="mb-3" style="color:#e2e8f0;">
                                Debes iniciar sesión para continuar
                            </h5>
                            <a href="{{ route('login') }}" class="btn btn-lg btn-primary">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Ir a Login
                            </a>
                        </div>
                        @endauth

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-4">
                    <h5>Resumen</h5>

                    @foreach($updatedCart as $item)
                        <div class="d-flex justify-content-between">
                            <span>{{ $item['name'] }}</span>
                            <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </div>
                    @endforeach

                    <hr>
                    <strong>Total: ${{ number_format($total, 2) }}</strong>
                </div>
            </div>

        </div>
    </div>
</div>
```

</div>

@endsection
