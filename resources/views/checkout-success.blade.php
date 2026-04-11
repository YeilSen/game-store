@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <div class="mb-4" style="font-size: 5rem; color: #22c55e;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h1 class="gaming-font mb-3" style="
                    background: linear-gradient(45deg, #22c55e, #10b981);
                    -webkit-background-clip: text;
                    background-clip: text;
                    color: transparent;
                    font-weight: 900;
                    font-size: 2.5rem;
                ">
                    ¡PAGO EXITOSO! 🎉
                </h1>
                <p class="text-light" style="opacity: 0.8; font-size: 1.1rem;">
                    Tu pedido ha sido procesado correctamente
                </p>
            </div>

            <div class="card mb-4" style="
                background: rgba(15, 23, 42, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(34, 197, 94, 0.2);
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            ">
                <div class="card-header border-0" style="
                    background: linear-gradient(45deg, rgba(34, 197, 94, 0.1), rgba(16, 185, 129, 0.1));
                    border-bottom: 1px solid rgba(34, 197, 94, 0.2);
                ">
                    <h5 class="mb-0 gaming-font" style="color: #22c55e;">
                        <i class="bi bi-receipt me-2"></i> RESUMEN DE TU PEDIDO
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 style="color: #94a3b8; font-size: 0.9rem;">NÚMERO DE ORDEN</h6>
                                <h4 class="gaming-font" style="color: #22d3ee;">{{ $order->order_number }}</h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 style="color: #94a3b8; font-size: 0.9rem;">FECHA</h6>
                                <h5 style="color: #cbd5e1;">{{ $order->created_at->format('d/m/Y H:i') }}</h5>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 style="color: #22c55e; margin-bottom: 15px;">
                            <i class="bi bi-controller me-2"></i> JUEGOS COMPRADOS
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0" style="background: transparent !important;">
                                <thead>
                                    <tr style="border-bottom: 1px solid rgba(34, 197, 94, 0.1); background: transparent !important;">
                                        <th style="color: #ffffff !important; font-weight: 700; padding: 15px 0;">JUEGO</th>
                                        <th style="color: #ffffff !important; font-weight: 700; text-align: center; padding: 15px 0;">CANTIDAD</th>
                                        <th style="color: #ffffff !important; font-weight: 700; text-align: right; padding: 15px 0;">PRECIO</th>
                                    </tr>
                                </thead>
                                <tbody style="background: transparent !important;">
                                    @foreach($order->items as $item)
                                    <tr style="border-bottom: 1px solid rgba(34, 197, 94, 0.05); background: transparent !important;">
                                        <td style="padding: 15px 0; background: transparent !important;">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <div style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; background: #1e293b;">
                                                        <img src="{{ asset('storage/' . $item->game->image_path) }}" 
                                                             alt="{{ $item->game->name }}"
                                                             style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 style="color: #ffffff !important; margin-bottom: 0;">{{ $item->game->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center; padding: 15px 0; background: transparent !important;">
                                            <span class="badge" style="
                                                background: rgba(34, 197, 94, 0.2);
                                                color: #86efac;
                                                padding: 6px 12px;
                                                border-radius: 8px;
                                                font-size: 0.9rem;
                                            ">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>
                                        <td style="text-align: right; padding: 15px 0; background: transparent !important;">
                                            <span style="color: #22d3ee !important; font-weight: 600;">
                                                ${{ number_format($item->subtotal, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="background: transparent !important;">
                                    <tr style="background: transparent !important;">
                                        <td colspan="2" style="text-align: right; padding: 20px 0; color: #e2e8f0 !important; background: transparent !important;">
                                            <strong>TOTAL:</strong>
                                        </td>
                                        <td style="text-align: right; padding: 20px 0; background: transparent !important;">
                                            <span style="
                                                background: linear-gradient(45deg, #22d3ee, #22c55e);
                                                -webkit-background-clip: text;
                                                background-clip: text;
                                                color: transparent;
                                                font-weight: 900;
                                                font-size: 1.3rem;
                                            ">
                                                ${{ number_format($order->total_amount, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h6 style="color: #22c55e; margin-bottom: 15px;">
                                <i class="bi bi-person me-2"></i> INFORMACIÓN DE FACTURACIÓN
                            </h6>
                            <div style="background: rgba(15, 23, 42, 0.4); padding: 15px; border-radius: 12px;">
                                <p class="mb-2" style="color: #ffffff !important;">
                                    <strong>{{ $order->billing_name }}</strong>
                                </p>
                                <p class="mb-2" style="color: #cbd5e1 !important;">{{ $order->billing_email }}</p>
                                @if($order->billing_phone)
                                    <p class="mb-2" style="color: #cbd5e1 !important;">{{ $order->billing_phone }}</p>
                                @endif
                                @if($order->billing_address)
                                    <p class="mb-0" style="color: #cbd5e1 !important;">{{ $order->billing_address }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <h6 style="color: #22c55e; margin-bottom: 15px;">
                                <i class="bi bi-credit-card me-2"></i> MÉTODO DE PAGO
                            </h6>
                            <div style="background: rgba(15, 23, 42, 0.4); padding: 15px; border-radius: 12px;">
                                @if($order->payment_method == 'credit_card')
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-credit-card-2-front me-2" style="color: #22d3ee; font-size: 1.2rem;"></i>
                                        <span style="color: #ffffff !important;">Tarjeta de Crédito/Débito</span>
                                    </div>
                                    @if($order->card_last_four)
                                        <p class="mb-0 mt-2" style="color: #94a3b8 !important;">
                                            Terminada en {{ $order->card_last_four }}
                                            @if($order->card_brand) - {{ $order->card_brand }} @endif
                                        </p>
                                    @endif
                                @else
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-bank me-2" style="color: #a855f7; font-size: 1.2rem;"></i>
                                        <span style="color: #ffffff !important;">Transferencia Bancaria</span>
                                    </div>
                                    @if($order->bank_name)
                                        <p class="mb-1 mt-2" style="color: #cbd5e1 !important;">Banco: {{ $order->bank_name }}</p>
                                    @endif
                                    @if($order->transaction_reference)
                                        <p class="mb-0" style="color: #cbd5e1 !important;">Referencia: {{ $order->transaction_reference }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('catalog') }}" class="btn gaming-font" style="
                    background: linear-gradient(45deg, #22d3ee, #6366f1);
                    border: none;
                    color: #0f172a;
                    font-weight: 700;
                    padding: 12px 30px;
                    border-radius: 12px;
                    letter-spacing: 1px;
                ">
                    <i class="bi bi-arrow-right me-2"></i> SEGUIR COMPRANDO
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .gaming-font {
        font-family: 'Orbitron', sans-serif;
    }
    
    .card {
        animation: fadeIn 0.6s ease-out;
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
    
    /* Forzar fondo oscuro en toda la tabla */
    .table,
    .table thead,
    .table tbody,
    .table tfoot,
    .table tr,
    .table td,
    .table th {
        background-color: transparent !important;
    }
    
    /* Forzar color blanco en textos de la tabla */
    .table td,
    .table th {
        color: #ffffff !important;
    }
</style>
@endsection