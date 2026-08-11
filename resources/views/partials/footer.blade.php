<footer class="bg-navy  text-white mt-10 sm:mt-14" id="footer">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
        <div>
            <div class="font-semibold mb-2">Síguenos en nuestras redes sociales</div>
            <div class="flex gap-3">
                <a href="#"
                    class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20">f</a>
                <a href="#"
                    class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20">ig</a>
                <a href="#"
                    class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20">▶</a>
                <a href="#"
                    class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20">tw</a>
            </div>
        </div>
        <div>
            <h3 class="font-semibold text-white mb-3">Contacto</h3>
            <ul class="space-y-2.5 text-xs text-white/70">
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
    </div>
</footer>
