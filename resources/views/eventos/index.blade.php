@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Encabezado Principal Hero --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <span class="text-xs font-extrabold text-brandgreen uppercase tracking-wider block mb-1">
                        Mantente informado
                    </span>
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        Eventos y Actividades
                    </h1>
                    <p class="text-gray-600 text-base sm:text-lg mt-3">
                        Descubre nuestros próximos eventos, talleres y actividades destacadas organizadas especialmente para ti.
                    </p>
                </div>
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>

            {{-- Grid de Tarjetas de Eventos --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($eventos as $evento)
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden flex flex-col group">
                        
                        {{-- Imagen Principal --}}
                        <div class="h-52 w-full bg-gray-100 relative overflow-hidden">
                            @if($evento->imagen)
                                <img src="{{ Storage::url($evento->imagen) }}" alt="{{ $evento->nombre }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Información del Evento --}}
                        <div class="p-6 flex flex-col flex-grow space-y-4">
                            <h3 class="font-black text-navy text-lg leading-tight line-clamp-2">
                                {{ $evento->nombre }}
                            </h3>
                            
                            {{-- Contenido truncado sin etiquetas HTML --}}
                            <p class="text-sm text-gray-500 line-clamp-3 flex-grow">
                                {{ Str::limit(strip_tags($evento->contenido), 120) }}
                            </p>

                            <a href="{{ route('eventos.show', $evento) }}" 
                               class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-gray-50 hover:bg-navy text-navy hover:text-white font-bold text-xs rounded-xl transition-colors border border-gray-100 group-hover:border-navy">
                                Ver detalles del evento
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-3xl p-10 text-center border border-gray-100 shadow-sm flex flex-col items-center justify-center space-y-3">
                        <div class="p-4 bg-gray-50 rounded-full text-gray-400 mb-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-navy font-bold text-lg">No hay eventos o actividades disponibles</p>
                        <p class="text-gray-400 text-sm">Aún no se han registrado en la plataforma.</p>
                    </div>
                @endforelse
            </div>

            {{-- Paginación (Se muestra solo si hay más de 1 página) --}}
            @if($eventos->hasPages())
                <div class="pt-4">
                    {{ $eventos->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection