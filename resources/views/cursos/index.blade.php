@extends('layouts.app')

@section('content')
    <div x-data="{
        modalOpen: false,
        activeCurso: null,
        selectedCategoria: '',
        selectedModalidad: '',
        searchQuery: '',
        listaCursos: @js($cursos->items()) {{-- Extrae solo el array de ítems si usas paginación --}}
    }" class="min-h-screen bg-gray-50/50 py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-8">

            {{-- 1. ENCABEZADO DE LA SECCIÓN --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-sm relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-brandgreen/10 text-brandgreen mb-3">
                        <span class="w-2 h-2 rounded-full bg-brandgreen"></span>
                        Oferta Académica
                    </span>
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        Cursos y Talleres
                    </h1>
                    <p class="text-gray-600 text-base sm:text-lg mt-3">
                        Explora nuestra amplia oferta formativa diseñada especialmente para potenciar tu aprendizaje, salud
                        y desarrollo personal.
                    </p>
                </div>
                <div
                    class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>

            {{-- 2. BARRA DE BÚSQUEDA Y FILTROS EN TIEMPO REAL (Alpine.js) --}}
            <div class="bg-white p-4 sm:p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Búsqueda por texto --}}
                    <div class="relative md:col-span-1">
                        <input type="text" x-model="searchQuery" placeholder="Buscar por nombre..."
                            class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:bg-white focus:border-navy focus:ring-4 focus:ring-navy/5 transition-all">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    {{-- Filtro por Modalidad --}}
                    <div>
                        <select x-model="selectedModalidad"
                            class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:bg-white focus:border-navy focus:ring-4 focus:ring-navy/5 transition-all text-gray-700">
                            <option value="">Todas las Modalidades</option>
                            <option value="presencial">Presencial</option>
                            <option value="virtual">Virtual / En línea</option>
                        </select>
                    </div>

                </div>
            </div>

            {{-- 3. GRID DE TARJETAS DE CURSOS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($cursos ?? [] as $curso)
                    {{-- EVALUACIÓN DE FILTROS AL INSTANTE --}}
                    <div x-show="(searchQuery === '' || '{{ strtolower(addslashes($curso->nombre)) }}'.includes(searchQuery.toLowerCase())) &&
                             (selectedModalidad === '' || selectedModalidad === '{{ strtolower($curso->modalidad ?? 'presencial') }}')"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden flex flex-col justify-between group">

                        <div>
                            {{-- Imagen del Curso --}}
                            <div class="h-48 bg-gray-100 relative overflow-hidden">
                                <img src="{{ $curso->url_imagen ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80' }}"
                                    alt="{{ $curso->nombre }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                                {{-- Badge de Modalidad --}}
                                <span
                                    class="absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur-md rounded-full text-xs font-bold text-navy shadow-sm">
                                    {{ strtoupper($curso->modalidad) ?? 'Presencial' }}
                                </span>
                            </div>

                            {{-- Contenido de la Tarjeta --}}
                            <div class="p-6 space-y-3">
                                {{-- Sede
                                <div class="flex items-center gap-2 text-xs font-semibold text-brandgreen">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    <span>{{ $curso->sede->nombre ?? 'Sede Principal' }}</span>
                                </div>
 --}}
                                <h3
                                    class="text-xl font-bold text-navy line-clamp-2 hover:text-brandgreen transition-colors">
                                    {{ $curso->nombre }}
                                </h3>

                                <p class="text-gray-600 text-sm line-clamp-3">
                                    {{ Str::limit(strip_tags($curso->descripcion), 120) }}
                                </p>
                            </div>
                        </div>

                        {{-- Footer de la Tarjeta --}}
                        <div class="p-6 pt-0 border-t border-gray-50 mt-4 flex items-center justify-between gap-2">

                            {{-- Asignación segura del curso a activeCurso --}}
                            <button type="button"
                                @click="activeCurso = listaCursos[{{ $loop->index }}]; modalOpen = true"
                                class="inline-flex items-center justify-center px-4 py-2 bg-navy hover:bg-brandgreen text-white text-xs font-bold rounded-xl transition-colors duration-200 shadow-sm">
                                Ver detalles
                            </button>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-100">
                        <h3 class="text-lg font-bold text-navy">No hay cursos registrados</h3>
                        <p class="text-gray-500 text-sm mt-1">Vuelve más tarde para conocer la nueva oferta académica.</p>
                    </div>
                @endforelse
            </div>

        </div>

        {{-- 4. MODAL DETALLE DEL CURSO (Alpine.js) --}}
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">

            {{-- Fondo Oscuro --}}
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
                            <div class="h-56 bg-gray-100 relative">
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

                                {{-- Renderizado TinyMCE con botones estilizados --}}
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

                            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-100">
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
