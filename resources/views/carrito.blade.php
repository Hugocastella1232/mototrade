@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Carrito</h2>

@if(count($carrito) > 0)
    <ul class="space-y-4">
        @foreach($carrito as $id => $item)
            <li class="bg-white shadow p-4 rounded flex justify-between items-center">
                <div>
                    <span class="font-bold">{{ $item['title'] }}</span>
                    <span class="text-gray-600"> - €{{ number_format($item['price_eur'], 2) }}</span>
                    <span class="ml-2">Cantidad: {{ $item['quantity'] }}</span>
                </div>

                <form action="{{ route('carrito.remove', $id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">
                        Eliminar
                    </button>
                </form>
            </li>
        @endforeach
    </ul>

    <div class="mt-6 text-right">
        <p class="text-lg font-bold">
            Total: €{{ number_format(collect($carrito)->sum(fn($item) => $item['price_eur'] * $item['quantity']), 2) }}
        </p>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
        <form action="{{ route('carrito.clear') }}" method="POST">
            @csrf
            <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Vaciar carrito
            </button>
        </form>

        <form action="{{ route('checkout') }}" method="GET">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Pagar
            </button>
        </form>
    </div>
@else
    <p>No tienes motos en el carrito.</p>
@endif
@endsection