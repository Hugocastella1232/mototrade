@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto py-8 px-6">
    <h1 class="text-2xl font-bold mb-6">Gestión de motos</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
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
                    <td class="p-3">{{ $moto->user->name ?? '—' }}</td>
                    <td class="p-3">{{ number_format($moto->price_eur, 0, ',', '.') }}</td>

                    <td class="p-3">
                        @if($moto->status === \App\Models\Listing::STATUS_PENDING)
                            <form action="{{ route('admin.listings.updateStatus', $moto->id) }}" method="POST">
                                @csrf
                                <select name="status"
                                        onchange="this.form.submit()"
                                        class="bg-yellow-100 text-yellow-800 border border-yellow-300 rounded px-2 py-1 text-sm font-semibold">
                                    <option value="pending" selected>Pendiente</option>
                                    <option value="approved">Aprobada</option>
                                </select>
                            </form>

                        @elseif($moto->status === \App\Models\Listing::STATUS_APPROVED)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                Aprobada
                            </span>

                        @elseif($moto->status === \App\Models\Listing::STATUS_SOLD_PENDING)
                            <form action="{{ route('admin.listings.updateStatus', $moto->id) }}" method="POST">
                                @csrf
                                <select name="status"
                                        onchange="this.form.submit()"
                                        class="bg-blue-100 text-blue-800 border border-blue-300 rounded px-2 py-1 text-sm font-semibold">
                                    <option value="sold_pending" selected>Venta pendiente</option>
                                    <option value="sold">Vendida</option>
                                </select>
                            </form>

                        @elseif($moto->status === \App\Models\Listing::STATUS_SOLD)
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                Vendida
                            </span>
                        @endif
                    </td>

                    <td class="p-3 flex gap-3">
                        @if($moto->status !== \App\Models\Listing::STATUS_SOLD)
                            <a href="{{ route('admin.motos.edit', $moto->id) }}"
                               class="text-blue-600 hover:underline">
                                Editar
                            </a>

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

    <div class="mt-4">
        {{ $motos->links() }}
    </div>
</div>
@endsection