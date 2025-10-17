@extends('layouts.app')

@section('content')
<div class="text-center py-10">
    <h2 class="text-2xl font-bold text-green-600 mb-4">✅ Pago completado con éxito</h2>
    <p>Gracias por tu compra. Nos pondremos en contacto contigo pronto.</p>
    <a href="{{ route('home') }}" class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded">
        Volver al inicio
    </a>
</div>
@endsection