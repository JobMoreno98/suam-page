<header x-data="{
    mobileMenuOpen: false,
    mobileSearchOpen: false
}"
    class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40 transition-all duration-200">

    {{-- BARRA SUPERIOR (LOGO Y BÚSQUEDA) --}}
<div class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 py-3.5 gap-2 sm:gap-4">

        {{-- Logos e Identidad --}}
        {{-- Quitamos min-w-0 y ponemos shrink-0 para que no colapsen --}}
        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            
            {{-- Logo UdeG --}}
            <a href="https://udg.mx" class="flex items-center group shrink-0">
                <div class="p-1 rounded-lg group-hover:bg-gray-50 transition-colors">
                    {{-- Cambiamos el style fijo por h-8 (móvil) y sm:h-[50px] (PC) --}}
                    <img src="{{ asset('img/udg-logo.jpg') }}" alt="UdeG" class="h-8 sm:h-[50px] w-auto object-contain">
                </div>
            </a>

            <div class="w-px h-7 bg-gray-200 hidden sm:block shrink-0"></div>

            {{-- Logo sUAM --}}
            <a href="{{ route('home') }}" class="flex items-center group shrink-0">
                <div class="p-1 rounded-lg group-hover:bg-gray-50 transition-colors">
                    <img src="{{ asset('img/logo.png') }}" alt="sUAM" class="h-8 sm:h-[50px] w-auto object-contain">
                </div>
            </a>
            
        </div>

        {{-- Acciones (Buscador Desktop & Togglers Móvil) --}}
        <div class="flex items-center gap-2 shrink-0">

            {{-- Buscador Desktop estilizado --}}
            <form action="{{ route('buscar') }}" method="GET" class="relative hidden sm:block">
                <input type="text" name="q" placeholder="Buscar cursos, sedes..."
                    class="text-xs bg-gray-50 border border-gray-200/80 rounded-full pl-4 pr-10 py-2 w-44 md:w-64 focus:outline-none focus:bg-white focus:border-navy focus:ring-4 focus:ring-navy/5 transition-all duration-200 shadow-inner" />
                <button type="submit"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>

            {{-- Botón Buscar Móvil --}}
            <button @click="mobileSearchOpen = !mobileSearchOpen; mobileMenuOpen = false"
                class="sm:hidden w-10 h-10 flex items-center justify-center text-gray-600 hover:text-navy rounded-full hover:bg-gray-100 transition-colors"
                aria-label="Buscar">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>

            {{-- Botón Menú Hamburguesa Móvil --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen; mobileSearchOpen = false"
                class="md:hidden w-10 h-10 flex items-center justify-center text-navy rounded-xl hover:bg-gray-100 transition-colors"
                aria-label="Abrir menú">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Buscador Móvil Desplegable --}}
    <div x-show="mobileSearchOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="sm:hidden px-4 pb-3 border-t border-gray-100 pt-2 bg-gray-50/50">
        <form action="" method="GET" class="relative">
            <input type="text" name="q" placeholder="¿Qué deseas buscar hoy?"
                class="w-full text-sm bg-white border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/20 shadow-sm" />
            <button type="submit" class="absolute right-3 top-3 text-navy">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>
    </div>

    {{-- BARRA DE NAVEGACIÓN PRINCIPAL (DESKTOP) --}}
    <nav class="bg-navy shadow-lg shadow-navy/10 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-center gap-1 lg:gap-2 text-sm text-white/80 font-medium">

                {{-- Link Inicio --}}
                <a href="{{ route('home') }}"
                    class="relative py-3.5 px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('home') ? 'text-white font-semibold' : '' }}">
                    <span>Inicio</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('home') ? 'scale-x-100' : '' }}"></span>
                </a>

                {{-- Link Convocatorias --}}
                <a href="{{ route('convocatorias.index') }}"
                    class="relative py-3.5 px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('convocatorias.*') ? 'text-white font-semibold' : '' }}">
                    <span>Convocatorias</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('convocatorias.*') ? 'scale-x-100' : '' }}"></span>
                </a>

                {{-- Link Cursos --}}
                <a href="{{ route('cursos.index') }}"
                    class="relative py-3.5 px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('cursos.*') ? 'text-white font-semibold' : '' }}">
                    <span>Cursos y Talleres</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('cursos.*') ? 'scale-x-100' : '' }}"></span>
                </a>

                {{-- Link Recursos --}}
                <a href="{{ route('recursos.index') }}"
                    class="relative py-3.5 px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('recursos.*') ? 'text-white font-semibold' : '' }}">
                    <span>Recursos</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('recursos.*') ? 'scale-x-100' : '' }}"></span>
                </a>

                <a href="{{ route('eventos.index') }}"
                    class="relative py-3.5 px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('recursos.*') ? 'text-white font-semibold' : '' }}">
                    <span>Eventos</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('recursos.*') ? 'scale-x-100' : '' }}"></span>
                </a>

                {{-- Link Sedes --}}
                <a href="{{ route('sedes.index') }}"
                    class="relative py-3.5 px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('sedes.*') ? 'text-white font-semibold' : '' }}">
                    <span>Sedes</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('sedes.*') ? 'scale-x-100' : '' }}"></span>
                </a>

                {{-- Link Contacto --}}
                <a href="{{ route('contacto') }}"
                    class="relative py-3.5 px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('contacto') ? 'text-white font-semibold' : '' }}">
                    <span>Contacto</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('contacto') ? 'scale-x-100' : '' }}"></span>
                </a>

            </div>
        </div>
    </nav>

    {{-- MENÚ MÓVIL DESPLEGABLE (FLYOUT) --}}
    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden bg-navy border-t border-white/10 text-white">
        <div class="px-4 pt-3 pb-6 space-y-1">
            <a href="{{ route('home') }}"
                class="block py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('home') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                Inicio
            </a>
            <a href="{{ route('convocatorias.index') }}"
                class="block py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('convocatorias.*') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                Convocatorias
            </a>
            <a href="{{ route('cursos.index') }}"
                class="block py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('cursos.*') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                Cursos y Talleres
            </a>
            <a href="{{ route('recursos.index') }}"
                class="block py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('recursos.*') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                Recursos
            </a>

            <a href="{{ route('eventos.index') }}"
                class="block py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('recursos.*') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                Eventos
            </a>
            <a href="{{ route('sedes.index') }}"
                class="block py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('sedes.*') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                Sedes
            </a>
            <a href="{{ route('contacto') }}"
                class="block py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('contacto') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                Contacto
            </a>
        </div>
    </div>
</header>
