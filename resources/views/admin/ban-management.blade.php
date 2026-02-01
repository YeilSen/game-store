<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Baneos (Temporal)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Mensajes de Estado -->
                @if (session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <h3 class="text-lg font-medium text-gray-900 mb-4">Desbanear Usuario por Email</h3>

                <form method="POST" action="{{ route('admin.bans.unban') }}" class="flex space-x-4 items-center">
                    @csrf
                    <input type="email" name="email" placeholder="Email del usuario a desbanear" 
                           required class="border-gray-300 rounded-md shadow-sm w-full max-w-sm">
                    
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Desbanear
                    </button>
                </form>

                <p class="mt-4 text-sm text-gray-600">
                    Nota: El sistema de baneo es temporal y se almacena en caché/DB de forma automática por 10 minutos. 
                    Esta herramienta fuerza el desbaneo inmediato.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>