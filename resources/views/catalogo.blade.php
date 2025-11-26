@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-6 text-red-600">Catálogo de motos</h2>

    <form method="GET" action="{{ route('catalogo') }}" class="flex flex-wrap gap-4 items-center mb-6">
        <input type="text" name="brand" value="{{ request('brand') }}" placeholder="Marca" class="border rounded px-3 py-2">
        <input type="text" name="model" value="{{ request('model') }}" placeholder="Modelo" class="border rounded px-3 py-2">
        <input type="number" name="year" value="{{ request('year') }}" placeholder="Año" class="border rounded px-3 py-2">
        <input type="number" name="km_max" value="{{ request('km_max') }}" placeholder="Km máx." class="border rounded px-3 py-2">
        <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Precio mín." class="border rounded px-3 py-2">
        <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Precio máx." class="border rounded px-3 py-2">
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Filtrar</button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($motos as $moto)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                @if($moto->image)
                    <img src="{{ asset('storage/' . $moto->image) }}"
                         alt="{{ $moto->title }}"
                         class="h-40 w-full object-cover rounded">
                @else
                    <div class="h-40 bg-gray-300 flex items-center justify-center rounded">
                        <span class="text-gray-600">Sin imagen</span>
                    </div>
                @endif

                <h3 class="font-bold text-lg mt-2">{{ $moto->title }}</h3>
                <p class="text-gray-600">{{ $moto->brand }} - {{ $moto->model }}</p>
                <p class="text-red-600 font-bold mt-2">€{{ number_format($moto->price_eur, 0, ',', '.') }}</p>

                <a href="{{ route('moto.ficha', $moto->slug) }}"
                   class="mt-3 inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                   Ver detalles
                </a>
            </div>
        @empty
            <p class="text-gray-600">No se encontraron motos con los filtros seleccionados.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $motos->links() }}
    </div>
</div>
@endsection