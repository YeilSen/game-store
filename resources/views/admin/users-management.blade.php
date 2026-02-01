<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios y Eliminación') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensajes de Éxito o Error --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-2">{{ __('Lista de Usuarios Registrados') }}</h3>

                <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    {{ __('ID') }}
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    {{ __('Nombre') }}
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    {{ __('Bloqueo Temporal') }}
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    {{ __('Baneo Permanente') }}
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    {{ __('Acciones') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ $user->id }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $user->name }}
                                    </td>
                                    {{-- 🔑 NUEVA COLUMNA: Estado de Bloqueo Temporal (por intentos fallidos) 🔑 --}}
                                    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium">
                                        {{-- El campo banned_until no debe ser nulo y debe ser una fecha futura --}}
                                        @if ($user->banned_until && $user->banned_until->isFuture())
                                            <span class="inline-flex items-center rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-semibold text-orange-800">
                                                Bloqueado hasta: {{ $user->banned_until->format('H:i:s') }}
                                            </span>
                                            <p class="text-xs text-gray-500 mt-1">Intentos fallidos: {{ $user->failed_attempts }}</p>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                Libre
                                            </span>
                                        @endif
                                    </td>
                                    {{-- Columna de Baneo Permanente --}}
                                    <td class="whitespace-nowrap px-3 py-4 text-sm font-semibold">
                                        @if (isset($user->is_banned) && $user->is_banned)
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">
                                                Permanentemente
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                                No Baneado
                                            </span>
                                        @endif
                                    </td>

                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 space-x-2">
                                        
                                        {{-- 1. BOTÓN DE QUITAR BLOQUEO TEMPORAL (Solo visible si está bloqueado) --}}
                                        @if ($user->banned_until && $user->banned_until->isFuture())
                                            <form action="{{ route('admin.users.unban-temp', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="text-white rounded-md p-2 text-xs transition duration-150 ease-in-out bg-blue-600 hover:bg-blue-700">
                                                    Quitar Bloqueo Temp
                                                </button>
                                            </form>
                                        @endif

                                        {{-- 2. BOTÓN DE BANEAR/DESBANEAR PERMANENTE --}}
                                        @if (isset($user->is_banned))
                                            <form action="{{ route('admin.users.toggle-ban', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="text-white rounded-md p-2 text-xs transition duration-150 ease-in-out"
                                                        style="background-color: {{ $user->is_banned ? '#28a745' : '#dc3545' }}">
                                                    {{ $user->is_banned ? 'Desbanear Perm.' : 'Banear Perm.' }}
                                                </button>
                                            </form>
                                        @endif

                                        {{-- 3. BOTÓN DE ELIMINAR PERMANENTEMENTE --}}
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('ADVERTENCIA: ¿Estás seguro de que quieres ELIMINAR permanentemente la cuenta de {{ $user->name }}? Esta acción es irreversible.');">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="submit" 
                                                    class="text-white rounded-md p-2 text-xs transition duration-150 ease-in-out bg-gray-600 hover:bg-gray-700">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-lg text-gray-500">
                                        No se encontraron usuarios para gestionar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Muestra los enlaces de paginación --}}
                <div class="mt-6">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>