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
                        <button type="button"
                            @click="openCategory = (openCategory === {{ $categoria->id }} ? null : {{ $categoria->id }})"
                            :class="bgColors[{{ $colorIndex }}].header"
                            class="w-full p-5 sm:p-6 flex items-center justify-between transition-colors text-left focus:outline-none">

                            <div class="flex items-center gap-4 sm:gap-5 min-w-0">
                                {{-- Icono representativo --}}
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center text-white shrink-0 shadow-sm"
                                    :class="bgColors[{{ $colorIndex }}].iconBg">

                                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center text-white shrink-0 shadow-sm"
                                        :class="bgColors[{{ $colorIndex }}].iconBg">

                                        <x-heroicon :name="$categoria->icono" class="w-6 h-6 sm:w-7 sm:h-7" />

                                    </div>
                                </div>

                                {{-- Nombre del área --}}
                                <h2 class="text-lg sm:text-xl font-extrabold text-navy truncate">
                                    {{ $categoria->nombre }}
                                </h2>
                            </div>

                            {{-- Indicador de expansión (+ / - o Flecha) --}}
                            <div class="text-navy p-1">
                                <svg class="w-6 h-6 transform transition-transform duration-300"
                                    :class="openCategory === {{ $categoria->id }} ? 'rotate-180' : ''" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
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
                                        <button type="button"
                                            data-curso="{{ json_encode([
                                                'nombre' => $curso->nombre,
                                                'descripcion' => $curso->descripcion,
                                                'url_imagen' => $curso->url_imagen ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80',
                                                'sede' => $curso->sede->nombre ?? 'Sede Principal',
                                                'horario' => $curso->horario ?? 'Por definir',
                                                'requisitos' => $curso->requisitos ?? null,
                                            ]) }}"
                                            @click="activeCurso = JSON.parse($el.dataset.curso); modalOpen = true"
                                            class="shrink-0 text-xs font-bold text-navy hover:text-brandgreen hover:underline flex items-center gap-1 transition-colors">
                                            <span>Ver detalle</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
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

        {{-- MODAL DE DETALLE DEL CURSO --}}
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">

            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen = false"
                class="fixed inset-0 bg-navy/60 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-100">

                    <button @click="modalOpen = false"
                        class="absolute right-4 top-4 z-10 rounded-full bg-white/80 p-2 text-gray-500 hover:text-navy hover:bg-white transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <template x-if="activeCurso">
                        <div>
                            <div class="h-48 bg-gray-100 relative">
                                <img :src="activeCurso.url_imagen" :alt="activeCurso.nombre"
                                    class="w-full h-full object-cover">
                            </div>

                            <div class="p-6 sm:p-8 space-y-4">
                                <h2 class="text-2xl font-black text-navy" x-text="activeCurso.nombre"></h2>

                                <div
                                    class="flex flex-wrap gap-4 text-xs font-semibold text-gray-500 border-y border-gray-100 py-3">
                                    <div><span class="text-navy font-bold">Sede:</span> <span
                                            x-text="activeCurso.sede"></span></div>
                                    <div><span class="text-navy font-bold">Horario:</span> <span
                                            x-text="activeCurso.horario"></span></div>
                                </div>

                                @php
                                    $modalidad = strtolower($curso->modalidad ?? 'presencial');
                                @endphp

                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium 
    {{ $modalidad === 'presencial' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
    {{ $modalidad === 'virtual' ? 'bg-sky-50 text-sky-700 border border-sky-200' : '' }}
    {{ in_array($modalidad, ['ambas', 'hibrida', 'híbrida']) ? 'bg-purple-50 text-purple-700 border border-purple-200' : '' }}">

                                    <x-heroicon :name="$modalidad" class="w-3.5 h-3.5" />

                                    <span class="capitalize">{{ $modalidad }}</span>
                                </span>

                                <div class="text-gray-600 text-sm space-y-3
                                        [&_a]:inline-flex [&_a]:items-center [&_a]:justify-center [&_a]:gap-2
                                        [&_a]:bg-brandgreen [&_a]:text-white [&_a]:font-bold [&_a]:text-xs [&_a]:uppercase [&_a]:tracking-wider
                                        [&_a]:px-5 [&_a]:py-2.5 [&_a]:rounded-xl [&_a]:shadow-md [&_a]:shadow-brandgreen/20
                                        hover:[&_a]:bg-navy hover:[&_a]:shadow-navy/20 hover:[&_a]:-translate-y-0.5
                                        [&_a]:transition-all [&_a]:duration-200 [&_a]:no-underline
                                        [&_strong]:font-bold [&_strong]:text-navy
                                        [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5"
                                    x-html="activeCurso.descripcion"></div>

                                <template x-if="activeCurso.requisitos">
                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                        <h4 class="text-xs font-bold text-navy uppercase tracking-wider mb-1">Requisitos:
                                        </h4>
                                        <div class="text-xs text-gray-600 [&_ul]:list-disc [&_ul]:pl-4"
                                            x-html="activeCurso.requisitos"></div>
                                    </div>
                                </template>
                            </div>

                            <div class="bg-gray-50 px-6 py-4 flex justify-end border-t border-gray-100">
                                <button type="button" @click="modalOpen = false"
                                    class="px-5 py-2.5 bg-gray-200 text-gray-700 font-bold text-xs rounded-xl hover:bg-gray-300 transition-colors">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>

    </div>
@endsection
