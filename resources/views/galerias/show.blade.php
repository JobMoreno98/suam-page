@extends('layouts.app')

@section('title', $galeria->titulo . ' — sUAM')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.3.1/dist/css/glightbox.min.css">
@endpush

@section('content')
    <div class="bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto space-y-8">

            {{-- Botón regresar --}}
            <a href="{{ route('galerias.index') }}" class="inline-flex items-center gap-1.5 font-semibold text-gray-500 hover:text-navy transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Volver a galerías
            </a>

            {{-- Imagen Destacada --}}
            @if(!empty($galeria->imagenes))
                <div class="w-full h-64 sm:h-96 relative rounded-3xl overflow-hidden shadow-sm bg-gray-900">
                    <img src="{{ $galeria->imagenes[0]->url }}" alt="{{ $galeria->titulo }}"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/60 via-navy/10 to-transparent"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-10">
                        <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
                            {{ $galeria->titulo }}
                        </h1>
                        <div class="flex items-center gap-1.5 text-white/80 font-medium mt-3">
                            <svg class="w-4 h-4 text-brandorange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ count($galeria->imagenes) }} {{ Str::plural('foto', count($galeria->imagenes)) }}
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-10">
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        {{ $galeria->titulo }}
                    </h1>
                </div>
            @endif

            {{-- Descripción --}}
            @if($galeria->descripcion)
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-10">
                    <p class="text-gray-600 leading-relaxed text-base sm:text-lg">
                        {{ $galeria->descripcion }}
                    </p>
                </div>
            @endif

            {{-- Grid de imágenes (GLightbox) --}}
            @if(empty($galeria->imagenes))
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-10 text-center">
                    <div class="p-4 bg-gray-50 rounded-full text-gray-400 mb-3 inline-flex">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-navy font-bold text-lg">Esta galería aún no tiene imágenes</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                    @foreach($galeria->imagenes as $ruta)
                        <a
                            href="{{ $ruta->url }}"
                            class="glightbox aspect-square w-full rounded-2xl overflow-hidden relative group block shadow-sm"
                            data-gallery="galeria-{{ $galeria->id }}"
                            data-title="{{ $galeria->titulo }}"
                        >
                            <img
                                src="{{ $ruta->url }}"
                                alt="{{ $galeria->titulo }}"
                                loading="lazy"
                                class="w-full h-full object-cover transition duration-500 group-hover:scale-110"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/70 via-navy/0 to-navy/0 opacity-0 group-hover:opacity-100 transition duration-300"></div>

                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <div class="w-10 h-10 rounded-full bg-white/90 flex items-center justify-center shadow-sm">
                                    <svg class="w-4.5 h-4.5 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 8v5m-2.5-2.5h5" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Galerías relacionadas --}}
            @if(isset($relacionadas) && $relacionadas->count() > 0)
                <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-sm space-y-6">
                    <h3 class="text-xl font-extrabold text-navy tracking-tight">
                        Otras galerías que te pueden interesar
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        @foreach($relacionadas as $relacionada)
                            <a href="{{ route('galerias.show', $relacionada) }}" class="group block">
                                <div class="h-32 w-full bg-gray-100 rounded-2xl overflow-hidden mb-3">
                                    @if(!empty($relacionada->imagenes))
                                        <img src="{{ $relacionada->imagenes[0]->url }}" alt="{{ $relacionada->titulo }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @endif
                                </div>
                                <h4 class="font-bold text-navy leading-tight line-clamp-2 group-hover:text-brandgreen transition-colors">
                                    {{ $relacionada->titulo }}
                                </h4>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/glightbox@3.3.1/dist/js/glightbox.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                zoomable: true,
                draggable: true,
                descPosition: 'bottom',
            });
        });
    </script>
@endpush