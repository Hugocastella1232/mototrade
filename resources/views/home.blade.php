@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4 text-red-600">Motos destacadas</h2>

    <div class="swiper mySwiper w-full">
        <div class="swiper-wrapper">
            @foreach($motos as $moto)
                <div class="swiper-slide bg-white rounded-lg shadow hover:shadow-lg transition p-4 relative">
                    @if($moto->image)
                        <img src="{{ asset('storage/' . $moto->image) }}"
                             alt="{{ $moto->title }}"
                             class="h-40 w-full object-cover rounded">
                    @endif

                    @if($moto->status === 'sold_pending')
                        <div class="absolute inset-0 bg-red-600 bg-opacity-50 rounded-lg"></div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rotate-[-15deg] bg-white px-8 py-2 text-xl font-bold text-black">
                            VENDIDA
                        </div>
                    @endif

                    <h3 class="font-bold text-lg mt-2">{{ $moto->title }}</h3>
                    <p class="text-gray-600">{{ $moto->brand }} - {{ $moto->model }}</p>
                    <p class="text-red-600 font-bold mt-2">
                        €{{ number_format($moto->price_eur, 0, ',', '.') }}
                    </p>

                    <a href="{{ route('moto.ficha', $moto->slug) }}"
                       class="mt-3 inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                       Ver detalles
                    </a>
                </div>
            @endforeach
        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</div>
@endsection