@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-8">

            {{-- Botón regresar --}}
            <a href="{{ route('publicaciones.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-navy transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Volver a artículos
            </a>

            {{-- Imagen Destacada --}}
            @if ($articulo->imagen)
                <div class="w-full h-64 sm:h-96 relative rounded-3xl overflow-hidden shadow-sm bg-gray-900">
                    <img src="{{ Storage::url($articulo->imagen) }}" alt="{{ $articulo->titulo }}"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/40 to-transparent"></div>

                    @if($articulo->categoria)
                        <span class="absolute top-5 left-5 bg-white/95 backdrop-blur-sm text-navy text-[10px] font-bold uppercase tracking-wide px-3 py-1.5 rounded-full shadow-sm">
                            {{ $articulo->categoria }}
                        </span>
                    @endif
                </div>
            @endif

            {{-- Contenido del Artículo --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-10 space-y-6">

                {{-- Encabezado (Título, Autor, Fecha, Tiempo de lectura) --}}
                <div class="border-b border-gray-100 pb-6 space-y-4">
                    @if(!$articulo->imagen && $articulo->categoria)
                        <span class="inline-block bg-brandgreen/10 text-brandgreen text-[10px] font-bold uppercase tracking-wide px-3 py-1 rounded-full">
                            {{ $articulo->categoria }}
                        </span>
                    @endif

                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        {{ $articulo->titulo }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-gray-500 text-xs sm:text-sm font-medium">
                        @if($articulo->autor)
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brandorange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $articulo->autor }}
                            </div>
                        @endif

                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-brandorange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $articulo->created_at->translatedFormat('d \d\e F, Y') }}
                        </div>

                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-brandorange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ ceil(str_word_count(strip_tags($articulo->contenido)) / 200) }} min de lectura
                        </div>
                    </div>
                </div>

                {{-- Cuerpo del Contenido --}}
                <div class="text-gray-600 prose prose-sm sm:prose-base prose-navy max-w-none">
                    {!! $articulo->contenido !!}
                </div>
            </div>

            {{-- Artículos relacionados --}}
            @if(isset($relacionados) && $relacionados->count() > 0)
                <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-sm space-y-6">
                    <h3 class="text-xl font-extrabold text-navy tracking-tight">
                        Otros artículos que te pueden interesar
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        @foreach($relacionados as $relacionado)
                            <a href="{{ route('articulos.show', $relacionado) }}" class="group block">
                                <div class="h-32 w-full bg-gray-100 rounded-2xl overflow-hidden mb-3">
                                    @if($relacionado->imagen)
                                        <img src="{{ Storage::url($relacionado->imagen) }}" alt="{{ $relacionado->titulo }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @endif
                                </div>
                                <h4 class="font-bold text-navy text-sm leading-tight line-clamp-2 group-hover:text-brandgreen transition-colors">
                                    {{ $relacionado->titulo }}
                                </h4>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection