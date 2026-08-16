@extends('layouts.app')

@section('content')
    <div class="bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">
        {{-- Flex container para el sidebar y el contenido principal --}}
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-8">

            {{-- ASIDE: Menú Lateral de Años --}}
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm sticky top-8">
                    <h2 class="text-xl font-black text-navy mb-4 tracking-tight">Filtrar por Año</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('publicaciones.index') }}"
                               class="block px-4 py-2 rounded-xl text-sm font-medium transition-colors 
                               {{ !request('year') ? 'bg-navy text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                                Todos
                            </a>
                        </li>
                        @foreach($anios as $anio)
                            <li>
                                <a href="{{ route('publicaciones.index', ['year' => $anio]) }}"
                                   class="block px-4 py-2 rounded-xl text-sm font-medium transition-colors 
                                   {{ request('year') == $anio ? 'bg-navy text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                                    {{ $anio }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            {{-- CONTENIDO PRINCIPAL --}}
            <div class="flex-1 space-y-8">

                {{-- Encabezado Principal Hero --}}
                <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                    <div class="relative z-10 max-w-2xl">
                        <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                            Publicaciones {{ request('year') ? 'del ' . request('year') : '' }}
                        </h1>
                        <p class="text-gray-600 text-base sm:text-lg mt-3">
                            Lee nuestras últimas publicaciones, novedades y contenido de interés.
                        </p>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                    </div>
                </div>

                {{-- Grid de Tarjetas de Artículos --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($publicaciones as $publicacion)
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden flex flex-col group">

                            {{-- Imagen Principal --}}
                            <div class="h-52 w-full bg-gray-100 relative overflow-hidden">
                                @if($publicacion->foto)
                                    <img src="{{ Storage::url($publicacion->foto) }}" alt="{{ $publicacion->nombre }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Badge de categoría --}}
                                @if($publicacion->categoria)
                                    <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm text-navy text-[10px] font-bold uppercase tracking-wide px-3 py-1 rounded-full shadow-sm">
                                        {{ $publicacion->categoria }}
                                    </span>
                                @endif
                            </div>

                            {{-- Información del Artículo --}}
                            <div class="p-6 flex flex-col flex-grow space-y-3">
                                {{-- Fecha y tiempo de lectura --}}
                                <div class="flex items-center gap-2 text-[11px] text-gray-400 font-medium">
                                    <span>{{ $publicacion->created_at->translatedFormat('d \d\e F, Y') }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span>{{ ceil(str_word_count(strip_tags($publicacion->contenido)) / 200) }} min de lectura</span>
                                </div>

                                <h3 class="font-black text-navy text-lg leading-tight line-clamp-2">
                                    {{ $publicacion->titulo }}
                                </h3>

                                {{-- Contenido truncado sin etiquetas HTML --}}
                                <p class="text-gray-500 line-clamp-3 flex-grow">
                                    {{ Str::limit(strip_tags($publicacion->contenido), 120) }}
                                </p>

                                {{-- Autor --}}
                                @if($publicacion->autor)
                                    <div class="flex items-center gap-2 text-gray-500 font-medium pt-1">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ $publicacion->autor }}
                                    </div>
                                @endif

                                <a href="{{ route('publicaciones.show', $publicacion) }}"
                                   class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-gray-50 hover:bg-navy text-navy hover:text-white font-bold rounded-xl transition-colors border border-gray-100 group-hover:border-navy mt-2">
                                    Leer completo
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl p-10 text-center border border-gray-100 shadow-sm flex flex-col items-center justify-center space-y-3">
                            <div class="p-4 bg-gray-50 rounded-full text-gray-400 mb-2">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <p class="text-navy font-bold text-lg">No hay registros aún</p>
                            <p class="text-gray-400">
                                {{ request('year') ? 'No se encontraron publicaciones para el año '.request('year').'.' : 'Aún no se han registrado publicaciones en la plataforma.' }}
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- Paginación --}}
                @if($publicaciones->hasPages())
                    <div class="pt-4">
                        {{ $publicaciones->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection