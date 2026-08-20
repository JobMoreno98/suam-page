@extends('layouts.app')

@section('title', 'sUAM — Testimonios')

@section('content')
    <div class="bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Encabezado --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        Testimonios
                    </h1>
                    <p class="text-gray-600 text-base sm:text-lg mt-3">
                        Conoce las experiencias de quienes han formado parte de nuestro programa
                    </p>
                </div>
                <div
                    class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>

            {{-- LISTA DE TESTIMONIOS (ancho completo) --}}
            <div class="flex flex-col gap-6">
                @forelse($testimonios ?? [] as $testimonio)
                    <div x-data="{ expanded: false, isLong: {{ Str::length(strip_tags($testimonio->contenido)) > 260 ? 'true' : 'false' }} }"
                        class="w-full bg-white rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col md:flex-row group">

                        {{-- Foto: alto fijo en desktop, no se estira aunque el texto crezca --}}
                        <div class="md:w-64 w-full h-56 md:h-[400px] bg-gray-100 relative overflow-hidden shrink-0 self-start">
                            <img src="{{ $testimonio->primera_foto }}" alt="{{ $testimonio->nombre }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>

                        {{-- Contenido --}}
                        <div class="p-6 sm:p-8 flex flex-col justify-between flex-1 space-y-4">
                            <div class="space-y-3">
                                {{-- Comillas decorativas --}}
                                <svg class="w-8 h-8 text-brandgreen/30" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z" />
                                </svg>

                                {{-- Texto del testimonio (HTML de TinyEditor): se recorta a 4 líneas si es largo, con toggle --}}
                                <div class="prose prose-sm max-w-none  sm:text-base text-gray-600 leading-relaxed italic transition-all duration-200"
                                    :class="{ 'line-clamp-4': isLong && !expanded }">
                                    {!! $testimonio->contenido !!}
                                </div>

                                <button x-show="isLong" @click="expanded = !expanded" type="button"
                                    class=" font-bold text-brandgreen hover:underline inline-flex items-center gap-1">
                                    <span x-text="expanded ? 'Ver menos' : 'Ver más'"></span>
                                    <svg class="w-3 h-3 transition-transform" :class="expanded ? 'rotate-180' : ''"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Galería mixta (imágenes/videos) --}}
                                @include('components.testimonio-galeria', ['testimonio' => $testimonio])
                            </div>

                            <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                <div>
                                    <h3 class="text-base font-bold text-navy">
                                        {{ $testimonio->nombre }}
                                    </h3>
                                    <span class=" font-semibold text-gray-400 uppercase tracking-wider">
                                        {{ $testimonio->nombre_alumno ?? 'Alumno(a) SUAM' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-200">
                        <p class="text-gray-500 font-medium">Aún no hay testimonios publicados.</p>
                    </div>
                @endforelse
            </div>

        </div>

    </div>
@endsection