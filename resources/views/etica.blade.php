@extends('layouts.app')

@section('content')
    <div class="bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Encabezado Principal Hero --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        Nuestro Código de Ética
                    </h1>
                </div>
                <div
                    class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>

            {{-- GRID PRINCIPAL --}}
            <div class="grid grid-cols-1  gap-8 items-start">

                {{-- Tarjeta con Misión, Visión y Valores (Ocupa 2 columnas en desktop) --}}
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-6 h-full">
                    <p class=" text-gray-600 leading-relaxed">
                        {!! $configuracion['descripcion'] !!}
                    </p>
                    @if (isset($configuracion['archivo']))
                        <div class="text-end">
                            <a target="_blank" href="{{ asset('storage/' . $configuracion['archivo']) }}"
                                class="inline-flex items-center gap-2 bg-navy hover:bg-brandgreen text-white  font-bold rounded-xl px-5 py-3 transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                                </svg>
                                <span>Descargar nuestro código de ética</span>
                            </a>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
@endsection
