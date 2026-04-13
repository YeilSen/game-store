@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                    📜 HISTORIAL DE COMPRAS
                </h1>
                <p class="text-light" style="opacity: 0.8; font-size: 1rem;">
                    Usuario: <span style="color: #22d3ee;">{{ $user->name }}</span> ({{ $user->email }})
                </p>
            </div>

            {{-- Botones de navegación --}}
            <div class="d-flex justify-content-between mb-4 flex-wrap gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn" style="
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
                    <i class="bi bi-arrow-left"></i> Volver a Gestión de Usuarios
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="btn" style="
                    background: linear-gradient(45deg, #22d3ee, #6366f1);
                    border: none;
                    color: #0f172a;
                    font-weight: 600;
                    padding: 10px 20px;
                    border-radius: 10px;
                    transition: all 0.3s ease;
                ">
                    <i class="bi bi-receipt me-2"></i> Ver Todos los Pedidos
                </a>
            </div>

            @if($orders->isEmpty())
                <div class="card text-center py-5" style="
                    background: rgba(15, 23, 42, 0.7);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(99, 102, 241, 0.2);
                    border-radius: 20px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                ">
                    <div class="card-body">
                        <div class="mb-4" style="font-size: 4rem; color: rgba(34, 211, 238, 0.3);">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <h4 class="gaming-font mb-3" style="color: #e2e8f0;">
                            🛒 ESTE USUARIO NO TIENE COMPRAS REGISTRADAS
                        </h4>
                    </div>
                </div>
            @else
                <div class="card" style="
                    background: rgba(15, 23, 42, 0.7);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(99, 102, 241, 0.2);
                    border-radius: 20px;
                    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                ">
                    <div class="card-header border-0" style="
                        background: linear-gradient(45deg, rgba(34, 211, 238, 0.1), rgba(139, 92, 246, 0.1));
                        border-bottom: 1px solid rgba(99, 102, 241, 0.2);
                    ">
                        <h5 class="mb-0 gaming-font" style="color: #22d3ee;">
                            <i class="bi bi-clock-history me-2"></i> COMPRAS REALIZADAS ({{ $orders->total() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0" style="background: transparent !important;">
                                <thead>
                                    <tr style="background: rgba(34, 211, 238, 0.05); border-bottom: 2px solid rgba(99, 102, 241, 0.3);">
                                        <th style="color: #ffffff !important; padding: 15px;"># ORDEN</th>
                                        <th style="color: #ffffff !important; padding: 15px;">FECHA</th>
                                        <th style="color: #ffffff !important; padding: 15px; text-align: center;">JUEGOS</th>
                                        <th style="color: #ffffff !important; padding: 15px; text-align: right;">TOTAL</th>
                                        <th style="color: #ffffff !important; padding: 15px; text-align: center;">ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        {{-- Fila principal - clickeable --}}
                                        <tr style="border-bottom: 1px solid rgba(99, 102, 241, 0.1); cursor: pointer;" onclick="toggleDetail('orderDetail{{ $order->id }}')">
                                            <td style="padding: 15px; vertical-align: middle;">
                                                <span class="badge" style="
                                                    background: rgba(34, 211, 238, 0.2);
                                                    color: #22d3ee;
                                                    padding: 6px 12px;
                                                    border-radius: 8px;
                                                    font-size: 0.85rem;
                                                ">
                                                    {{ $order->order_number }}
                                                </span>
                                            </td>
                                            <td style="padding: 15px; vertical-align: middle;">
                                                <div class="d-flex flex-column">
                                                    <span style="color: #e2e8f0;">
                                                        <i class="bi bi-calendar3 me-2" style="color: #22d3ee;"></i>
                                                        {{ $order->created_at->format('d/m/Y') }}
                                                    </span>
                                                    <small style="color: #64748b;">{{ $order->created_at->format('H:i') }}</small>
                                                </div>
                                            </td>
                                            <td style="padding: 15px; text-align: center; vertical-align: middle;">
                                                <span class="badge" style="
                                                    background: rgba(139, 92, 246, 0.2);
                                                    color: #d8b4fe;
                                                    padding: 6px 12px;
                                                    border-radius: 8px;
                                                ">
                                                    {{ $order->items->count() }} juegos
                                                </span>
                                            </td>
                                            <td style="padding: 15px; text-align: right; vertical-align: middle;">
                                                <span style="color: #22d3ee; font-weight: 700;">
                                                    ${{ number_format($order->total_amount, 2) }}
                                                </span>
                                            </td>
                                            <td style="padding: 15px; text-align: center; vertical-align: middle;">
                                                @if($order->payment_status == 'paid')
                                                    <span class="badge" style="
                                                        background: rgba(34, 197, 94, 0.2);
                                                        color: #86efac;
                                                        padding: 5px 10px;
                                                    ">
                                                        <i class="bi bi-check-circle me-1"></i> Pagado
                                                    </span>
                                                @else
                                                    <span class="badge" style="
                                                        background: rgba(245, 158, 11, 0.2);
                                                        color: #fcd34d;
                                                        padding: 5px 10px;
                                                    ">
                                                        <i class="bi bi-clock me-1"></i> Pendiente
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        {{-- Fila de detalle colapsable --}}
                                        <tr class="order-detail-row" id="orderDetail{{ $order->id }}" style="display: none;">
                                            <td colspan="5" style="padding: 0; background: rgba(15, 23, 42, 0.5);">
                                                <div class="p-4">
                                                    <div class="row mb-4">
                                                        <div class="col-md-4">
                                                            <p class="mb-1" style="color: #94a3b8;">NÚMERO DE ORDEN</p>
                                                            <p class="fw-bold" style="color: #22d3ee;">{{ $order->order_number }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="mb-1" style="color: #94a3b8;">FECHA COMPLETA</p>
                                                            <p style="color: #e2e8f0;">{{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="mb-1" style="color: #94a3b8;">MÉTODO DE PAGO</p>
                                                            <p style="color: #e2e8f0;">
                                                                @if($order->payment_method == 'credit_card')
                                                                    <i class="bi bi-credit-card me-2"></i> Tarjeta
                                                                @else
                                                                    <i class="bi bi-bank me-2"></i> Transferencia
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <h6 style="color: #a855f7; margin-bottom: 15px;">
                                                        <i class="bi bi-controller me-2"></i> JUEGOS COMPRADOS
                                                    </h6>
                                                    <div class="table-responsive mb-4">
                                                        <table class="table" style="background: transparent;">
                                                            <thead>
                                                                <tr style="border-bottom: 1px solid rgba(99, 102, 241, 0.2); background: rgba(34, 211, 238, 0.05);">
                                                                    <th style="color: #cbd5e1; padding: 12px;">JUEGO</th>
                                                                    <th style="color: #cbd5e1; text-align: center; padding: 12px;">CANTIDAD</th>
                                                                    <th style="color: #cbd5e1; text-align: right; padding: 12px;">PRECIO UNITARIO</th>
                                                                    <th style="color: #cbd5e1; text-align: right; padding: 12px;">SUBTOTAL</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($order->items as $item)
                                                                @php
                                                                    $game = $item->game;
                                                                    $hasDiscount = false;
                                                                    $originalPrice = null;
                                                                    $discountPercent = 0;
                                                                    
                                                                    if($game && $game->has_discount && $game->discount_percent > 0) {
                                                                        $hasDiscount = true;
                                                                        $originalPrice = $game->price;
                                                                        $discountPercent = $game->discount_percent;
                                                                    }
                                                                    
                                                                    $unitPrice = $item->unit_price;
                                                                    $subtotal = $item->subtotal;
                                                                @endphp
                                                                <tr style="border-bottom: 1px solid rgba(99, 102, 241, 0.05);">
                                                                    <td style="padding: 12px;">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-shrink-0 me-3">
                                                                                <div style="width: 45px; height: 45px; border-radius: 10px; overflow: hidden; background: #1e293b;">
                                                                                    @if($game && $game->image_path)
                                                                                        <img src="{{ asset('storage/' . $game->image_path) }}" 
                                                                                             alt="{{ $game->name }}"
                                                                                             style="width: 100%; height: 100%; object-fit: cover;">
                                                                                    @else
                                                                                        <div class="d-flex align-items-center justify-content-center h-100">
                                                                                            <i class="bi bi-controller" style="color: #22d3ee;"></i>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <span style="color: #e2e8f0; font-weight: 600;">
                                                                                    {{ $game ? $game->name : 'Juego no disponible' }}
                                                                                </span>
                                                                                @if($hasDiscount)
                                                                                    <div class="mt-1">
                                                                                        <span class="badge" style="
                                                                                            background: rgba(239, 68, 68, 0.2);
                                                                                            color: #fecaca;
                                                                                            font-size: 0.7rem;
                                                                                        ">
                                                                                            -{{ $discountPercent }}% OFF
                                                                                        </span>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="text-align: center; padding: 12px; vertical-align: middle;">
                                                                        <span class="badge" style="
                                                                            background: rgba(34, 211, 238, 0.2);
                                                                            color: #22d3ee;
                                                                            padding: 6px 12px;
                                                                            border-radius: 20px;
                                                                        ">
                                                                            {{ $item->quantity }}
                                                                        </span>
                                                                    </td>
                                                                    <td style="text-align: right; padding: 12px; vertical-align: middle;">
                                                                        @if($hasDiscount)
                                                                            <div class="d-flex flex-column align-items-end">
                                                                                <small style="color: #94a3b8; font-size: 0.75rem; text-decoration: line-through;">
                                                                                    ${{ number_format($originalPrice, 2) }}
                                                                                </small>
                                                                                <span style="color: #22d3ee; font-weight: 600;">
                                                                                    ${{ number_format($unitPrice, 2) }}
                                                                                </span>
                                                                            </div>
                                                                        @else
                                                                            <span style="color: #22d3ee; font-weight: 600;">
                                                                                ${{ number_format($unitPrice, 2) }}
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td style="text-align: right; padding: 12px; vertical-align: middle;">
                                                                        @if($hasDiscount)
                                                                            <div class="d-flex flex-column align-items-end">
                                                                                <small style="color: #94a3b8; font-size: 0.75rem; text-decoration: line-through;">
                                                                                    ${{ number_format($originalPrice * $item->quantity, 2) }}
                                                                                </small>
                                                                                <span style="color: #22d3ee; font-weight: 700; font-size: 1rem;">
                                                                                    ${{ number_format($subtotal, 2) }}
                                                                                </span>
                                                                            </div>
                                                                        @else
                                                                            <span style="color: #22d3ee; font-weight: 700; font-size: 1rem;">
                                                                                ${{ number_format($subtotal, 2) }}
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr style="border-top: 1px solid rgba(99, 102, 241, 0.2); background: rgba(34, 211, 238, 0.05);">
                                                                    <td colspan="3" style="text-align: right; padding: 15px;">
                                                                        <strong style="color: #e2e8f0; font-size: 1.1rem;">TOTAL:</strong>
                                                                    </td>
                                                                    <td style="text-align: right; padding: 15px;">
                                                                        <span style="
                                                                            background: linear-gradient(45deg, #22d3ee, #6366f1);
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

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 style="color: #22c55e; margin-bottom: 10px;">
                                                                <i class="bi bi-person me-2"></i> FACTURACIÓN
                                                            </h6>
                                                            <div style="background: rgba(15, 23, 42, 0.4); padding: 12px; border-radius: 10px;">
                                                                <p class="mb-1" style="color: #e2e8f0;"><strong>{{ $order->billing_name }}</strong></p>
                                                                <p class="mb-0" style="color: #94a3b8;">{{ $order->billing_email }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 style="color: #a855f7; margin-bottom: 10px;">
                                                                <i class="bi bi-credit-card me-2"></i> MÉTODO DE PAGO
                                                            </h6>
                                                            <div style="background: rgba(15, 23, 42, 0.4); padding: 12px; border-radius: 10px;">
                                                                @if($order->payment_method == 'credit_card')
                                                                    <p class="mb-0" style="color: #e2e8f0;">
                                                                        <i class="bi bi-credit-card me-2"></i> Tarjeta de Crédito/Débito
                                                                    </p>
                                                                @else
                                                                    <p class="mb-0" style="color: #e2e8f0;">
                                                                        <i class="bi bi-bank me-2"></i> Transferencia Bancaria
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    {{-- Paginación --}}
                    <div class="card-footer border-0 p-4" style="background: transparent;">
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            @endif
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
    
    .table td,
    .table th {
        color: #ffffff !important;
    }
    
    /* Hover en filas clickeables */
    tbody tr:first-child {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    tbody tr:first-child:hover {
        background: rgba(34, 211, 238, 0.05) !important;
    }
    
    /* Paginación */
    .pagination {
        --bs-pagination-color: #22d3ee;
        --bs-pagination-bg: rgba(15, 23, 42, 0.7);
        --bs-pagination-border-color: rgba(99, 102, 241, 0.3);
        --bs-pagination-hover-color: #a5f3fc;
        --bs-pagination-hover-bg: rgba(34, 211, 238, 0.2);
        --bs-pagination-active-bg: #22d3ee;
        --bs-pagination-active-border-color: #22d3ee;
        --bs-pagination-disabled-bg: rgba(15, 23, 42, 0.5);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .gaming-font {
            font-size: 1.8rem !important;
        }
        
        .table-responsive {
            font-size: 0.8rem;
        }
        
        .badge {
            font-size: 0.7rem !important;
        }
        
        .btn {
            font-size: 0.8rem !important;
            padding: 8px 15px !important;
        }
        
        .table td, .table th {
            padding: 8px !important;
        }
    }
    
    @media (max-width: 576px) {
        .table-responsive {
            font-size: 0.7rem;
        }
        
        .badge {
            font-size: 0.6rem !important;
        }
        
        .btn {
            font-size: 0.7rem !important;
        }
    }
</style>

<script>
    function toggleDetail(detailId) {
        const detailRow = document.getElementById(detailId);
        if (detailRow) {
            if (detailRow.style.display === 'none' || detailRow.style.display === '') {
                detailRow.style.display = 'table-row';
            } else {
                detailRow.style.display = 'none';
            }
        }
    }
</script>
@endsection