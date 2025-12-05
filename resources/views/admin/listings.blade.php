@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-6">
    <h1 class="text-2xl font-bold mb-6">Gestión de motos</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <table class="w-full bg-white shadow rounded-lg">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Título</th>
                <th class="p-3">Marca</th>
                <th class="p-3">Usuario</th>
                <th class="p-3">Precio (€)</th>
                <th class="p-3">Estado</th>
                <th class="p-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($motos as $moto)
                <tr class="border-b">
                    <td class="p-3">{{ $moto->title }}</td>
                    <td class="p-3">{{ $moto->brand }}</td>
                    <td class="p-3">{{ $moto->user->name ?? 'Desconocido' }}</td>
                    <td class="p-3">{{ number_format($moto->price_eur, 2) }}</td>

                    <td class="p-3">
                        @if($moto->status === \App\Models\Listing::STATUS_APPROVED)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Aprobada</span>

                        @elseif($moto->status === \App\Models\Listing::STATUS_REJECTED)
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">Rechazada</span>

                        @elseif($moto->status === \App\Models\Listing::STATUS_SOLD)
                            <span class="bg-gray-300 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">Vendida</span>

                        @else
                            <div class="relative inline-block text-left">
                                <button onclick="toggleMenu({{ $moto->id }})"
                                        class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold hover:bg-yellow-200">
                                    Pendiente ⌄
                                </button>
                                <div id="menu-{{ $moto->id }}"
                                     class="hidden absolute mt-1 bg-white border border-gray-200 rounded shadow-lg z-10 w-32">
                                    <form action="{{ route('admin.approve', $moto->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-3 py-1 text-green-600 hover:bg-green-50">Aprobar</button>
                                    </form>
                                    <form action="{{ route('admin.reject', $moto->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-3 py-1 text-red-600 hover:bg-red-50">Rechazar</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </td>

                    <td class="p-3 flex flex-wrap gap-2">
                        <a href="{{ route('admin.motos.edit', $moto->id) }}"
                           class="text-blue-600 hover:underline">Editar</a>

                        @if($moto->status !== \App\Models\Listing::STATUS_SOLD)
                            <form action="{{ route('admin.motos.destroy', $moto->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('¿Eliminar esta moto?')"
                                        class="text-red-600 hover:underline">
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $motos->links() }}</div>
</div>

<script>
function toggleMenu(id) {
    document.getElementById(`menu-${id}`).classList.toggle('hidden');
}
</script>
@endsection