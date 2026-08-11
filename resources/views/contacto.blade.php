@extends('layouts.app')

@section('content')
    <div class="bg-gray-50/50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Encabezado Principal Hero --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <span class="text-xs font-extrabold text-brandgreen uppercase tracking-wider block mb-1">
                        Estamos para ayudarte
                    </span>
                    <h1 class="text-3xl sm:text-5xl font-black text-navy tracking-tight leading-tight">
                        Contacto
                    </h1>
                    <p class="text-gray-600 text-base sm:text-lg mt-3">
                        ¿Tienes dudas sobre nuestras áreas de formación, cursos o materiales? Ponte en contacto con
                        nosotros.
                    </p>
                </div>
                <div
                    class="absolute -right-10 -bottom-10 w-64 h-64 bg-gradient-to-br from-brandorange/10 to-brandgreen/10 rounded-full blur-2xl pointer-events-none">
                </div>
            </div>

            {{-- GRID PRINCIPAL --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- Tarjeta con datos directos (Ocupa 2 columnas en desktop) --}}
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-6 h-full">
                    <h3 class="text-lg font-extrabold text-navy border-b border-gray-100 pb-3">
                        Información de contacto
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Correo Electrónico --}}
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-emerald-50 text-brandgreen rounded-2xl shrink-0 border border-emerald-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-400 block uppercase tracking-wider">Atención por
                                    Correo</span>
                                <a href="mailto: {{ $contacto['email']?? '' }}"
                                    class="text-sm font-bold text-navy hover:text-brandgreen transition-colors">
                                    {{ $contacto['email']?? '' }}
                                </a>
                            </div>
                        </div>

                        {{-- Teléfono / WhatsApp --}}
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-sky-50 text-sky-600 rounded-2xl shrink-0 border border-sky-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-400 block uppercase tracking-wider">
                                    Teléfono</span>
                                <a href="tel:{{ $contacto['telefono']?? '' }}"
                                    class="text-sm font-bold text-navy hover:text-brandgreen transition-colors">
                                    {{ $contacto['telefono']?? '' }}
                                </a>
                            </div>
                        </div>

                        {{-- Horarios --}}
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl shrink-0 border border-amber-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-400 block uppercase tracking-wider">Horario de
                                    Atención</span>
                                <p class="text-sm font-bold text-navy">
                                    {{ $contacto['horario_dias'] ?? 'Lunes a Viernes' }}<br>
                                    <span class="text-xs text-gray-500 font-medium">
                                        {{ $contacto['horario_horas'] ?? '9:00 AM - 6:00 PM' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-violet-50 text-violet-600 rounded-2xl shrink-0 border border-violet-100">
                                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <span
                                    class="text-xs font-bold text-gray-400 block uppercase tracking-wider">Dirección</span>
                                <p class="text-sm font-bold text-navy">

                                    <span
                                        class="text-sm font-bold text-navy hover:text-brandgreen transition-colors">{{ $contacto['dirección'] }}</span>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>



                {{-- Tarjeta Informativa Directa (Ocupa 1 columna en desktop) --}}
                <div
                    class="lg:col-span-1 bg-navy rounded-3xl p-6 text-white space-y-3 relative overflow-hidden shadow-md h-full flex flex-col justify-between">
                    <div class="relative z-10">
                        <h4 class="text-lg font-black mt-3">¿Buscas recursos específicos?</h4>
                        <p class="text-xs text-gray-300 leading-relaxed mt-1">
                            Recuerda que puedes consultar todos los materiales didácticos organizados por áreas de formación
                            directamente.
                        </p>
                    </div>

                    <div class="relative z-10 pt-4">
                        <a href="{{ route('recursos.index') }}"
                            class="inline-flex items-center gap-1 text-xs font-bold text-brandgreen hover:underline">
                            <span>Explorar Catálogo</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <div
                        class="absolute -right-6 -bottom-6 w-32 h-32 bg-brandgreen/20 rounded-full blur-xl pointer-events-none">
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
