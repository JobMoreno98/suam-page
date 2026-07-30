@extends('layouts.app')

@section('content')
    <div x-data="{
        openCategory: null,
        {{-- Guarda el ID de la categoría desplegada --}}
        modalOpen: false,
        activeCurso: null,
    
        // Define la paleta de colores intercalados como en la imagen
        bgColors: [
            { header: 'bg-sky-100/70 hover:bg-sky-100', iconBg: 'bg-sky-500', border: 'border-sky-200' },
            { header: 'bg-amber-100/70 hover:bg-amber-100', iconBg: 'bg-amber-500', border: 'border-amber-200' },
            { header: 'bg-emerald-100/70 hover:bg-emerald-100', iconBg: 'bg-emerald-500', border: 'border-emerald-200' }
        ]
    }" class="min-h-screen bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">

        <div class="w-full mx-auto space-y-8">

            {{-- Encabezado idéntico a la imagen --}}

            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        Cursos y talleres
                    </h1>
                    <p class="text-gray-600 text-base sm:text-lg mt-3">
                        Explora nuestras áreas de formación
                    </p>
                </div>
                <div
                    class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>

            {{-- ACORDEÓN DE ÁREAS / CATEGORÍAS --}}
            <div class="space-y-4">
                @forelse($categorias ?? [] as $index => $categoria)
                    @php
                        // Mapeo de estilos/colores dinámicos
                        $colorIndex = $index % 3;
                    @endphp

                    <div class="rounded-2xl border border-gray-200/80 overflow-hidden transition-all duration-300 shadow-sm bg-white"
                        :class="openCategory === {{ $categoria->id }} ? 'ring-2 ring-navy/10 shadow-md' : ''">

                        {{-- CABECERA DEL ÁREA DE FORMACIÓN --}}
                        {{-- CABECERA DEL ÁREA DE FORMACIÓN --}}
                        <button type="button"
                            @click="openCategory = (openCategory === {{ $categoria->id }} ? null : {{ $categoria->id }})"
                            :class="bgColors[{{ $colorIndex }}].header"
                            class="w-full p-5 sm:p-6 flex items-center justify-between transition-colors text-left focus:outline-none">

                            <div class="flex items-center gap-4 sm:gap-5 min-w-0">
                                {{-- Icono representativo --}}
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center text-white shrink-0 shadow-sm"
                                    :class="bgColors[{{ $colorIndex }}].iconBg">
                                    <x-heroicon :name="$categoria->icono" class="w-6 h-6 sm:w-7 sm:h-7" />
                                </div>

                                {{-- Nombre del área --}}
                                <h2 class="text-lg sm:text-xl font-extrabold text-navy truncate">
                                    {{ $categoria->nombre }}
                                </h2>
                            </div>

                            {{-- LADO DERECHO: Botón para ir a la vista del área + Flecha del Acordeón --}}
                            <div class="flex items-center gap-3 shrink-0">

                                {{-- NUEVO BOTÓN: Ir a la página del Área --}}
                                <a href="{{ route('areas.show', $categoria) }}" @click.stop
                                    class="px-3.5 py-1.5 bg-white hover:bg-navy hover:text-white text-navy font-bold text-xs rounded-xl shadow-xs border border-gray-200 transition-all duration-200 flex items-center gap-1">
                                    <span>Ver información</span>

                                </a>

                                {{-- Indicador de expansión (+ / - o Flecha) --}}
                                <div class="text-navy p-1">
                                    <svg class="w-6 h-6 transform transition-transform duration-300"
                                        :class="openCategory === {{ $categoria->id }} ? 'rotate-180' : ''" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                            </div>
                        </button>

                        {{-- LISTA DE CURSOS DESPLEGABLE --}}
                        <div x-show="openCategory === {{ $categoria->id }}" x-cloak x-collapse
                            class="bg-white border-t border-gray-100">

                            <div class="p-3 sm:p-4 divide-y divide-gray-100">
                                @forelse($categoria->cursos as $curso)
                                    <div
                                        class="p-3.5 sm:p-4 rounded-xl hover:bg-sky-50/50 transition-colors flex items-center justify-between gap-4 group">
                                        <div class="min-w-0">
                                            <h3
                                                class="text-sm sm:text-base font-semibold text-navy group-hover:text-brandgreen transition-colors truncate">
                                                {{ $curso->nombre }}
                                            </h3>
                                            @if ($curso->sede)
                                                <span class="text-xs text-gray-400 font-medium">
                                                    {{ $curso->sede->nombre }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- BOTÓN TOTALMENTE SEGURO SIN ERROR DE SINTAXIS EN BLADE --}}
                                        <a href="{{ route('cursos.show', $curso->slug) }}"
                                            class="px-4 py-2 bg-navy hover:bg-brandgreen text-white font-bold text-xs rounded-xl transition-colors">
                                            Ver curso
                                        </a>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-xs text-gray-400">
                                        No hay cursos disponibles en esta área por el momento.
                                    </div>
                                @endforelse
                            </div>

                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-10 text-center border border-gray-200">
                        <p class="text-gray-500 font-medium">No se encontraron áreas de formación creadas.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection
