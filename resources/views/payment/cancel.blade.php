@extends('layouts.app')

@section('content')
<div class="text-center py-10">
    <h2 class="text-2xl font-bold text-red-600 mb-4">❌ Pago cancelado</h2>
    <p>No se ha realizado ningún cargo. Puedes intentar nuevamente.</p>
    <a href="{{ route('checkout') }}" class="mt-6 inline-block bg-gray-500 text-white px-4 py-2 rounded">
        Volver al checkout
    </a>
</div>
@endsection