@extends('layouts.app')

@section('title', 'sUAM — Recursos')

@section('content')
    <div class=" bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-10">

            {{-- Encabezado Principal Hero --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        Recursos y Materiales
                    </h1>
                    <p class="text-gray-600 text-base sm:text-lg mt-3">
                        Explora los materiales didácticos organizados por curso.
                    </p>
                </div>
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>

            {{-- CURSOS OFERTADOS --}}
            <div class="space-y-6">

                <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-8 bg-brandgreen rounded-full"></div>
                        <h2 class="text-2xl font-black text-navy tracking-tight">
                            Cursos Ofertados
                        </h2>
                    </div>
                    <span class="text-center font-extrabold text-navy/60 bg-gray-100 px-3 py-1 rounded-full border border-gray-200">
                        {{ $cursosOfertados->total() }} {{ $cursosOfertados->total() === 1 ? 'curso' : 'cursos' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($cursosOfertados as $curso)
                        @include('recursos._curso_card', ['curso' => $curso])
                    @empty
                        <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-gray-200 shadow-sm">
                            <p class="text-gray-500 font-medium">No hay cursos ofertados con materiales asignados.</p>
                        </div>
                    @endforelse
                </div>

                @if($cursosOfertados->hasPages())
                    <div class="pt-4">
                        {{ $cursosOfertados->links() }}
                    </div>
                @endif

            </div>

            {{-- CURSOS NO OFERTADOS --}}
            <div class="space-y-6">

                <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-8 bg-gray-300 rounded-full"></div>
                        <h2 class="text-2xl font-black text-navy/70 tracking-tight">
                            Cursos No Vigentes
                        </h2>
                    </div>
                    <span class="text-center font-extrabold text-navy/60 bg-gray-100 px-3 py-1 rounded-full border border-gray-200">
                        {{ $cursosNoOfertados->total() }} {{ $cursosNoOfertados->total() === 1 ? 'curso' : 'cursos' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($cursosNoOfertados as $curso)
                        @include('recursos._curso_card', ['curso' => $curso])
                    @empty
                        <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-gray-200 shadow-sm">
                            <p class="text-gray-500 font-medium">No hay cursos no vigentes con materiales asignados.</p>
                        </div>
                    @endforelse
                </div>

                @if($cursosNoOfertados->hasPages())
                    <div class="pt-4">
                        {{ $cursosNoOfertados->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection