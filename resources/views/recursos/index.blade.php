@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-10">

            {{-- Encabezado Principal Hero --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        Recursos y Materiales
                    </h1>
                    <p class="text-gray-600 text-base sm:text-lg mt-3">
                        Explora los materiales didácticos organizados por área de formación y curso.
                    </p>
                </div>
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>

            {{-- BLOQUES POR ÁREA DE FORMACIÓN --}}
            <div class="space-y-12">
                @forelse($cursosPorArea as $nombreArea => $cursos)
                    <div class="space-y-6">
                        
                        {{-- Encabezado del Área de Formación --}}
                        <div class="flex items-center gap-3 pb-3 border-b border-gray-200">
                            <div class="w-3 h-8 bg-brandgreen rounded-full"></div>
                            <h2 class="text-2xl font-black text-navy tracking-tight">
                                {{ $nombreArea }}
                            </h2>
                            <span class="text-xs font-extrabold text-navy/60 bg-gray-100 px-3 py-1 rounded-full border border-gray-200">
                                {{ $cursos->count() }} {{ $cursos->count() === 1 ? 'curso' : 'cursos' }}
                            </span>
                        </div>

                        {{-- REJILLA DE CURSOS PERTENECIENTES A ESTA ÁREA --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($cursos as $curso)
                                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                                    
                                    <div class="space-y-3">
                                        {{-- Nombre del Curso --}}
                                        <h3 class="text-xl font-extrabold text-navy group-hover:text-brandgreen transition-colors leading-snug">
                                            {{ $curso->nombre }}
                                        </h3>

                                        @if($curso->subtitulo)
                                            <p class="text-xs text-gray-400 line-clamp-2 font-medium">
                                                {{ $curso->subtitulo }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Pie de la Card --}}
                                    <div class="pt-6 mt-6 border-t border-gray-100 flex items-center justify-between">
                                        <span class="text-xs text-gray-500 font-bold flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-brandgreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            {{ $curso->grupos_materiales_count }} {{ $curso->grupos_materiales_count === 1 ? 'Módulo' : 'Módulos' }}
                                        </span>

                                        <a href="{{ route('recursos.show', $curso->slug ?? $curso->id) }}" 
                                           class="px-4 py-2 bg-navy hover:bg-brandgreen text-white font-bold text-xs rounded-xl transition-all duration-200 flex items-center gap-1 shadow-md shadow-navy/10 group-hover:shadow-brandgreen/20">
                                            <span>Ver recursos</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-12 text-center border border-gray-200 shadow-sm">
                        <p class="text-gray-500 font-medium">No se encontraron cursos con materiales de estudio asignados.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection