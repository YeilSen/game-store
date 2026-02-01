@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center shadow-lg border-success">
                <div class="card-header bg-success text-white">
                    <h2 class="mb-0">¡Pago Confirmado!</h2>
                </div>
                <div class="card-body">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    <p class="mt-3 fs-5">
                        Tu compra ha sido procesada exitosamente. Como no requerimos un ticket, ¡la confirmación está completa!
                    </p>
                    <hr>
                    <p class="text-muted">
                        Gracias por tu compra. Revisa tu perfil para más detalles (aunque por ahora no guardamos historial).
                    </p>
                    <a href="{{ route('catalog') }}" class="btn btn-primary mt-3">Volver al Catálogo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection