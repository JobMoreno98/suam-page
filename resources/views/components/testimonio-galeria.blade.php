{{--
    Componente: Galería mixta (imágenes + videos) para una card de testimonio.

    Requiere el accessor `galeria_items` en el modelo Testimonio, que transforma
    el array plano de rutas guardado por FileUpload::make('galeria')->multiple()
    en items con { tipo, url }, infiriendo 'tipo' por la extensión del archivo.
    (No hay thumbnail_url: Filament no genera miniaturas de video, así que para
    video se muestra un ícono en vez de una imagen de portada).

    Uso dentro del loop de testimonios.blade.php:
      @include('components.testimonio-galeria', ['testimonio' => $testimonio])
--}}

@php
    $galeria = $testimonio->galeria_items;
@endphp

<div x-data="{
        open: false,
        activeIndex: 0,
        items: {{ Js::from($galeria) }},
        openAt(i) { this.activeIndex = i; this.open = true; },
        next() { this.activeIndex = (this.activeIndex + 1) % this.items.length; },
        prev() { this.activeIndex = (this.activeIndex - 1 + this.items.length) % this.items.length; }
    }" class="space-y-2">

    {{-- Tira de miniaturas --}}
    @if($galeria->count())
        <div class="flex gap-2">
            @foreach($galeria->take(4) as $index => $item)
                <button type="button" @click="openAt({{ $index }})"
                    class="relative w-14 h-14 rounded-xl overflow-hidden border border-gray-200 shrink-0 group/thumb bg-gray-100">
                    @if($item['tipo'] === 'imagen')
                        <img src="{{ $item['url'] }}" alt=""
                            class="w-full h-full object-cover group-hover/thumb:scale-110 transition-transform duration-300">
                    @else
                        {{-- Sin thumbnail real disponible: placeholder con ícono de play --}}
                        <div class="w-full h-full flex items-center justify-center bg-navy">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                    @endif

                    {{-- Overlay "+N" en la última miniatura visible --}}
                    @if($loop->last && $galeria->count() > 4)
                        <span
                            class="absolute inset-0 flex items-center justify-center bg-navy/70 text-white text-xs font-bold">
                            +{{ $galeria->count() - 4 }}
                        </span>
                    @endif
                </button>
            @endforeach
        </div>
    @endif

    {{-- Lightbox / Modal --}}
    <template x-teleport="body">
        <div x-show="open" x-cloak @keydown.escape.window="open = false"
            @keydown.arrow-right.window="open && next()" @keydown.arrow-left.window="open && prev()"
            @click.self="open = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-navy/90 backdrop-blur-sm p-4"
            x-transition.opacity>

            {{-- Cerrar --}}
            <button @click="open = false"
                class="absolute top-5 right-5 text-white/80 hover:text-white transition-colors">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Prev --}}
            <button @click="prev()"
                class="absolute left-4 sm:left-8 text-white/70 hover:text-white transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            {{-- Contenido activo --}}
            <div class="max-w-4xl w-full max-h-[85vh] flex items-center justify-center">
                <template x-for="(item, i) in items" :key="i">
                    <div x-show="activeIndex === i" class="w-full">
                        <template x-if="item.tipo === 'imagen'">
                            <img :src="item.url" class="max-h-[80vh] w-full object-contain rounded-2xl">
                        </template>
                        <template x-if="item.tipo === 'video'">
                            {{-- Si tus videos van encriptados/HLS (como en bpej), sustituye este
                                 <video> por tu visor HLS existente, pasando :src="item.url" --}}
                            <video :src="item.url" controls playsinline
                                class="max-h-[80vh] w-full rounded-2xl bg-black"></video>
                        </template>
                    </div>
                </template>
            </div>

            {{-- Next --}}
            <button @click="next()"
                class="absolute right-4 sm:right-8 text-white/70 hover:text-white transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            {{-- Contador --}}
            <span class="absolute bottom-6 text-white/60 text-xs font-bold" x-text="(activeIndex + 1) + ' / ' + items.length"></span>
        </div>
    </template>
</div>