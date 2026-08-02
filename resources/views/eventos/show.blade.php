@extends('layouts.app')

@push('styles')
    {{-- CSS de lightGallery y sus plugins (Zoom y Miniaturas) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/css/lightgallery-bundle.min.css">
@endpush

@section('content')
    <div class="min-h-screen bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">
        {{-- Contenedor principal ampliado para el diseño de dos columnas --}}
        <div class="max-w-6xl mx-auto space-y-8">
            {{-- Grid Principal: Imagen Izquierda / Contenido Derecha --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- COLUMNA IZQUIERDA: Imagen Destacada --}}
                <div class="lg:col-span-5 relative">
                    @if ($evento->imagen)
                        <div class="w-full h-80 sm:h-96 lg:h-full lg:min-h-[500px] relative rounded-3xl overflow-hidden shadow-sm bg-gray-900 sticky top-8">
                            <img src="{{ Storage::url($evento->imagen) }}" alt="{{ $evento->nombre }}"
                                class="w-full h-full object-cover">
                            {{-- Capa de gradiente muy sutil por estética --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/30 to-transparent"></div>
                        </div>
                    @else
                        {{-- Imagen alternativa si no hay --}}
                        <div class="w-full h-80 sm:h-96 lg:h-full lg:min-h-[500px] bg-navy rounded-3xl relative overflow-hidden shadow-sm sticky top-8 flex items-center justify-center">
                            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/20 to-brandgreen/20 rounded-full blur-2xl pointer-events-none"></div>
                            <svg class="w-24 h-24 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- COLUMNA DERECHA: Nombre y Descripción --}}
                <div class="lg:col-span-7 bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-10 flex flex-col gap-6">
                    
                    {{-- Encabezado (Badge, Título y Fecha) --}}
                    <div class="border-b border-gray-100 pb-6">
                        {{-- Se ajustó el color de texto a navy ya que ahora está sobre fondo blanco --}}
                        <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                            {{ $evento->nombre }}
                        </h1>
                        
                        <div class="text-gray-500 text-xs sm:text-sm mt-4 flex items-center gap-2 font-medium">
                            <svg class="w-4 h-4 text-brandorange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $evento->created_at->translatedFormat('d \d\e F, Y') }}
                        </div>
                    </div>

                    {{-- Cuerpo del Contenido --}}
                    <div class="text-gray-600 prose prose-sm sm:prose-base prose-navy max-w-none">
                        {!! $evento->contenido !!}
                    </div>
                </div>
                
            </div> {{-- Fin del Grid Principal --}}

            {{-- PARTE INFERIOR: Sección de Galería (Abarca todo el ancho del max-w-6xl) --}}
            @if (!empty($evento->galeria) && is_array($evento->galeria) && count($evento->galeria) > 0)
                <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-sm space-y-6">

                    {{-- Título de la galería --}}
                    <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                        <div class="p-2.5 bg-brandorange/10 text-brandorange rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-navy tracking-tight">
                            Galería del evento
                        </h3>
                    </div>

                    {{-- Contenedor lightGallery --}}
                    <div id="lightgallery-evento" class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-5">
                        @foreach ($evento->galeria as $imagen)
                            <a data-src="{{ Storage::url($imagen) }}"
                                class="block aspect-square overflow-hidden rounded-2xl group relative bg-gray-50 border border-gray-100 cursor-pointer">

                                <img src="{{ Storage::url($imagen) }}" alt="Fotografía del evento"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                                {{-- Overlay Hover --}}
                                <div
                                    class="absolute inset-0 bg-navy/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    {{-- JS de lightGallery Core y Plugins --}}
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/lightgallery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/plugins/thumbnail/lg-thumbnail.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/plugins/zoom/lg-zoom.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const galleryContainer = document.getElementById('lightgallery-evento');

            if (galleryContainer) {
                lightGallery(galleryContainer, {
                    plugins: [lgZoom, lgThumbnail],
                    speed: 500,
                    download: false,
                    mobileSettings: {
                        controls: false,
                        showCloseIcon: true,
                        download: false,
                    }
                });
            }
        });
    </script>
@endpush