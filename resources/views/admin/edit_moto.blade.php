@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold mb-6">Editar moto</h1>

    <form method="POST" action="{{ route('admin.motos.update', $moto->id) }}">
        @csrf
        @method('PUT')

        <label class="block mb-2">Título</label>
        <input type="text" name="title" value="{{ $moto->title }}" class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">Marca</label>
        <input type="text" name="brand" value="{{ $moto->brand }}" class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">Modelo</label>
        <input type="text" name="model" value="{{ $moto->model }}" class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">Año</label>
        <input type="number" name="year" value="{{ $moto->year }}" class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">Kilómetros</label>
        <input type="number" name="km" value="{{ $moto->km }}" class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">Potencia (cv)</label>
        <input type="number" name="power_hp" value="{{ $moto->power_hp }}" class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">Cilindrada (cc)</label>
        <input type="number" name="displacement_cc" value="{{ $moto->displacement_cc }}" class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">Combustible</label>
        <input type="text" name="fuel" value="{{ $moto->fuel }}" class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">Estado</label>
        <input type="text" name="listing_condition" value="{{ $moto->listing_condition }}" class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">Precio (€)</label>
        <input type="number" name="price_eur" value="{{ $moto->price_eur }}" class="w-full border p-2 rounded mb-4">

        <label class="block mb-2">Descripción</label>
        <textarea name="description" class="w-full border p-2 rounded mb-6" rows="4">{{ $moto->description }}</textarea>

        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Guardar cambios
        </button>
    </form>
</div>
@endsection