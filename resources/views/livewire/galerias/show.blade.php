<?php

use App\Models\Galeria;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component
{
    public Galeria $galeria;
    public ?int $imagenActivaIndex = null;

    public function mount(Galeria $galeria): void
    {
        // Evita cargar galerías inactivas al público
        abort_unless($galeria->activa, 404);

        $this->galeria = $galeria->load('imagenes');
    }

    public function abrirLightbox(int $index): void
    {
        $this->imagenActivaIndex = $index;
    }

    public function cerrarLightbox(): void
    {
        $this->imagenActivaIndex = null;
    }

    public function siguiente(): void
    {
        $total = $this->galeria->imagenes->count();
        $this->imagenActivaIndex = ($this->imagenActivaIndex + 1) % $total;
    }

    public function anterior(): void
    {
        $total = $this->galeria->imagenes->count();
        $this->imagenActivaIndex = ($this->imagenActivaIndex - 1 + $total) % $total;
    }

    public function with(): array
    {
        return [
            'imagenActiva' => $this->imagenActivaIndex !== null
                ? $this->galeria->imagenes[$this->imagenActivaIndex]
                : null,
        ];
    }
}; ?>

<div class="max-w-6xl mx-auto px-4 py-12">

    {{-- Encabezado --}}
    <div class="mb-10 text-center" data-aos="fade-up">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-800">
            {{ $galeria->titulo }}
        </h1>
        @if($galeria->descripcion)
            <p class="mt-3 text-slate-500 max-w-2xl mx-auto">
                {{ $galeria->descripcion }}
            </p>
        @endif
    </div>

    {{-- Grid de imágenes --}}
    @if($galeria->imagenes->isEmpty())
        <p class="text-center text-slate-400 py-16">
            Esta galería aún no tiene imágenes.
        </p>
    @else
        <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
            @foreach($galeria->imagenes as $index => $imagen)
                <button
                    type="button"
                    wire:click="abrirLightbox({{ $index }})"
                    class="block w-full break-inside-avoid rounded-lg overflow-hidden group relative focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-400"
                    data-aos="fade-up"
                    data-aos-delay="{{ ($index % 8) * 50 }}"
                >
                    <img
                        src="{{ $imagen->url }}"
                        alt="{{ $imagen->alt_text ?? $imagen->titulo ?? $galeria->titulo }}"
                        loading="lazy"
                        class="w-full h-auto object-cover transition duration-300 group-hover:scale-105"
                    >
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition duration-300 flex items-end">
                        @if($imagen->titulo)
                            <span class="text-white text-sm p-3 opacity-0 group-hover:opacity-100 transition">
                                {{ $imagen->titulo }}
                            </span>
                        @endif
                    </div>
                </button>
            @endforeach
        </div>
    @endif

    {{-- Lightbox --}}
    @if($imagenActiva)
        <div
            class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center px-4"
            wire:key="lightbox-{{ $imagenActivaIndex }}"
            x-data
            @keydown.escape.window="$wire.cerrarLightbox()"
            @keydown.arrow-right.window="$wire.siguiente()"
            @keydown.arrow-left.window="$wire.anterior()"
        >
            {{-- Cerrar --}}
            <button
                wire:click="cerrarLightbox"
                class="absolute top-5 right-5 text-white/80 hover:text-white text-3xl leading-none"
                aria-label="Cerrar"
            >
                &times;
            </button>

            {{-- Anterior --}}
            @if($galeria->imagenes->count() > 1)
                <button
                    wire:click="anterior"
                    class="absolute left-3 md:left-8 text-white/70 hover:text-white text-4xl p-2"
                    aria-label="Anterior"
                >
                    &#8249;
                </button>
            @endif

            {{-- Imagen --}}
            <div class="max-w-4xl w-full" @click.outside="$wire.cerrarLightbox()">
                <img
                    src="{{ $imagenActiva->url }}"
                    alt="{{ $imagenActiva->alt_text ?? $imagenActiva->titulo ?? '' }}"
                    class="w-full max-h-[80vh] object-contain rounded"
                >
                @if($imagenActiva->titulo)
                    <p class="text-white/80 text-center mt-4 text-sm">
                        {{ $imagenActiva->titulo }}
                    </p>
                @endif
                <p class="text-white/40 text-center mt-1 text-xs">
                    {{ $imagenActivaIndex + 1 }} / {{ $galeria->imagenes->count() }}
                </p>
            </div>

            {{-- Siguiente --}}
            @if($galeria->imagenes->count() > 1)
                <button
                    wire:click="siguiente"
                    class="absolute right-3 md:right-8 text-white/70 hover:text-white text-4xl p-2"
                    aria-label="Siguiente"
                >
                    &#8250;
                </button>
            @endif
        </div>
    @endif
</div>