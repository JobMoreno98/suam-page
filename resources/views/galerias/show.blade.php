@extends('layouts.app')

@section('title', $galeria->titulo . ' — sUAM Galerías')

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

            {{-- Imagen Destacada (primera imagen de la galería) --}}
            @if($galeria->imagenes->isNotEmpty())
                <div class="w-full h-64 sm:h-96 relative rounded-3xl overflow-hidden shadow-sm bg-gray-900">
                    <img src="{{ $galeria->imagenes->first()->url }}" alt="{{ $galeria->titulo }}"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/40 to-transparent"></div>
                </div>
            @endif

            {{-- Encabezado --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-10 space-y-4">
                <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                    {{ $galeria->titulo }}
                </h1>

                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-gray-500 font-medium">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-brandorange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $galeria->imagenes->count() }} {{ Str::plural('foto', $galeria->imagenes->count()) }}
                    </div>
                </div>

                @if($galeria->descripcion)
                    <p class="text-gray-600 leading-relaxed">
                        {{ $galeria->descripcion }}
                    </p>
                @endif
            </div>

            {{-- Grid de imágenes con lightbox (Alpine puro) --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-10"
                x-data="{ activa: null, imagenes: {{ $galeria->imagenes->pluck('url', 'id')->values()->toJson() ?? '[]' }} }">

                @if($galeria->imagenes->isEmpty())
                    <p class="text-center text-gray-400 py-10">
                        Esta galería aún no tiene imágenes.
                    </p>
                @else
                    <div class="columns-2 md:columns-3 gap-4 space-y-4">
                        @foreach($galeria->imagenes as $index => $imagen)
                            <button
                                type="button"
                                @click="activa = {{ $index }}"
                                class="block w-full break-inside-avoid rounded-2xl overflow-hidden group relative focus:outline-none"
                            >
                                <img
                                    src="{{ $imagen->url }}"
                                    alt="{{ $imagen->alt_text ?? $imagen->titulo ?? $galeria->titulo }}"
                                    loading="lazy"
                                    class="w-full h-auto object-cover transition duration-300 group-hover:scale-105"
                                >
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition duration-300 flex items-end">
                                    @if($imagen->titulo)
                                        <span class="text-white text-sm p-3 opacity-0 group-hover:opacity-100 transition">
                                            {{ $imagen->titulo }}
                                        </span>
                                    @endif
                                </div>
                            </button>
                        @endforeach
                    </div>

                    {{-- Lightbox --}}
                    <div
                        x-show="activa !== null"
                        x-cloak
                        @keydown.escape.window="activa = null"
                        @keydown.arrow-right.window="activa = (activa + 1) % {{ $galeria->imagenes->count() }}"
                        @keydown.arrow-left.window="activa = (activa - 1 + {{ $galeria->imagenes->count() }}) % {{ $galeria->imagenes->count() }}"
                        class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center px-4"
                    >
                        <button @click="activa = null" class="absolute top-5 right-5 text-white/80 hover:text-white text-3xl leading-none" aria-label="Cerrar">
                            &times;
                        </button>

                        <button @click="activa = (activa - 1 + {{ $galeria->imagenes->count() }}) % {{ $galeria->imagenes->count() }}"
                            class="absolute left-3 md:left-8 text-white/70 hover:text-white text-4xl p-2" aria-label="Anterior">
                            &#8249;
                        </button>

                        <div class="max-w-4xl w-full" @click.outside="activa = null">
                            <template x-for="(url, i) in imagenes" :key="i">
                                <img x-show="activa === i" :src="url" class="w-full max-h-[80vh] object-contain rounded-2xl mx-auto">
                            </template>
                            <p class="text-white/40 text-center mt-2 text-xs" x-text="(activa + 1) + ' / {{ $galeria->imagenes->count() }}'"></p>
                        </div>

                        <button @click="activa = (activa + 1) % {{ $galeria->imagenes->count() }}"
                            class="absolute right-3 md:right-8 text-white/70 hover:text-white text-4xl p-2" aria-label="Siguiente">
                            &#8250;
                        </button>
                    </div>
                @endif
            </div>

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
                                    @if($relacionada->imagenes->isNotEmpty())
                                        <img src="{{ $relacionada->imagenes->first()->url }}" alt="{{ $relacionada->titulo }}"
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