@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Añadir moto</h2>

<form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
        <label for="title" class="block">Título</label>
        <input type="text" name="title" id="title" class="border p-2 w-full" required>
    </div>

    <div>
        <label for="brand" class="block">Marca</label>
        <input type="text" name="brand" id="brand" class="border p-2 w-full" required>
    </div>

    <div>
        <label for="model" class="block">Modelo</label>
        <input type="text" name="model" id="model" class="border p-2 w-full" required>
    </div>

    <div>
        <label for="year" class="block">Año</label>
        <input type="number" name="year" id="year" class="border p-2 w-full" required>
    </div>

    <div>
        <label for="km" class="block">Kilometraje</label>
        <input type="number" name="km" id="km" class="border p-2 w-full" required>
    </div>

    <div>
        <label for="power_hp" class="block">Potencia (HP)</label>
        <input type="number" name="power_hp" id="power_hp" class="border p-2 w-full">
    </div>

    <div>
        <label for="displacement_cc" class="block">Cilindrada (cc)</label>
        <input type="number" name="displacement_cc" id="displacement_cc" class="border p-2 w-full">
    </div>

    <div>
        <label for="fuel" class="block">Combustible</label>
        <input type="text" name="fuel" id="fuel" class="border p-2 w-full">
    </div>

    <div>
        <label for="listing_condition" class="block">Condición</label>
        <select name="listing_condition" id="listing_condition" class="border p-2 w-full">
            <option value="nueva">Nueva</option>
            <option value="usada">Usada</option>
            <option value="seminueva">Seminueva</option>
        </select>
    </div>

    <div>
        <label for="price_eur" class="block">Precio (€)</label>
        <input type="number" name="price_eur" id="price_eur" class="border p-2 w-full" required>
    </div>

    <div>
        <label for="location" class="block">Ubicación</label>
        <input type="text" name="location" id="location" class="border p-2 w-full" required>
    </div>

    <div>
        <label for="description" class="block">Descripción</label>
        <textarea name="description" id="description" rows="4" class="border p-2 w-full"></textarea>
    </div>

    <div>
        <label for="image" class="block">Imagen de la moto</label>
        <input type="file" name="image" id="image" class="border p-2 w-full">
    </div>

    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
        Publicar moto
    </button>
</form>
@endsection