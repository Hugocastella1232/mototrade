@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Panel de Administración</h2>
<ul class="space-y-2">
    <li>Total usuarios: {{ $stats['usuarios'] }}</li>
    <li>Total motos publicadas: {{ $stats['motos'] }}</li>
    <li>Total ventas simuladas: {{ $stats['ventas'] }}</li>
    <li>Consultas de clientes: {{ $stats['leads'] }}</li>
</ul>
@endsection