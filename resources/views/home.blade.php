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

    <!-- CARD ÁREA DE FORMACIÓN MEJORADA -->
    <!-- La tarjeta completa es un enlace para facilitar el clic -->
    <a href=""
        class="group bg-white border border-gray-200 rounded-2xl p-5 flex flex-col items-center text-center gap-3 shadow-sm hover:shadow-md hover:border-brandgreen transition-all">
        <div
            class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>
        </div>
        <!-- Texto más legible -->
        <div class="text-sm font-bold text-navy leading-snug">
            Salud y desarrollo
        </div>
        <span class="text-xs text-brandgreen font-bold group-hover:underline flex items-center gap-1">
            Ver cursos
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </span>
    </a>

    <!-- ÁREAS DE FORMACIÓN -->
    <section>
        <h2 class="text-lg font-bold text-navy mb-4">Áreas de formación</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">

            <div
                class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col items-center text-center gap-2 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </div>
                <div class="text-xs font-semibold text-navy leading-tight">Salud y desarrollo</div>
                <a href="" class="text-[11px] text-brandgreen font-semibold hover:underline">Ver cursos →</a>
            </div>

            <div
                class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col items-center text-center gap-2 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div class="text-xs font-semibold text-navy leading-tight">Humanidades</div>
                <a href="" class="text-[11px] text-brandgreen font-semibold hover:underline">Ver cursos →</a>
            </div>

            <div
                class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col items-center text-center gap-2 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <div class="text-xs font-semibold text-navy leading-tight">Agricultura orgánica y plantas</div>
                <a href="" class="text-[11px] text-brandgreen font-semibold hover:underline">Ver cursos →</a>
            </div>

            <div
                class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col items-center text-center gap-2 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center text-sky-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                    </svg>
                </div>
                <div class="text-xs font-semibold text-navy leading-tight">Cómputo e idiomas</div>
                <a href="" class="text-[11px] text-brandgreen font-semibold hover:underline">Ver cursos →</a>
            </div>

            <div
                class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col items-center text-center gap-2 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                    </svg>
                </div>
                <div class="text-xs font-semibold text-navy leading-tight">Arte y recreación</div>
                <a href="" class="text-[11px] text-brandgreen font-semibold hover:underline">Ver cursos →</a>
            </div>

        </div>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- CONVOCATORIAS -->
        <section class="md:col-span-2">
            <h2 class="text-lg font-bold text-navy mb-4">Convocatorias vigentes</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white border border-gray-100 rounded-xl p-4 flex gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-md bg-navy/10 flex items-center justify-center text-navy shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-navy">Ciclo 2026-B</div>
                        <span
                            class="inline-block text-[10px] font-semibold bg-green-100 text-green-700 rounded-full px-2 py-0.5 mt-1">Inscripciones
                            abiertas</span>
                        <p class="text-[11px] text-gray-400 mt-1">Del 10 al 14 de agosto de 2026</p>
                        <a href="" class="text-[11px] text-brandgreen font-semibold hover:underline">Ver detalle
                            →</a>
                    </div>
                </div>
                <div class="bg-white border border-gray-100 rounded-xl p-4 flex gap-3 shadow-sm">
                    <div class="w-10 h-10 rounded-md bg-navy/10 flex items-center justify-center text-navy shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-navy">Ciclo 2027-A</div>
                        <span
                            class="inline-block text-[10px] font-semibold bg-orange-100 text-orange-600 rounded-full px-2 py-0.5 mt-1">Próximamente</span>
                        <p class="text-[11px] text-gray-400 mt-1">Información muy pronto</p>
                        <a href="" class="text-[11px] text-brandgreen font-semibold hover:underline">Ver detalle
                            →</a>
                    </div>
                </div>
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
                        <div
                            class="relative h-48 bg-gray-50 flex items-center justify-center p-4 border-b border-gray-100">
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
