@extends('layouts.app')

@section('title', 'sUAM — Galerías')

@section('content')
    <div class="bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Encabezado Principal Hero --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        Galerías
                    </h1>
                    <p class="text-gray-600 text-base sm:text-lg mt-3">
                        Explora nuestras colecciones fotográficas.
                    </p>
                </div>
                <div
                    class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>

            {{-- Buscador --}}
            <form action="{{ route('galerias.index') }}" method="GET"
                class="bg-white rounded-3xl p-4 border border-gray-100 shadow-sm flex gap-3">
                <input
                    type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar galería..."
                    class="flex-1 rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brandgreen/50 focus:border-brandgreen"
                >
                <button type="submit"
                    class="px-5 py-2.5 bg-navy hover:bg-navy/90 text-white font-bold rounded-xl transition-colors">
                    Buscar
                </button>
                @if(request('buscar'))
                    <a href="{{ route('galerias.index') }}"
                        class="px-5 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-500 font-bold rounded-xl transition-colors">
                        Limpiar
                    </a>
                @endif
            </form>

            {{-- Grid de Tarjetas de Galerías --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($galerias as $galeria)
                    <a href="{{ route('galerias.show', $galeria) }}"
                        class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden flex flex-col group">

                        {{-- Imagen Principal --}}
                        <div class="h-52 w-full bg-gray-100 relative overflow-hidden">
                            @if($galeria->imagenes->isNotEmpty())
                                <img src="{{ $galeria->imagenes->first()->url }}" alt="{{ $galeria->titulo }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Badge cantidad de fotos --}}
                            <span
                                class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm text-navy text-[10px] font-bold uppercase tracking-wide px-3 py-1 rounded-full shadow-sm">
                                {{ $galeria->imagenes_count }} {{ Str::plural('foto', $galeria->imagenes_count) }}
                            </span>
                        </div>

                        {{-- Información de la Galería --}}
                        <div class="p-6 flex flex-col flex-grow space-y-3">
                            <h3 class="font-black text-navy text-lg leading-tight line-clamp-2 group-hover:text-brandgreen transition-colors">
                                {{ $galeria->titulo }}
                            </h3>

                            @if($galeria->descripcion)
                                <p class="text-gray-500 line-clamp-3 flex-grow">
                                    {{ Str::limit(strip_tags($galeria->descripcion), 120) }}
                                </p>
                            @endif

                            <span
                                class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-gray-50 group-hover:bg-navy text-navy group-hover:text-white font-bold rounded-xl transition-colors border border-gray-100 group-hover:border-navy mt-2">
                                Ver galería
                            </span>
                        </div>
                    </a>
                @empty
                    <div
                        class="col-span-full bg-white rounded-3xl p-10 text-center border border-gray-100 shadow-sm flex flex-col items-center justify-center space-y-3">
                        <div class="p-4 bg-gray-50 rounded-full text-gray-400 mb-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-navy font-bold text-lg">No hay registros aún</p>
                        <p class="text-gray-400">
                            {{ request('buscar') ? 'No se encontraron galerías para "' . request('buscar') . '".' : 'Aún no se han registrado galerías en la plataforma.' }}
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($galerias->hasPages())
                <div class="pt-4">
                    {{ $galerias->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection