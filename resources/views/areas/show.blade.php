@extends('layouts.app')

@section('content')
    <div class="bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-10">

            {{-- Migas de pan (Breadcrumbs) --}}
            <div>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2  font-bold text-navy hover:text-brandgreen transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver al inicio</span>
                </a>
            </div>

            {{-- Hero Header del Área --}}
            <div
                class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-sm flex flex-col sm:flex-row items-center gap-6 text-center sm:text-left">

                {{-- Icono / Ilustración del Área --}}
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full flex items-center justify-center shrink-0 shadow-sm"
                    style="background-color: {{ $area_formacion->color ?? '#0284c7' }};">

                    <x-heroicon :name="$area_formacion->icono" class="w-12 h-12 sm:w-7 sm:h-7 text-white" />

                </div> {{-- Información del Área --}}
                <div class="space-y-2">
                    <span class=" font-bold text-brandgreen uppercase tracking-wider block">Área de Formación</span>
                    <h1 class="text-2xl sm:text-4xl font-black text-navy leading-tight">
                        {{ $area_formacion->nombre }}
                    </h1>
                    @if ($area_formacion->descripcion)
                        <p class="text-gray-500  max-w-2xl">
                            {!! $area_formacion->descripcion !!}
                        </p>
                    @endif
                </div>

            </div>

            {{-- Listado de Cursos del Área --}}
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-extrabold text-navy">
                        Cursos disponibles <span class="text-gray-400 font-normal">({{ $cursos->total() }})</span>
                    </h2>
                </div>

                @if ($cursos->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($cursos as $curso)
                            <div
                                class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow flex flex-col justify-between">

                                {{-- Contenido de la Card del Curso --}}
                                <div class="p-6 space-y-4">
                                    <h3 class="font-bold text-navy text-lg line-clamp-2">
                                        {{ $curso->nombre }}
                                    </h3>
                                    <p class="text-gray-500  line-clamp-3">
                                        {{ Str::limit(strip_tags(html_entity_decode($curso->descripcion ?? '')), 150, '...') ?: 'Sin descripción disponible.' }}
                                    </p>
                                </div>

                                {{-- Footer / Botón Acción --}}
                                <div class="p-6 pt-0 border-t border-gray-50 mt-auto flex items-center justify-between">
                                    <span>

                                    </span>

                                    <a href="{{ route('cursos.show', $curso->slug) }}"
                                        class="px-4 py-2 bg-navy hover:bg-brandgreen text-white font-bold  rounded-xl transition-colors">
                                        Ver curso
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{-- Paginación --}}
                    <div class="pt-6">
                        {{ $cursos->links() }}
                    </div>
                @else
                    {{-- Estado Vacío --}}
                    <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 space-y-3">
                        <p class="text-navy font-bold text-lg">Próximamente habrá cursos disponibles</p>
                        <p class="text-gray-400 ">Estamos preparando nuevos programas para esta área de formación.
                        </p>
                    </div>
                @endif
            </div>

        </div>

    </div>
@endsection
