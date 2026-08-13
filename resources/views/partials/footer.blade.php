<footer class="bg-navy text-white mt-10 sm:mt-14" id="footer">
    <div class="max-w-full mx-auto px-4 sm:px-6 py-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 md:divide-x md:divide-white/20 text-md items-center">
        
        {{-- Columna 1: Imagen / Logo 1 --}}
        <div class="flex items-center justify-center md:justify-start pb-6 sm:pb-0 md:pr-6">
            <img src="{{ asset('img/logo-udg.svg') }}" alt="Logo UdeG" class="w-full max-w-[0px] h-auto object-contain">
        </div>

        {{-- Columna 2: Imagen / Logo 2 --}}
        <div class="flex items-center justify-center md:justify-start pb-6 sm:pb-0 md:px-6">
            <img src="{{ asset('img/cucshBlanco.png') }}" alt="Logo sUAM" class="mx-auto w-full max-w-[200px] h-auto object-contain">
        </div>

        {{-- Columna 3: Contacto --}}
        <div class="pb-6 sm:pb-0 md:px-6">
            <h3 class="font-semibold text-white mb-3">Contacto</h3>
            <ul class="space-y-2.5 text-white/70">
                @if (!empty($contacto['telefono']))
                    <li>
                        <a href="tel:{{ $contacto['telefono'] }}"
                            class="flex items-center gap-2 hover:text-white transition-colors">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ $contacto['telefono'] }}</span>
                        </a>
                    </li>
                @endif

                @if (!empty($contacto['email']))
                    <li>
                        <a href="mailto:{{ $contacto['email'] }}"
                            class="flex items-center gap-2 hover:text-white transition-colors">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $contacto['email'] }}</span>
                        </a>
                    </li>
                @endif

                @if (!empty($contacto['horario_dias']))
                    <li class="flex items-start gap-2 pt-1">
                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-bold text-white">{{ $contacto['horario_dias'] }}</p>
                            <p class="text-[11px] text-white/60 font-medium">{{ $contacto['horario_horas'] ?? '' }}</p>
                        </div>
                    </li>
                @endif
            </ul>
        </div>

        {{-- Columna 4: Redes Sociales --}}
        <div class="md:pl-6">
            <h3 class="font-semibold text-white mb-3">Síguenos</h3>
            <p class="text-xs text-white/70 mb-3">Visita nuestras redes sociales para mantenerte informado:</p>
            <div class="flex flex-wrap gap-3">
                <a href="https://www.facebook.com/SUAMUdeG/" target="_blank" rel="noopener noreferrer"
                    class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors"
                    aria-label="Facebook">
                    <img src="{{ asset('social/facebook.svg') }}" alt="Facebook" class="w-5 h-5">
                </a>

                <a href="https://www.instagram.com/suam_udg" target="_blank" rel="noopener noreferrer"
                    class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors"
                    aria-label="Instagram">
                    <img src="{{ asset('social/instagram.svg') }}" alt="Instagram" class="w-5 h-5">
                </a>

                <a href="https://www.youtube.com/@suam_udg" target="_blank" rel="noopener noreferrer"
                    class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors"
                    aria-label="YouTube">
                    <img src="{{ asset('social/youtube.svg') }}" alt="YouTube" class="w-5 h-5">
                </a>

                <a href="https://x.com/suam_udg" target="_blank" rel="noopener noreferrer"
                    class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors"
                    aria-label="X">
                    <img src="{{ asset('social/x-twitter.svg') }}" alt="X" class="w-5 h-5">
                </a>
            </div>
        </div>

    </div>
</footer>