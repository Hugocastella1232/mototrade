@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Checkout</h2>
<form action="{{ route('checkout.session') }}" method="POST" class="space-y-4">
    @csrf
    <input type="text" name="name" placeholder="Nombre" class="border p-2 w-full" required>
    <input type="email" name="email" placeholder="Email" class="border p-2 w-full" required>
    <input type="text" name="address" placeholder="Dirección" class="border p-2 w-full" required>
    <input type="text" name="phone" placeholder="Teléfono" class="border p-2 w-full" required>
    <input type="text" name="dni" placeholder="DNI" class="border p-2 w-full" required>

    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
        Finalizar compra ({{ number_format($total, 2) }} €)
    </button>
</form>
@endsection