@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">

    <h1 class="gaming-font mb-5" style="color:#22d3ee;">
        📊 ESTADÍSTICAS GAMER
    </h1>

    <div class="row">

        <div class="col-md-6">
            <div class="card p-4">
                <h4>Total Gastado</h4>
                <h2 style="color:#22d3ee;">
                    ${{ number_format($totalSpent,2) }}
                </h2>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4">
                <h4>Órdenes</h4>
                <h2 style="color:#a855f7;">
                    {{ $totalOrders }}
                </h2>
            </div>
        </div>

    </div>

</div>
@endsection