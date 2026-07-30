@extends('layouts.app')

@section('title', 'SUAM — Inicio')

@section('content')

    <!-- HERO MEJORADO -->
    <section x-data="{
        activeSlide: 0,
        slides: @js($slides),
        {{-- Laravel convierte tu variable de BD a JSON automáticamente --}}
        interval: null,
        init() {
            if (this.slides.length > 1) {
                this.startAutoplay();
            }
        },
        startAutoplay() {
            this.interval = setInterval(() => {
                this.next();
            }, 5000);
        },
        resetAutoplay() {
            clearInterval(this.interval);
            this.startAutoplay();
        },
        next() {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
        },
        prev() {
            this.activeSlide = this.activeSlide === 0 ? this.slides.length - 1 : this.activeSlide - 1;
        }
    }" class="relative rounded-2xl overflow-hidden bg-gray-100 shadow-sm">

        @if (!empty($slides) && $slides->count() > 0)
            {{-- SLIDES --}}
            <div class="relative min-h-[480px] sm:min-h-[400px]">
                <template x-for="(slide, index) in slides" :key="slide.id || index">
                    <div x-show="activeSlide === index" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 transform translate-x-4"
                        x-transition:enter-end="opacity-100 transform translate-x-0"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform translate-x-0"
                        x-transition:leave-end="opacity-0 transform -translate-x-4"
                        class="absolute inset-0 grid grid-cols-1 md:grid-cols-2 gap-0 h-full w-full">

                        {{-- Contenido (Texto y Botones) --}}
                        <div class="p-6 sm:p-10 flex flex-col justify-center gap-5 order-2 md:order-1 bg-gray-100">
                            <h1 class="text-3xl sm:text-5xl font-extrabold leading-tight text-navy" x-html="slide.nombre">
                            </h1>

                            <template x-if="slide.contenido">
                                <div class="text-gray-600 text-base max-w-sm space-y-3
                [&_a]:inline-flex [&_a]:items-center [&_a]:justify-center [&_a]:gap-2
                [&_a]:bg-brandgreen [&_a]:text-white [&_a]:font-bold [&_a]:text-xs [&_a]:uppercase [&_a]:tracking-wider
                [&_a]:px-5 [&_a]:py-2.5 [&_a]:rounded-xl [&_a]:shadow-md [&_a]:shadow-brandgreen/20
                hover:[&_a]:bg-navy hover:[&_a]:shadow-navy/20 hover:[&_a]:-translate-y-0.5
                [&_a]:transition-all [&_a]:duration-200 [&_a]:no-underline"
                                    x-html="slide.contenido"></div>
                            </template>
                        </div>

                        {{-- Contenedor de la Imagen (Adaptada al 100%) --}}
                        <div
                            class="h-64 md:h-full bg-gradient-to-br from-navy/10 to-navy/30 overflow-hidden order-1 md:order-2 relative">
                            {{-- Soporta tanto 'url_imagen' (calculado) como 'imagen' directa --}}
                            <img :src="slide.url_imagen || slide.imagen" :alt="slide.titulo_alt || 'Imagen de slide'"
                                class="w-full h-full object-cover object-center" />
                        </div>

                    </div>
                </template>
            </div>

            {{-- BOTONES NAVEGACIÓN (Solo se muestran si hay más de 1 slide) --}}
            <template x-if="slides.length > 1">
                <div>
                    <button @click="prev(); resetAutoplay()"
                        class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-navy p-2 rounded-full shadow-md backdrop-blur-sm transition z-10 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="next(); resetAutoplay()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-navy p-2 rounded-full shadow-md backdrop-blur-sm transition z-10 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </template>

            {{-- INDICADORES (Solo se muestran si hay más de 1 slide) --}}
            <template x-if="slides.length > 1">
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index; resetAutoplay()"
                            :class="activeSlide === index ? 'bg-brandgreen w-6' : 'bg-gray-300 hover:bg-gray-400 w-2.5'"
                            class="h-2.5 rounded-full transition-all duration-300 focus:outline-none"></button>
                    </template>
                </div>
            </template>
        @else
            {{-- ESTADO VACÍO (Si la variable está vacía desde el controlador) --}}
            <div class="p-12 text-center text-gray-500">
                No hay diapositivas disponibles por el momento.
            </div>
        @endif

    </section>

    <!-- ÁREAS DE FORMACIÓN -->
    <section>
        <h2 class="text-lg font-bold text-navy mb-4">Áreas de formación</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">

            @forelse ($areas as $item)
                <div
                    class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col items-center text-center gap-2 shadow-sm hover:shadow-md transition">

                    {{-- Círculo con el fondo dinámico de la BD --}}
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center shrink-0 shadow-sm"
                        style="background-color: {{ $item->color ?? '#0284c7' }};">

                        {{-- ICONO 100% BLANCO --}}
                        <x-heroicon :name="$item->icono" class="w-6 h-6 sm:w-7 sm:h-7 text-white" />

                    </div>

                    <div class="text-xs font-semibold text-navy leading-tight mt-1">
                        {{ $item->nombre }}
                    </div>

                    <a href="{{ route('areas.show', $item) }}" class="text-[11px] text-brandgreen font-semibold hover:underline">
                        Ver cursos →
                    </a>
                </div>
            @empty
                <p class="text-xs text-gray-500 col-span-full text-center">No hay áreas disponibles por el momento.</p>
            @endforelse



        </div>
    </section>

    <div class="grid grid-cols-1  gap-8">
        <!-- CONVOCATORIAS -->
        <section class="md:col-span-2">
            <h2 class="text-lg font-bold text-navy mb-4">Convocatorias</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @forelse ($convocatorias as $item)
                    <div class="bg-white border border-gray-100 rounded-xl p-4 flex gap-3 shadow-sm">
                        <div class="w-10 h-10 rounded-md bg-navy/10 flex items-center justify-center text-navy shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-navy">{{ $item->nombre }}</div>
                            <span
                                class="inline-block text-[10px] font-semibold border rounded-full px-2.5 py-0.5 mt-1 {{ $item->estado_inscripcion['badge'] }}">
                                {{ $item->estado_inscripcion['texto'] }}
                            </span>
                            <p class="text-[11px] text-gray-400 mt-1">{{ $item->rango_fechas }}</p>
                            <a href="{{ route('convocatorias.show', $item) }}" class="text-[11px] text-brandgreen font-semibold hover:underline">Ver detalle
                                →</a>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-500 col-span-full text-center">No hay convocatorias disponibles por el
                        momento.</p>
                @endforelse
            </div>
        </section>
    </div>

    <!-- SEDES -->
    <section>
        <h2 class="text-lg font-bold text-navy">Nuestras sedes</h2>
        <p class="text-xs text-gray-400 mb-4">Conéctate con sedes en diferentes municipios de Jalisco.</p>
        <div class="space-y-6">
            {{-- Grid de Tarjetas (1 columna en móvil, 2 en tablet, 3 en pantallas grandes) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($sedes as $item)
                    <div
                        class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 flex flex-col justify-between">

                        {{-- Contenedor de la Imagen / Logo --}}
                        <div class="relative h-48 bg-gray-50 flex items-center justify-center p-4 border-b border-gray-100">
                            <img src="{{ $item->url_logo }}" class="max-h-full max-w-full object-contain"
                                alt="Logo-{{ $item->slug }}" />
                        </div>

                        {{-- Detalles de la Sede --}}
                        <div class="p-5 flex-grow">
                            <h3 class="font-bold text-gray-800 text-lg mb-2 leading-snug">
                                {{ $item->nombre }}
                            </h3>
                            <div class="flex items-start text-sm text-gray-600 space-x-2">
                                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $item->direccion }}</span>
                            </div>

                            {{-- Teléfono (si existe en tu modelo) --}}
                            @if (!empty($item->telefono))
                                <div class="flex items-center text-sm text-gray-600 space-x-2">
                                    <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ $item->telefono }}</span>
                                </div>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-white p-8 text-center rounded-xl border border-gray-100">
                        <h3 class="text-gray-500 font-medium text-base">Aún no hay sedes registradas.</h3>
                    </div>
                @endforelse
            </div>

            {{-- Botón para ver todas --}}
            @if ($sedes->isNotEmpty())
                <div class="text-center pt-2">
                    <a href="{{ route('sedes.index') }}"
                        class="bg-navy text-white text-sm font-semibold px-5 py-2.5 rounded-md hover:bg-navy-dark transition-colors inline-block">
                        Ver todas las sedes
                    </a>
                </div>
            @endif
        </div>
    </section>

@endsection
