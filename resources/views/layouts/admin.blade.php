<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Aquí puedes incluir tu CSS, Tailwind, etc. -->
    <!-- Si usas Vite: @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <style>
        /* Estilos básicos para el ejemplo */
        body { font-family: sans-serif; background-color: #f4f7f9; }
        .admin-sidebar { background-color: #2d3748; color: white; }
    </style>
</head>
<body>
    <div class="flex h-screen">
        <!-- Sidebar/Menú de navegación del administrador (opcional) -->
        <aside class="admin-sidebar w-64 p-4 shadow-lg">
            <h2 class="text-2xl font-bold mb-6">Admin Panel</h2>
            <nav>
                <!-- Asegúrate de que estas rutas existan en routes/web.php si las usas -->
                <a href="{{ route('admin.users.index') }}" class="block py-2 hover:bg-gray-700 rounded transition duration-150">Gestión de Usuarios</a>
                <a href="{{ route('admin.bans.index') }}" class="block py-2 bg-gray-600 rounded mt-1">Usuarios Baneados</a>
                <a href="{{ route('admin.logs.index') }}" class="block py-2 hover:bg-gray-700 rounded mt-1">Logs de Sesión</a>
            </nav>
        </aside>

        <!-- Contenido Principal -->
        <main class="flex-1 p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>