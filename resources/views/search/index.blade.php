@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Encabezado de Resultados --}}

            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-2xl sm:text-3xl font-black text-navy tracking-tight leading-tight">
                        Resultados de búsqueda
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500">
                        @if ($query)
                            Se encontraron <strong class="text-navy">{{ $resultados->count() }}</strong> coincidencias para
                            "<span class="text-brandgreen font-bold">{{ $query }}</span>"
                        @else
                            Ingresa un término para comenzar a buscar.
                        @endif
                    </p>
                </div>
                <div
                    class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>


            <div class="space-y-4">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm divide-y divide-gray-100 overflow-hidden">
                    @forelse($resultados as $item)
                        <div
                            class="p-4 sm:p-5 hover:bg-gray-50/50 transition-colors flex items-center justify-between gap-4">
                            <div class="space-y-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    {{-- Badge para identificar qué tipo de modelo es --}}
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                                        {{ $item->tipo_resultado }}
                                    </span>
                                </div>

                                <h3 class="font-bold text-navy text-sm sm:text-base truncate">
                                    {{ $item->nombre }}
                                </h3>

                                @if ($item->descripcion ?? $item->contenido)
                                    <p class="text-xs text-gray-400 line-clamp-1">
                                        {{ Str::limit(strip_tags($item->descripcion ?? $item->contenido), 140) }}
                                    </p>
                                @endif
                            </div>

                            <a href="{{ $item->url_resultado }}"
                                class="px-4 py-2 bg-navy hover:bg-brandgreen text-white font-bold text-xs rounded-xl transition-colors shrink-0">
                                Ver detalle
                            </a>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400 text-xs">
                            No se encontraron coincidencias.
                        </div>
                    @endforelse
                </div>

                {{-- Render de los botones de Paginación nativos de Laravel --}}
                <div class="pt-4">
                    {{ $resultados->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
