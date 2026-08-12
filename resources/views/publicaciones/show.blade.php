@extends('layouts.app')

@section('content')
    <div class="bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-8">

            {{-- Botón regresar --}}
            <a href="{{ route('publicaciones.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-navy transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Volver a artículos
            </a>

            {{-- Imagen Destacada --}}
            @if ($publicacion->foto)
                <div class="w-full h-64 sm:h-96 relative rounded-3xl overflow-hidden shadow-sm bg-gray-900">
                    <img src="{{ Storage::url($publicacion->foto) }}" alt="{{ $publicacion->nombre }}"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/40 to-transparent"></div>
                </div>
            @endif

            {{-- Contenido del Artículo --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-10 space-y-6">

                {{-- Encabezado (Título, Fecha, Tiempo de lectura) --}}
                <div class="border-b border-gray-100 pb-6 space-y-4">
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        {{ $publicacion->nombre }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-gray-500 text-xs sm:text-sm font-medium">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-brandorange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $publicacion->created_at->translatedFormat('d \d\e F, Y') }}
                        </div>

                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-brandorange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ ceil(str_word_count(strip_tags($publicacion->contenido)) / 200) }} min de lectura
                        </div>
                    </div>
                </div>

                {{-- Cuerpo del Contenido --}}
                <div class="text-gray-600 prose prose-sm sm:prose-base prose-navy max-w-none">
                    {!! $publicacion->contenido !!}
                </div>
            </div>

            {{-- Archivos adjuntos --}}
            @if (!empty($publicacion->archivos) && is_array($publicacion->archivos) && count($publicacion->archivos) > 0)
                <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-sm space-y-5">
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                        <div class="p-2.5 bg-brandorange/10 text-brandorange rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H8a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-navy tracking-tight">
                            Archivos adjuntos
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($publicacion->archivos as $archivo)
                            @php
                                $extension = strtoupper(pathinfo($archivo, PATHINFO_EXTENSION));
                                $nombreArchivo = basename($archivo);
                            @endphp
                            <a href="{{ Storage::url($archivo) }}" target="_blank" download
                                class="flex items-center gap-3 p-4 rounded-2xl border border-gray-100 bg-gray-50 hover:bg-navy hover:border-navy transition-colors group">
                                <div class="w-10 h-10 shrink-0 rounded-xl bg-white group-hover:bg-white/10 flex items-center justify-center text-navy group-hover:text-white text-[10px] font-black border border-gray-200 group-hover:border-white/20">
                                    {{ $extension }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-navy group-hover:text-white truncate">
                                        {{ $nombreArchivo }}
                                    </p>
                                    <p class="text-xs text-gray-400 group-hover:text-white/60">
                                        Descargar archivo
                                    </p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Artículos relacionados --}}
            @if(isset($relacionados) && $relacionados->count() > 0)
                <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-sm space-y-6">
                    <h3 class="text-xl font-extrabold text-navy tracking-tight">
                        Otros artículos que te pueden interesar
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        @foreach($relacionados as $relacionado)
                            <a href="{{ route('publicaciones.show', $relacionado) }}" class="group block">
                                <div class="h-32 w-full bg-gray-100 rounded-2xl overflow-hidden mb-3">
                                    @if($relacionado->foto)
                                        <img src="{{ Storage::url($relacionado->foto) }}" alt="{{ $relacionado->nombre }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @endif
                                </div>
                                <h4 class="font-bold text-navy text-sm leading-tight line-clamp-2 group-hover:text-brandgreen transition-colors">
                                    {{ $relacionado->nombre }}
                                </h4>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection