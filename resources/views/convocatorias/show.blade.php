@extends('layouts.app')

@section('content')
    <div class=" bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8" x-data="{
        copiado: false,
        lightboxOpen: false,
        copiarEnlace() {
            navigator.clipboard.writeText(window.location.href);
            this.copiado = true;
            setTimeout(() => this.copiado = false, 2500);
        }
    }"
        @keydown.escape.window="lightboxOpen = false">

        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Migas de pan (Breadcrumbs) y Botón Volver --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('convocatorias.index') }}"
                    class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-navy hover:text-brandgreen transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver a convocatorias</span>
                </a>

                {{-- Badge de Estado --}}
                <span
                    class="inline-block text-xs font-bold border rounded-full px-3.5 py-1 shadow-sm bg-white {{ $convocatoria->estado_inscripcion['badge'] }}">
                    {{ $convocatoria->estado_inscripcion['texto'] }}
                </span>
            </div>

            {{-- CONTENEDOR PRINCIPAL DOS COLUMNAS --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- COLUMNA IZQUIERDA: Cartel e Imagen (4 columnas - Sticky) --}}
                <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-8">

                    <div class="bg-white rounded-3xl p-4 border border-gray-100 shadow-sm space-y-4">
                        <span class="text-xs font-bold text-navy uppercase tracking-wider block px-2 pt-2">
                            Cartel Oficial
                        </span>

                        {{-- Imagen / Cartel interactivo --}}
                        <div @click="lightboxOpen = true"
                            class="rounded-2xl overflow-hidden bg-gray-100 border border-gray-100 relative group cursor-pointer">
                            <img src="{{ $convocatoria->url_imagen }}" alt="{{ $convocatoria->nombre }}"
                                class="w-full h-auto object-cover transition-transform duration-300 group-hover:scale-105">

                            {{-- Hover Overlay --}}
                            <div
                                class="absolute inset-0 bg-navy/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white font-bold text-xs gap-2 backdrop-blur-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                                <span>Ampliar cartel</span>
                            </div>
                        </div>
                    </div>

                    {{-- CTA Principal: Inscripciones (solo si la convocatoria está abierta) --}}
                    @if ($convocatoria->estado_inscripcion['estado'] == 'abierta')
                        <a href="https://inscripciones.suam.udg.mx" target="_blank" rel="noopener noreferrer"
                            class="flex items-center justify-center gap-2 bg-brandgreen hover:bg-navy text-white font-bold text-sm rounded-2xl px-6 py-4 shadow-lg shadow-brandgreen/20 hover:shadow-navy/20 hover:-translate-y-0.5 transition-all duration-200">
                            <span>Ir al Portal de Inscripciones</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    @endif

                </div>

                {{-- COLUMNA DERECHA: Contenido Principal (8 columnas) --}}
                <div class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-sm space-y-8">

                    {{-- Header de la Convocatoria --}}
                    <div class="space-y-3 pb-6 border-b border-gray-100">
                        <h1 class="text-2xl sm:text-4xl font-black text-navy leading-tight">
                            {{ $convocatoria->nombre }}
                        </h1>
                        <p class="text-xs text-gray-400">
                            Publicado el
                            {{ $convocatoria->created_at?->locale('es')->translatedFormat('j \d\e F \d\e Y') ?? 'recientemente' }}
                        </p>
                    </div>

                    {{-- Fechas destacadas --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <div class="flex items-start gap-3">
                            <div class="p-2.5 bg-white text-navy rounded-xl shadow-sm border border-gray-100">
                                <svg class="w-5 h-5 text-brandgreen" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-medium block">Periodo de registro</span>
                                <span class="text-sm font-bold text-navy">{{ $convocatoria->rango_fechas }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="p-2.5 bg-white text-navy rounded-xl shadow-sm border border-gray-100">
                                <svg class="w-5 h-5 text-brandgreen" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-medium block">Inicio de clases</span>
                                <span
                                    class="text-sm font-bold text-navy">{{ $convocatoria->fecha_registro_formateada }}</span>
                            </div>
                        </div>

                    </div>

                    {{-- Contenido TinyMCE --}}
                    <div class="space-y-4">
                        <h2 class="text-lg font-extrabold text-navy uppercase tracking-wider">
                            Bases y Detalle de la Convocatoria
                        </h2>

                        <div
                            class="text-gray-700 text-sm sm:text-base leading-relaxed space-y-4
                                [&_a]:inline-flex [&_a]:items-center [&_a]:justify-center [&_a]:gap-2
                                [&_a]:bg-brandgreen [&_a]:text-white [&_a]:font-bold [&_a]:text-xs [&_a]:uppercase [&_a]:tracking-wider
                                [&_a]:px-5 [&_a]:py-3 [&_a]:rounded-xl [&_a]:shadow-md [&_a]:shadow-brandgreen/20
                                hover:[&_a]:bg-navy hover:[&_a]:shadow-navy/20 hover:[&_a]:-translate-y-0.5
                                [&_a]:transition-all [&_a]:duration-200 [&_a]:no-underline
                                [&_strong]:font-bold [&_strong]:text-navy
                                [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5">
                            {!! $convocatoria->contenido !!}
                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- LIGHTBOX / VISOR TIPO GALERÍA --}}
        <template x-teleport="body">
            <div x-show="lightboxOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-8 bg-black/90 backdrop-blur-md"
                style="display: none;">

                {{-- Botón Cerrar (Esquina Superior Derecha) --}}
                <button type="button" @click="lightboxOpen = false"
                    class="absolute top-5 right-5 z-10 text-white/70 hover:text-white p-3 rounded-full bg-white/10 hover:bg-white/20 transition-all focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                {{-- Fondo Clic para Cerrar --}}
                <div class="absolute inset-0" @click="lightboxOpen = false"></div>

                {{-- Contenedor de Imagen con escala --}}
                <div class="relative z-10 max-w-5xl max-h-[90vh] overflow-hidden rounded-2xl shadow-2xl flex items-center justify-center"
                    x-show="lightboxOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95">

                    <img src="{{ $convocatoria->url_imagen }}" alt="{{ $convocatoria->nombre }}"
                        class="max-w-full max-h-[90vh] object-contain rounded-2xl">
                </div>

            </div>
        </template>

    </div>
@endsection