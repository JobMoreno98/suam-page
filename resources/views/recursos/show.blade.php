@extends('layouts.app')

@section('content')
    <div x-data="{
        openConvocatoria: null,
        lightboxOpen: false,
        currentImage: '',
        
        // Paleta de colores intercalados para los acordeones de convocatoria
        bgColors: [
            { header: 'bg-emerald-100/70 hover:bg-emerald-100', iconBg: 'bg-emerald-500', border: 'border-emerald-200' },
            { header: 'bg-sky-100/70 hover:bg-sky-100', iconBg: 'bg-sky-500', border: 'border-sky-200' },
            { header: 'bg-amber-100/70 hover:bg-amber-100', iconBg: 'bg-amber-500', border: 'border-amber-200' }
        ]
    }" 
    @keydown.escape.window="lightboxOpen = false"
    class="bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Botón Volver y Badge del Área --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('recursos.index') }}"
                    class="inline-flex items-center gap-2  font-bold text-navy hover:text-brandgreen transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver a Cursos</span>
                </a>

                @if($curso->areaFormacion)
                    <span class="inline-block  font-bold border rounded-full px-3.5 py-1 bg-white text-brandgreen border-brandgreen/30 shadow-sm">
                        {{ $curso->areaFormacion->nombre }}
                    </span>
                @endif
            </div>

            {{-- Encabezado del Curso --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-3xl">
                    <span class=" font-extrabold text-brandgreen uppercase tracking-wider block mb-1">Recursos del Curso</span>
                    <h1 class="text-2xl sm:text-4xl font-black text-navy leading-tight">
                        {{ $curso->nombre }}
                    </h1>
                    @if($curso->subtitulo)
                        <p class="text-gray-500  sm:text-base mt-2 font-medium">
                            {{ $curso->subtitulo }}
                        </p>
                    @endif
                </div>
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>

            {{-- ACORDEÓN PRINCIPAL: AGRUPADO POR CONVOCATORIA --}}
            <div class="space-y-4">
                @forelse($gruposPorConvocatoria as $convocatoriaId => $grupos)
                    @php
                        $convocatoria = $grupos->first()->convocatoria;
                        $colorIndex = $loop->index % 3;
                    @endphp

                    <div class="rounded-2xl border border-gray-200/80 overflow-hidden transition-all duration-300 shadow-sm bg-white"
                        :class="openConvocatoria === {{ $convocatoriaId ?? 0 }} ? 'ring-2 ring-navy/10 shadow-md' : ''">

                        {{-- CABECERA DEL ACORDEÓN (CONVOCATORIA) --}}
                        <button type="button"
                            @click="openConvocatoria = (openConvocatoria === {{ $convocatoriaId ?? 0 }} ? null : {{ $convocatoriaId ?? 0 }})"
                            :class="bgColors[{{ $colorIndex }}].header"
                            class="w-full p-5 sm:p-6 flex items-center justify-between transition-colors text-left focus:outline-none">

                            <div class="flex items-center gap-4 sm:gap-5 min-w-0">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center text-white shrink-0 shadow-sm"
                                    :class="bgColors[{{ $colorIndex }}].iconBg">
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="text-lg sm:text-xl font-extrabold text-navy truncate">
                                        {{ $convocatoria->nombre ?? ($convocatoria ? 'Convocatoria ' . $convocatoria->periodo : 'General / Sin Convocatoria') }}
                                    </h2>
                                    <p class=" text-gray-500 font-medium">
                                        {{ $grupos->count() }} {{ $grupos->count() === 1 ? 'módulo de recursos' : 'módulos de recursos' }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-navy p-1">
                                <svg class="w-6 h-6 transform transition-transform duration-300"
                                    :class="openConvocatoria === {{ $convocatoriaId ?? 0 }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>

                        {{-- CONTENIDO DESPLEGABLE DE LA CONVOCATORIA --}}
                        <div x-show="openConvocatoria === {{ $convocatoriaId ?? 0 }}" x-cloak x-collapse class="bg-white border-t border-gray-100">
                            
                            <div class="p-6 space-y-8">
                                @foreach($grupos as $grupo)
                                    <div class="border border-gray-100 rounded-2xl p-5 bg-gray-50/50 space-y-4">
                                        
                                        {{-- Título del Módulo/Grupo --}}
                                        <div class="flex items-center gap-2 border-b border-gray-200/60 pb-3">
                                            <div class="w-2 h-2 rounded-full bg-brandgreen"></div>
                                            <h3 class="text-base sm:text-lg font-extrabold text-navy">
                                                {{ $grupo->titulo_grupo ?? 'Módulo de Recursos' }}
                                            </h3>
                                        </div>

                                        {{-- Materiales del Módulo --}}
                                        <div class="divide-y divide-gray-100">
                                            @forelse($grupo->items as $item)
                                                <div class="py-4 first:pt-0 last:pb-0">
                                                    
                                                    <h4 class=" sm:text-base font-bold text-navy mb-1">{{ $item->titulo }}</h4>
                                                    
                                                    @if($item->descripcion)
                                                        <p class=" text-gray-500 mb-3">{{ $item->descripcion }}</p>
                                                    @endif

                                                    {{-- RENDERIZADO POR TIPO DE ELEMENTO --}}
                                                    <div class="mt-2">
                                                        
                                                        {{-- 1. ARCHIVOS --}}
                                                        @if($item->tipo === 'archivo')
                                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                                                @foreach((array) $item->valor as $ruta)
                                                                    <a href="{{ Storage::url($ruta) }}" target="_blank" 
                                                                       class="flex items-center p-3 bg-white hover:bg-sky-50/50 border border-gray-200 hover:border-sky-200 text-navy rounded-xl transition-colors group shadow-xs">
                                                                        <div class="p-2 bg-gray-50 text-brandgreen rounded-lg shadow-xs border border-gray-100 mr-3 group-hover:bg-brandgreen group-hover:text-white transition-colors">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                            </svg>
                                                                        </div>
                                                                        <span class="font-semibold  truncate group-hover:text-brandgreen transition-colors">
                                                                            {{ basename($ruta) }}
                                                                        </span>
                                                                    </a>
                                                                @endforeach
                                                            </div>

                                                        {{-- 2. IMÁGENES (LIGHTBOX) --}}
                                                        @elseif($item->tipo === 'imagen')
                                                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                                                                @foreach((array) $item->valor as $ruta)
                                                                    <div @click="currentImage = '{{ Storage::url($ruta) }}'; lightboxOpen = true"
                                                                         class="rounded-xl overflow-hidden bg-gray-100 border border-gray-200 relative group cursor-pointer aspect-video shadow-xs">
                                                                        <img src="{{ Storage::url($ruta) }}" alt="Imagen del recurso"
                                                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                                                        <div class="absolute inset-0 bg-navy/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white backdrop-blur-xs">
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        {{-- 3. YOUTUBE --}}
                                                        @elseif($item->tipo === 'youtube')
                                                            @php $urlYoutube = is_array($item->valor) ? ($item->valor[0] ?? '') : $item->valor; @endphp
                                                            <a href="{{ $urlYoutube }}" target="_blank" 
                                                               class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white rounded-xl font-bold  transition-colors border border-red-100 shadow-xs">
                                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
                                                                </svg>
                                                                Ver Video en YouTube
                                                            </a>

                                                        {{-- 4. ENLACES WEB --}}
                                                        @elseif($item->tipo === 'enlace')
                                                            @php $urlEnlace = is_array($item->valor) ? ($item->valor[0] ?? '') : $item->valor; @endphp
                                                            <a href="{{ $urlEnlace }}" target="_blank" 
                                                               class="inline-flex items-center px-4 py-2 bg-white hover:bg-navy text-navy hover:text-white border border-gray-200 rounded-xl font-bold  transition-all shadow-xs">
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                                </svg>
                                                                Abrir Enlace Web
                                                            </a>

                                                        {{-- 5. TEXTO ENRIQUECIDO --}}
                                                        @elseif($item->tipo === 'texto')
                                                            @php $contenido = is_array($item->valor) ? ($item->valor[0] ?? '') : $item->valor; @endphp
                                                            <div class="text-gray-700  leading-relaxed p-4 bg-white rounded-xl border border-gray-200/80 shadow-inner
                                                                [&_strong]:font-bold [&_strong]:text-navy
                                                                [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5">
                                                                {!! $contenido !!}
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-gray-400  text-center py-2">No hay recursos individuales asignados a este módulo.</p>
                                            @endforelse
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-12 text-center border border-gray-200 shadow-sm">
                        <p class="text-gray-500 font-medium">Este curso no cuenta con materiales asignados a ninguna convocatoria actualmente.</p>
                    </div>
                @endforelse
            </div>

        </div>

        {{-- LIGHTBOX / MODAL PARA MOSTRAR IMÁGENES A PANTALLA COMPLETA --}}
        <template x-teleport="body">
            <div x-show="lightboxOpen" 
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-8 bg-black/90 backdrop-blur-md"
                style="display: none;">

                <button type="button" @click="lightboxOpen = false"
                    class="absolute top-5 right-5 z-10 text-white/70 hover:text-white p-3 rounded-full bg-white/10 hover:bg-white/20 transition-all focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="absolute inset-0" @click="lightboxOpen = false"></div>

                <div class="relative z-10 max-w-5xl max-h-[90vh] overflow-hidden rounded-2xl shadow-2xl flex items-center justify-center"
                    x-show="lightboxOpen" 
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                    <img :src="currentImage" alt="Recurso Ampliado" class="max-w-full max-h-[90vh] object-contain rounded-2xl">
                </div>
            </div>
        </template>

    </div>
@endsection