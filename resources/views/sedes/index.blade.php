@extends('layouts.app')

@section('title', 'SUAM — SEDES')

@section('content')
    <div x-data="{ openModal: false, activeSede: {} }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- ENCABEZADO --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-200 pb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Nuestras Sedes</h1>
                <p class="text-sm text-gray-500 mt-1">Conoce la ubicación y detalles de todos nuestros puntos de atención.
                </p>
            </div>
        </div>

        {{-- GRID DE TARJETAS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($sedes as $item)
                <div
                    class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between overflow-hidden group">

                    <div>
                        {{-- Logo de la Sede --}}
                        <div
                            class="relative h-48 bg-gray-50 border-b border-gray-100 flex items-center justify-center p-6 overflow-hidden">
                            <img src="{{ $item->url_logo }}"
                                class="max-h-full max-w-full object-contain transform group-hover:scale-105 transition-transform duration-300"
                                alt="Logo-{{ $item->slug }}" />
                        </div>

                        {{-- Info rápida --}}
                        <div class="p-6 space-y-3">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-navy transition-colors">
                                {{ $item->nombre }}
                            </h3>

                            <div class="flex items-start text-sm text-gray-600 space-x-2">
                                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="line-clamp-2">{{ $item->direccion }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- BOTÓN APERTURA MODAL --}}
                    <div class="p-6 pt-0">
                        <button type="button" @click="activeSede = {{ json_encode($item) }}; openModal = true"
                            class="w-full text-center bg-gray-900 text-white text-sm font-semibold py-2.5 px-4 rounded-xl hover:bg-navy transition-colors duration-200 inline-flex items-center justify-center space-x-2">
                            <span>Ver más detalles</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500">No hay sedes registradas por el momento.</p>
                </div>
            @endforelse
        </div>

        {{-- MODAL EN ALPINE.JS --}}
        <div x-show="openModal" x-cloak @keydown.escape.window="openModal = false"
            class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            {{-- Fondo oscuro con blur --}}
            <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="openModal = false"
                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

            {{-- Ventana Modal --}}
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="openModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    {{-- Botón Cerrar (X) --}}
                    <button @click="openModal = false"
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 bg-gray-100 rounded-full p-1 transition-colors z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    {{-- Header con Imagen en el Modal --}}
                    <div class="bg-gray-50 border-b border-gray-100 p-8 flex items-center justify-center h-48">
                        <img :src="activeSede.url_logo" :alt="activeSede.nombre"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    {{-- Cuerpo del Modal --}}
                    <div class="p-6 space-y-4">
                        <h2 class="text-2xl font-bold text-gray-900" x-text="activeSede.nombre"></h2>

                        <div class="space-y-3 border-t border-gray-100 pt-4">
                            {{-- Dirección --}}
                            <div class="flex items-start space-x-3 text-gray-600">
                                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dirección</p>
                                    <p class="text-sm text-gray-800" x-text="activeSede.direccion"></p>
                                </div>
                            </div>

                            {{-- Teléfono (si existe en el objeto) --}}
                            <template x-if="activeSede.telefono">
                                <div class="flex items-start space-x-3 text-gray-600">
                                    <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Teléfono
                                        </p>
                                        <p class="text-sm text-gray-800" x-text="activeSede.telefono"></p>
                                    </div>
                                </div>
                            </template>
                            {{-- Sección de Correos --}}
                            {{-- CORREOS ELECTRÓNICOS --}}
                            <template x-if="activeSede.correo && activeSede.correo.length > 0">
                                <div class="flex items-start space-x-3 text-gray-600">
                                    <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <div class="w-full">
                                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                                            Correos de contacto</p>
                                        <div class="space-y-1">
                                            <template x-for="(item, index) in activeSede.correo" :key="index">
                                                <template x-if="item.correo">
                                                    <a :href="'mailto:' + item.correo" x-text="item.correo"
                                                        class="block text-sm text-navy hover:underline font-medium break-all"></a>
                                                </template>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            {{-- REDES SOCIALES --}}
                            <template x-if="activeSede.redes_sociales && activeSede.redes_sociales.length > 0">
                                <div class="flex items-start space-x-3 text-gray-600 border-t border-gray-100 pt-3">
                                    <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    <div class="w-full">
                                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Redes
                                            y Sitio Web</p>
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="(item, index) in activeSede.redes_sociales"
                                                :key="index">
                                                <template x-if="item.enlace">
                                                    <a :href="item.enlace" target="_blank" rel="noopener noreferrer"
                                                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition-colors">
                                                        {{-- Transforma 'facebook' a 'Facebook', 'twitter' a 'Twitter', etc. --}}
                                                        <span class="capitalize"
                                                            x-text="item.red === 'twitter' ? 'Twitter / X' : (item.red === 'web' ? 'Página Web' : item.red)"></span>

                                                        {{-- Icono de enlace externo --}}
                                                        <svg class="w-3 h-3 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                        </svg>
                                                    </a>
                                                </template>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Footer del Modal --}}
                    <div class="bg-gray-50 px-6 py-4 flex justify-end">
                        <button type="button" @click="openModal = false"
                            class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-300 transition-colors">
                            Cerrar
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
