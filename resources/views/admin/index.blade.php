@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Panel de administración</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow-md rounded-xl p-6 hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-2">Gestión de motos</h2>
            <p class="text-gray-600 mb-4">Edita o elimina las motos publicadas en el catálogo.</p>
            <a href="{{ route('admin.motos') }}" 
               class="inline-block bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
               Ir a listado de motos
            </a>
        </div>

        <div class="bg-white shadow-md rounded-xl p-6 hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-2">Gestión de usuarios</h2>
            <p class="text-gray-600 mb-4">Elimina usuarios registrados en la plataforma.</p>
            <a href="{{ route('admin.usuarios') }}" 
               class="inline-block bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
               Ir a listado de usuarios
            </a>
        </div>
    </div>

    <div class="mt-8 text-gray-500 text-sm">
        <p>Acceso exclusivo para administradores.</p>
    </div>
</div>
@endsection