{{-- resources/views/recursos/_curso_card.blade.php --}}
<div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">

    <div class="space-y-3">
        @if($curso->area)
            <span class="inline-block text-xs font-extrabold text-brandgreen bg-brandgreen/10 px-2.5 py-1 rounded-full">
                {{ $curso->area->nombre }}
            </span>
        @endif

        {{-- Nombre del Curso --}}
        <h3 class="text-xl font-extrabold text-navy group-hover:text-brandgreen transition-colors leading-snug">
            {{ $curso->nombre }}
        </h3>

        @if($curso->subtitulo)
            <p class=" text-gray-400 line-clamp-2 font-medium">
                {{ $curso->subtitulo }}
            </p>
        @endif
    </div>

    {{-- Pie de la Card --}}
    <div class="pt-6 mt-6 border-t border-gray-100 flex items-center justify-between">
        <span class=" text-gray-500 font-bold flex items-center gap-1.5">
            <svg class="w-4 h-4 text-brandgreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            {{ $curso->grupos_materiales_count }} {{ $curso->grupos_materiales_count === 1 ? 'Módulo' : 'Módulos' }}
        </span>

        <a href="{{ route('recursos.show', $curso->slug ?? $curso->id) }}"
           class="px-4 py-2 bg-navy hover:bg-brandgreen text-white font-bold  rounded-xl transition-all duration-200 flex items-center gap-1 shadow-md shadow-navy/10 group-hover:shadow-brandgreen/20">
            <span>Ver recursos</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>

</div>