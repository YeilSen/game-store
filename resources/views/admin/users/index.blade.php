@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-warning">Panel de Gestión de Usuarios</h1>
    <a href="{{ route('catalog') }}" class="btn btn-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Volver al Catálogo
    </a>

    {{-- Mensajes de estado --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($users->isEmpty())
        <div class="alert alert-info text-center">No hay usuarios registrados para gestionar (aparte de los administradores).</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de Registro</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                {{-- Formulario para eliminar (dar de baja/eliminar) al usuario --}}
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    {{-- Laravel usa el método PATCH o DELETE para esta acción --}}
                                    @method('DELETE') 
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('¿Estás seguro de que quieres eliminar a este usuario? Esta acción es irreversible.');">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection