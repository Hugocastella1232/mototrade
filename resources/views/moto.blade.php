@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6">
    <h2 class="text-3xl font-bold text-red-600 mb-6">{{ $moto->title }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            @if($moto->image)
                <img src="{{ asset('storage/' . $moto->image) }}" 
                     alt="{{ $moto->title }}" 
                     class="w-full h-64 object-cover rounded-lg mb-4">
            @else
                <div class="h-64 bg-gray-300 flex items-center justify-center rounded">
                    <span class="text-gray-600">Sin imágenes</span>
                </div>
            @endif
        </div>

        <div>
            <p><span class="font-bold">Marca:</span> {{ $moto->brand }}</p>
            <p><span class="font-bold">Modelo:</span> {{ $moto->model }}</p>
            <p><span class="font-bold">Año:</span> {{ $moto->year }}</p>
            <p><span class="font-bold">Kilómetros:</span> {{ number_format($moto->km, 0, ',', '.') }} km</p>
            <p><span class="font-bold">Potencia:</span> {{ $moto->power_hp }} cv</p>
            <p><span class="font-bold">Cilindrada:</span> {{ $moto->displacement_cc }} cc</p>
            <p><span class="font-bold">Combustible:</span> {{ ucfirst($moto->fuel) }}</p>
            <p><span class="font-bold">Estado:</span> {{ ucfirst($moto->listing_condition) }}</p>

            <p class="text-3xl text-red-600 font-bold mt-4">
                €{{ number_format($moto->price_eur, 0, ',', '.') }}
            </p>

            <form action="{{ route('carrito.add', $moto->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Añadir al carrito
                </button>
            </form>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-xl font-bold mb-2">Descripción</h3>
        <p class="text-gray-700">{{ $moto->description }}</p>
    </div>

    <div class="mt-8">
        <h3 class="text-xl font-bold mb-4">¿Tienes alguna pregunta?</h3>
        <form action="{{ route('lead.store', $moto->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block">Tu nombre</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block">Tu email</label>
                <input type="email" name="email" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block">Mensaje</label>
                <textarea name="message" class="w-full border p-2 rounded" rows="4" required></textarea>
            </div>
            <button type="submit" 
                    class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
                Enviar pregunta
            </button>
        </form>
    </div>
</div>
@endsection