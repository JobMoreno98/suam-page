@extends('layouts.app')

@section('content')
    <div x-data="{
        modalOpen: false,
        activeConvocatoria: null
    }" class=" bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Encabezado --}}

            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        Convocatorias
                    </h1>
                    <p class="text-gray-600 text-base sm:text-lg mt-3">
                        Consulta las bases e infórmate sobre nuestras convocatorias vigentes
                    </p>
                </div>
                <div
                    class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>


            {{-- GRID DE CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($convocatorias ?? [] as $convocatoria)
                    <div
                        class="bg-white rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col justify-between group">

                        <div>
                            {{-- Imagen (Cartel) --}}
                            <div class="h-56 w-full bg-gray-100 relative overflow-hidden">
                                <img src="{{ $convocatoria->url_imagen }}" alt="{{ $convocatoria->nombre }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                                {{-- Badge de Estado sobre la imagen --}}
                                <div class="absolute top-3 right-3">
                                    <span
                                        class="inline-block text-[11px] font-bold border rounded-full px-3 py-0.5 shadow-sm bg-white/95 backdrop-blur-sm {{ $convocatoria->estado_inscripcion['badge'] }}">
                                        {{ $convocatoria->estado_inscripcion['texto'] }}
                                    </span>
                                </div>
                            </div>

                            {{-- Contenido de la Card --}}
                            <div class="p-5 space-y-3">
                                <h3
                                    class="text-lg font-bold text-navy line-clamp-2 leading-snug group-hover:text-brandgreen transition-colors">
                                    {{ $convocatoria->nombre }}
                                </h3>

                                <div class="space-y-1.5  text-gray-500 pt-2 border-t border-gray-100">
                                    {{-- Vigencia --}}
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Incripciones: <strong
                                                class="text-navy">{{ $convocatoria->rango_fechas }}</strong></span>
                                    </div>

                                    {{-- Fecha límite de registro --}}
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Fecha de inicio: <strong
                                                class="text-navy">{{ $convocatoria->fecha_registro_formateada }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botón Modal --}}
                        <div class="p-5 pt-0">
                            <a href="{{ route('convocatorias.show', $convocatoria) }}"
                                class="w-full py-2.5 px-4 bg-gray-50 hover:bg-navy hover:text-white text-navy  font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 border border-gray-100">
                                <span>Ver bases y detalles</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-200">
                        <p class="text-gray-500 font-medium">No hay convocatorias publicadas en este momento.</p>
                    </div>
                @endforelse
            </div>

        </div>

    </div>
@endsection
