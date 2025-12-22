@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-6">
    <h1 class="text-2xl font-bold mb-6">Gestión de motos</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
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
                        <form action="{{ route('admin.listings.updateStatus', $moto->id) }}" method="POST">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1">
                                @if($moto->status === 'pending')
                                    <option value="pending" selected>Pending</option>
                                    <option value="approved">Approved</option>
                                @elseif($moto->status === 'approved')
                                    <option value="approved" selected>Approved</option>
                                @elseif($moto->status === 'sold_pending')
                                    <option value="sold_pending" selected>Sold pending</option>
                                    <option value="sold">Sold</option>
                                @elseif($moto->status === 'sold')
                                    <option value="sold" selected>Sold</option>
                                @endif
                            </select>
                        </form>
                    </td>

                    <td class="p-3 flex gap-3">
                        @if($moto->status !== 'sold')
                            <a href="{{ route('admin.motos.edit', $moto->id) }}" class="text-blue-600 hover:underline">Editar</a>

                            <form action="{{ route('admin.motos.destroy', $moto->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
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