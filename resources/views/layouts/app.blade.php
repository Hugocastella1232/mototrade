<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Moto Trade') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-white text-black">
    <header class="bg-red-600 text-white">
        <div class="w-full px-4 py-4 grid grid-cols-3 items-center">
            <div class="flex items-center space-x-6 justify-self-start">
                <div class="bg-white rounded p-1 inline-flex items-center justify-center">
                    <img src="{{ asset('logo.png') }}" alt="Moto Trade" class="h-10 w-auto">
                </div>
                <span class="font-bold text-xl">Moto Trade</span>
            </div>
            <nav class="justify-self-center flex space-x-12">
                <a href="{{ route('catalogo') }}" class="hover:underline font-bold">Catálogo</a>
                @auth
                    <a href="{{ route('listings.create') }}" class="hover:underline font-bold">Vender moto</a>
                @endauth
            </nav>
            <div class="justify-self-end flex items-center space-x-3">
                @auth
                    @php $isAdmin = auth()->user()->is_admin ?? false; @endphp
                    <a href="{{ $isAdmin ? route('admin.dashboard') : route('profile.edit') }}" class="hover:underline font-bold">Mi cuenta</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="hover:underline font-bold">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline font-bold">Iniciar sesión</a>
                    <span class="opacity-50">|</span>
                    <a href="{{ route('register') }}" class="hover:underline font-bold">Registrarse</a>
                @endauth
            </div>
        </div>
    </header>
    <div class="max-w-7xl mx-auto px-4">
        @if(session('success'))
            <div class="mt-4 bg-green-100 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mt-4 bg-red-100 text-red-800 px-4 py-2 rounded">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <main class="flex-1 max-w-7xl mx-auto p-6">
        {{ $slot ?? '' }}
        @yield('content')
    </main>
    @include('layouts.footer')
</body>
</html>