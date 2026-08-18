@extends('layouts.app')

@section('content')
    <div x-data="{
        openCategory: null,
        {{-- Guarda el ID de la categoría desplegada --}}
        modalOpen: false,
        activeCurso: null,
    }" class="bg-gray-50/50 py-8 sm:py-10 px-4 sm:px-6 lg:px-8">

        <div class="w-full mx-auto space-y-6 sm:space-y-8">

            {{-- Encabezado --}}
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

                    {{-- Contenedor de la tarjeta: header + panel juntos --}}
                    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">

                        {{-- HEADER DEL ACORDEÓN --}}
                        <div @click="openCategory = (openCategory === {{ $categoria->id }} ? null : {{ $categoria->id }})"
                            style="background-color: color-mix(in srgb, {{ $categoria->color }} 15%, white);"
                            class="w-full p-4 sm:p-6 flex items-center justify-between gap-2 transition-colors cursor-pointer select-none">

                            <div class="flex items-center gap-3 sm:gap-5 min-w-0 flex-1">
                                {{-- Icono representativo --}}
                                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full flex items-center justify-center text-white shrink-0 shadow-sm"
                                    style="background-color: {{ $categoria->color }};">
                                    <x-heroicon :name="$categoria->icono" class="w-5 h-5 sm:w-7 sm:h-7" />
                                </div>

                                {{-- Nombre del área: Se eliminó 'truncate' para que baje de línea si es largo --}}
                                <h2 class="text-base sm:text-xl font-extrabold text-navy leading-tight">
                                    {{ $categoria->nombre }}
                                </h2>
                            </div>

                            {{-- LADO DERECHO: Botón para ir a la vista del área + Flecha del Acordeón --}}
                            <div class="flex items-center gap-2 sm:gap-3 shrink-0">

                                {{-- NUEVO BOTÓN: Ir a la página del Área responsivo --}}
                                <a href="{{ route('areas.show', $categoria) }}" @click.stop
                                    class="px-2.5 py-1.5 sm:px-3.5 sm:py-1.5 bg-white hover:bg-navy hover:text-white text-navy font-bold text-[12px] sm: rounded-lg sm:rounded-xl shadow-xs border border-gray-200 transition-all duration-200 flex items-center gap-1">
                                    {{-- Texto corto en móviles, texto completo en pantallas medianas o más grandes --}}
                                    <span class="hidden sm:inline">Ver información</span>
                                    <span class="sm:hidden">Ver área</span>
                                </a>

                                {{-- Indicador de expansión (+ / - o Flecha) --}}
                                <div class="text-navy p-1">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 transform transition-transform duration-300"
                                        :class="openCategory === {{ $categoria->id }} ? 'rotate-180' : ''" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                            </div>
                        </div>

                        {{-- PANEL DESPLEGABLE --}}
                        <div x-show="openCategory === {{ $categoria->id }}"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            class="px-4 sm:px-6 pb-5 sm:pb-6 pt-1">

                            {{-- TODO: reemplaza esto por el listado real de cursos de la categoría --}}
                                @forelse($categoria->cursos as $curso)
                                    <div
                                        class="p-3.5 sm:p-4 rounded-xl hover:bg-sky-50/50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 group">
                                        <div class="min-w-0 w-full">
                                            {{-- Se eliminó 'truncate' de los cursos para permitir el salto de línea --}}
                                            <h3
                                                class=" sm:text-base font-semibold text-navy group-hover:text-brandgreen transition-colors leading-tight">
                                                {{ $curso->nombre }}
                                            </h3>
                                            @if ($curso->sede)
                                                <span class=" text-gray-400 font-medium block mt-1">
                                                    {{ $curso->sede->nombre }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- El botón abarca el 100% en móviles (w-full) y su ancho natural en PC (sm:w-auto) --}}
                                        <a href="{{ route('cursos.show', $curso->slug) }}"
                                            class="w-full sm:w-auto text-center px-4 py-2 bg-navy hover:bg-brandgreen text-white font-bold  rounded-xl transition-colors shrink-0">
                                            Ver curso
                                        </a>
                                    </div>
                                @empty
                                    <div class="p-4 text-center  text-gray-400">
                                        No hay cursos disponibles en esta área por el momento.
                                    </div>
                                @endforelse
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