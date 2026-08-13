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

            {{-- Migas de pan (Breadcrumbs) y Volver --}}
            <div class="flex items-center justify-between">
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center gap-2  font-bold text-navy hover:text-brandgreen transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver</span>
                </a>

                {{-- Categoría / Área de formación --}}
                @if ($curso->areaFormacion)
                    <a href="{{ route('areas.show', $curso->areaFormacion) }}"
                        class="inline-block  font-bold border rounded-full px-3.5 py-1 bg-white text-brandgreen border-brandgreen/30 hover:bg-brandgreen hover:text-white transition-colors shadow-sm">
                        {{ $curso->areaFormacion->nombre }}
                    </a>
                @endif
            </div>

            {{-- CONTENEDOR PRINCIPAL DOS COLUMNAS --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- COLUMNA IZQUIERDA: Detalles del Curso (8 columnas) --}}
                <div class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-sm space-y-8">

                    {{-- Encabezado del Curso --}}
                    <div class="space-y-3 pb-6 border-b border-gray-100">
                        <h1 class="text-2xl sm:text-4xl font-black text-navy leading-tight">
                            {{ $curso->nombre }}
                        </h1>
                        @if ($curso->subtitulo)
                            <p class=" sm:text-base text-gray-500 font-medium">
                                {{ $curso->subtitulo }}
                            </p>
                        @endif
                    </div>

                    {{-- Rejilla de Información Rápida --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 bg-gray-50 p-5 rounded-2xl border border-gray-100">

                        {{-- Duración --}}
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-white text-navy rounded-xl shadow-sm border border-gray-100">
                                <svg class="w-5 h-5 text-brandgreen" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <span
                                    class="text-[10px] sm: text-gray-400 font-medium block uppercase tracking-wider">Duración</span>
                                <span
                                    class=" font-bold text-navy">{{ $curso->duracion ?? 'Por definir' }}</span>
                            </div>
                        </div>

                        {{-- Modalidad --}}
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-white text-navy rounded-xl shadow-sm border border-gray-100">
                                <svg class="w-5 h-5 text-brandgreen" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9" />
                                </svg>
                            </div>
                            <div>
                                <span
                                    class="text-[10px] sm: text-gray-400 font-medium block uppercase tracking-wider">Modalidad</span>
                                <span
                                    class=" font-bold text-navy uppercase">{{ $curso->modalidad ?? 'Presencial' }}</span>
                            </div>
                        </div>

                        {{-- Horarios / Fechas --}}
                        <div class="flex items-center gap-3 col-span-2 sm:col-span-1">
                            <div class="p-2.5 bg-white text-navy rounded-xl shadow-sm border border-gray-100">
                                <svg class="w-5 h-5 text-brandgreen" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <span
                                    class="text-[10px] sm: text-gray-400 font-medium block uppercase tracking-wider">Horario</span>
                                <span
                                    class=" font-bold text-navy">{{ $curso->horario ?? 'Consultar' }}</span>
                            </div>
                        </div>

                    </div>

                    {{-- Contenido TinyMCE procesado --}}
                    <div class="space-y-4">
                        <h2 class="text-lg font-extrabold text-navy uppercase tracking-wider">
                            Descripción General y Temario
                        </h2>

                        <div
                            class="text-gray-700  sm:text-base leading-relaxed space-y-4
                                [&_a]:inline-flex [&_a]:items-center [&_a]:justify-center [&_a]:gap-2
                                [&_a]:bg-brandgreen [&_a]:text-white [&_a]:font-bold [&_a]: [&_a]:uppercase [&_a]:tracking-wider
                                [&_a]:px-5 [&_a]:py-3 [&_a]:rounded-xl [&_a]:shadow-md [&_a]:shadow-brandgreen/20
                                hover:[&_a]:bg-navy hover:[&_a]:shadow-navy/20 hover:[&_a]:-translate-y-0.5
                                [&_a]:transition-all [&_a]:duration-200 [&_a]:no-underline
                                [&_strong]:font-bold [&_strong]:text-navy
                                [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5">
                            {!! $curso->descripcion !!}
                        </div>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: Imagen/Promoción + Inscripción (4 columnas - Sticky) --}}
                <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-8">

                    {{-- Tarjeta de Inscripción / Acción --}}
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-6">

                        {{-- Imagen Portada si existe --}}
                        @if ($curso->url_imagen)
                            <div @click="lightboxOpen = true"
                                class="rounded-2xl overflow-hidden bg-gray-100 border border-gray-100 relative group cursor-pointer">
                                <img src="{{ $curso->url_imagen }}" alt="{{ $curso->nombre }}"
                                    class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">

                                <div
                                    class="absolute inset-0 bg-navy/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white font-bold  gap-2 backdrop-blur-xs">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                    <span>Ver cartel completo</span>
                                </div>
                            </div>
                        @endif

                        {{-- Costo / Precio --}}
                        <div class="border-b border-gray-100 pb-4 text-center">
                            <span class=" text-gray-400 font-bold uppercase tracking-wider block">Costo</span>
                            <div class="text-3xl font-black text-navy mt-1">
                                @if ($curso->precio && $curso->precio > 0)
                                    ${{ number_format($curso->precio, 2) }} <span
                                        class=" font-normal text-gray-400">MXN</span>
                                @else
                                    <span class="text-brandgreen">Gratuito</span>
                                @endif
                            </div>
                        </div>

                        {{-- Botón de Acción Principal --}}
                        @if ($convocatoriaActiva)
                            {{-- Hay una convocatoria vigente: mostramos el enlace directo a sus bases/registro --}}
                            <a href="{{ route('convocatorias.show', $convocatoriaActiva) }}"
                                class="w-full py-3 px-6 bg-brandgreen hover:bg-navy text-white font-bold  rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-brandgreen/20">
                                <span>Convocatoria abierta</span>
                            </a>
                        @else
                            {{-- No hay convocatorias activas en este momento --}}
                            <button type="button" disabled
                                class="w-full py-3 px-6 bg-gray-100 text-gray-400 font-bold  rounded-xl cursor-not-allowed border border-gray-200 flex items-center justify-center gap-2">
                                <span>Sin inscripciones abiertas por el momento</span>
                            </button>
                        @endif

                        {{-- Info adicional rápida --}}
                        <ul class=" text-gray-500 space-y-2.5 pt-2">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-brandgreen shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Entrega de constancia</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-brandgreen shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Cupo limitado</span>
                            </li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>

        {{-- LIGHTBOX / MODAL PARA MOSTRAR IMAGEN COMPLETA --}}
        @if ($curso->url_imagen)
            <template x-teleport="body">
                <div x-show="lightboxOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-8 bg-black/90 backdrop-blur-md"
                    style="display: none;">

                    <button type="button" @click="lightboxOpen = false"
                        class="absolute top-5 right-5 z-10 text-white/70 hover:text-white p-3 rounded-full bg-white/10 hover:bg-white/20 transition-all focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="absolute inset-0" @click="lightboxOpen = false"></div>

                    <div class="relative z-10 max-w-5xl max-h-[90vh] overflow-hidden rounded-2xl shadow-2xl flex items-center justify-center"
                        x-show="lightboxOpen" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95">

                        <img src="{{ $curso->url_imagen }}" alt="{{ $curso->nombre }}"
                            class="max-w-full max-h-[90vh] object-contain rounded-2xl">
                    </div>
                </div>
            </template>
        @endif

    </div>
@endsection
