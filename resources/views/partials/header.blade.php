<header x-data="{
    mobileMenuOpen: false,
    mobileSearchOpen: false
}"
    class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40 transition-all duration-200">

    {{-- BARRA SUPERIOR (LOGO Y BÚSQUEDA) --}}
    <div class="max-w-7xl mx-auto flex items-center justify-between px-3 sm:px-6 text-base">

        {{-- Espaciador fantasma a la izquierda para balancear el centro en pantallas grandes --}}
        <div class="flex-1 hidden lg:block"></div>

        {{-- Logo centrado --}}
        <div class="flex items-center justify-center flex-1 lg:flex-initial">
            <a href="{{ route('home') }}" class="flex items-center group shrink-0">
                <div class="p-1 rounded-lg group-hover:bg-gray-50 transition-colors">
                    <img src="{{ asset('img/logo.png') }}" alt="sUAM" class="h-16 sm:h-[65px] w-auto object-contain"
                        style="height: 90px;">
                </div>
            </a>
        </div>

        {{-- Acciones (Buscador Desktop & Togglers Móvil) cargadas a la derecha --}}
        <div class="flex items-center justify-end gap-1 sm:gap-2 flex-1 shrink-0 mb-2" style="font-size: 12px;">

            {{-- Buscador Desktop estilizado (Visible solo en LG+) --}}
            <form action="{{ route('buscar') }}" method="GET" class="relative hidden lg:block">
                <input type="text" name="q" placeholder="Buscar cursos, sedes..."
                    class="bg-gray-50 border border-gray-200/80 rounded-full pl-4 pr-10 py-2 w-44 md:w-64 focus:outline-none focus:bg-white focus:border-navy focus:ring-4 focus:ring-navy/5 transition-all duration-200 shadow-inner" />
                <button type="submit"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-navy transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>

            {{-- Botón Buscar Móvil (Visible hasta LG) --}}
            <button @click="mobileSearchOpen = !mobileSearchOpen; mobileMenuOpen = false"
                class="lg:hidden w-9 h-9 flex items-center justify-center text-gray-600 hover:text-navy rounded-full hover:bg-gray-100 transition-colors"
                aria-label="Buscar">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>

            {{-- Botón Menú Hamburguesa Móvil (Visible hasta LG) --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen; mobileSearchOpen = false"
                class="lg:hidden w-9 h-9 flex items-center justify-center text-navy rounded-xl hover:bg-gray-100 transition-colors"
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
        class="lg:hidden px-4 pb-3 border-t border-gray-100 pt-2 bg-gray-50/50">
        <form action="{{ route('buscar') }}" method="GET" class="relative">
            <input type="text" name="q" placeholder="¿Qué deseas buscar hoy?"
                class="w-full text-base bg-white border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/20 shadow-sm" />
            <button type="submit" class="absolute right-3 top-3 text-navy">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>
    </div>

    {{-- BARRA DE NAVEGACIÓN PRINCIPAL (DESKTOP) --}}
    {{-- Cambiado a hidden lg:block para que solo se muestre en pantallas de 1024px o más --}}
    <nav class="bg-navy shadow-lg shadow-navy/10 hidden lg:block">
        <div class="max-w-full mx-auto px-2 xl:px-6 flex justify-center">
            {{-- Añadido text-sm xl:text-base para ahorrar espacio en pantallas LG --}}
            <div class="flex items-center gap-0.5 xl:gap-2 text-sm xl:text-base text-white/80 font-medium whitespace-nowrap">

                {{-- Link Inicio --}}
                <a href="{{ route('home') }}"
                    class="relative py-3.5 px-2 xl:px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('home') ? 'text-white font-semibold' : '' }}">
                    <span>Inicio</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('home') ? 'scale-x-100' : '' }}"></span>
                </a>

                {{-- Dropdown Acerca de --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open"
                        class="relative py-3.5 px-2 xl:px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('home.acerca', 'sedes.index') ? 'text-white font-semibold' : '' }}">
                        <span>Acerca de</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                            :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                        <span
                            class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 
                            {{ request()->routeIs('home.acerca', 'sedes.*') ? 'scale-x-100' : '' }}"></span>
                    </button>

                    <div x-show="open" x-transition
                        class="absolute left-0 mt-2 w-56 rounded-lg bg-white shadow-lg ring-1 ring-black/5 py-2 z-50"
                        style="display: none;">
                        <a href="{{ route('home.acerca') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('home.acerca') ? 'font-semibold text-brandgreen' : '' }}">
                            Presentación
                        </a>
                        <a href="{{ route('sedes.index') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('sedes.*') ? 'font-semibold text-brandgreen' : '' }}">
                            Sedes
                        </a>
                    </div>
                </div>

                {{-- Link Convocatorias --}}
                <a href="{{ route('convocatorias.index') }}"
                    class="relative py-3.5 px-2 xl:px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('convocatorias.*') ? 'text-white font-semibold' : '' }}">
                    <span>Convocatorias</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('convocatorias.*') ? 'scale-x-100' : '' }}"></span>
                </a>

                {{-- Link Cursos --}}
                <a href="{{ route('cursos.index') }}"
                    class="relative py-3.5 px-2 xl:px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('cursos.*') ? 'text-white font-semibold' : '' }}">
                    <span>Cursos y Talleres</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('cursos.*') ? 'scale-x-100' : '' }}"></span>
                </a>

                {{-- Link Recursos --}}
                <a href="{{ route('recursos.index') }}"
                    class="relative py-3.5 px-2 xl:px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('recursos.*') ? 'text-white font-semibold' : '' }}">
                    <span>Recursos</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('recursos.*') ? 'scale-x-100' : '' }}"></span>
                </a>

                {{-- Link Eventos --}}
                <a href="{{ route('eventos.index') }}"
                    class="relative py-3.5 px-2 xl:px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('eventos.*') ? 'text-white font-semibold' : '' }}">
                    <span>Eventos y Actividades</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('eventos.*') ? 'scale-x-100' : '' }}"></span>
                </a>

                {{-- Dropdown Estudiantes --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open"
                        class="relative py-3.5 px-2 xl:px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('home.testimonios*', 'home.etica') ? 'text-white font-semibold' : '' }}">
                        <span>Estudiantes</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                            :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                        <span
                            class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('home.testimonios*', 'home.etica') ? 'scale-x-100' : '' }}"></span>
                    </button>

                    <div x-show="open" x-transition
                        class="absolute left-0 mt-2 w-56 rounded-lg bg-white shadow-lg ring-1 ring-black/5 py-2 z-50"
                        style="display: none;">
                        <a href="{{ route('home.testimonios') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('home.testimonios') ? 'font-semibold text-brandgreen' : '' }}">
                            Testimonios
                        </a>
                        <a href="{{ route('home.etica') }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('home.etica') ? 'font-semibold text-brandgreen' : '' }}">
                            Código de ética
                        </a>
                    </div>
                </div>

                {{-- Link Publicaciones --}}
                <a href="{{ route('publicaciones.index') }}"
                    class="relative py-3.5 px-2 xl:px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('publicaciones.*') ? 'text-white font-semibold' : '' }}">
                    <span>Publicaciones</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('publicaciones.*') ? 'scale-x-100' : '' }}"></span>
                </a>

                {{-- Link Contacto --}}
                <a href="{{ route('contacto') }}"
                    class="relative py-3.5 px-2 xl:px-3.5 transition-colors duration-200 hover:text-white flex items-center gap-1.5 group {{ request()->routeIs('contacto') ? 'text-white font-semibold' : '' }}">
                    <span>Contacto</span>
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brandgreen transition-transform duration-200 transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('contacto') ? 'scale-x-100' : '' }}"></span>
                </a>

            </div>
        </div>
    </nav>

    {{-- MENÚ MÓVIL DESPLEGABLE (FLYOUT) --}}
    {{-- Cambiado a lg:hidden para que se oculte a partir de 1024px --}}
    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="lg:hidden bg-navy border-t border-white/10 text-white">

        <div class="px-4 pt-3 pb-6 space-y-1">
            {{-- TODO EL CONTENIDO DEL MENÚ MÓVIL SE MANTIENE INTACTO --}}
            <a href="{{ route('home') }}"
                class="block py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('home') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                Inicio
            </a>

            <div x-data="{ open: {{ request()->routeIs('home.acerca', 'sedes.index') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('home.acerca', 'sedes.index') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                    <span>Acerca de</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="pl-3 mt-1 space-y-1">
                    <a href="{{ route('home.acerca') }}"
                        class="block py-2 px-3 rounded-lg  transition-colors {{ request()->routeIs('home.acerca') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        Presentación
                    </a>
                    <a href="{{ route('sedes.index') }}"
                        class="block py-2 px-3 rounded-lg  transition-colors {{ request()->routeIs('sedes.index') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        Sedes
                    </a>
                </div>
            </div>

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
                class="block py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('eventos.*') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                Eventos y Actividades
            </a>
            
            <div x-data="{ open: {{ request()->routeIs('home.testimonios*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('home.testimonios*') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                    <span>Estudiantes</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="pl-3 mt-1 space-y-1">
                    <a href="{{ route('home.testimonios') }}"
                        class="block py-2 px-3 rounded-lg  transition-colors {{ request()->routeIs('home.testimonios') ? 'bg-white/10 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        Testimonios
                    </a>
                    <a href="{{ route('home.etica') }}"
                        class="block py-2 px-3 rounded-lg  text-white/70 hover:bg-white/5 hover:text-white transition-colors">
                        Código de ética
                    </a>
                </div>
            </div>

            <a href="{{ route('publicaciones.index') }}"
                class="block py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('publicaciones.*') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                Publicaciones
            </a>

            <a href="{{ route('contacto') }}"
                class="block py-2.5 px-3 rounded-lg text-base font-medium transition-colors {{ request()->routeIs('contacto') ? 'bg-white/10 text-white font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                Contacto
            </a>
        </div>
    </div>
</header>