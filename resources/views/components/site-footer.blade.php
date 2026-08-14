@php
    $localePrefix = app()->getLocale() === 'en' ? 'en.' : '';
    $isFr = app()->getLocale() === 'fr';
@endphp

<footer class="pb-8 text-white border-t bg-primary-dark pt-14 border-primary/20">
    <div class="grid max-w-6xl gap-10 px-6 pb-12 mx-auto md:grid-cols-2 lg:grid-cols-4">
        
        {{-- Colonne 1 : À propos & Horaires --}}
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="La Gloire Divine" class="rounded-full shadow-md w-14 h-14">
                <div>
                    <span class="block text-lg font-bold leading-snug font-display">La Gloire Divine</span>
                    <span class="text-xs font-medium text-accent-light">{{ __('Centre De Santé') }}</span>
                </div>
            </div>
            <p class="max-w-xs text-xs leading-relaxed text-white/70">
                {{ $isFr 
                    ? 'Humanisation des soins de qualité pour une médecine de proximité.' 
                    : 'Humanizing quality care for community-focused.' }}
            </p>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 text-xs font-semibold text-accent-light">
                <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
                {{ __('Ouvert 7j/7, 24h/24') }}
            </div>
        </div>

        {{-- Colonne 2 : Contacts & Localisation --}}
        <div class="space-y-4">
            <h3 class="text-sm font-semibold tracking-wider uppercase font-display text-accent-light">{{ __('Contact & Accès') }}</h3>
            
            <ul class="space-y-3 text-xs text-white/80">
                {{-- Localisation --}}
                <li class="flex items-start gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-accent shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <span class="block font-medium text-white/90 mb-0.5">{{ $isFr ? 'Adresse du centre' : 'Center Location' }}</span>
                        <span class="leading-normal text-white/70">Entrée Lycée, derrière le Collège La Perfection, Douala, Cameroun</span>
                    </div>
                </li>

                {{-- Ligne directe --}}
                <li class="flex items-center gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <a href="tel:+237640170487" class="font-medium transition-colors hover:text-accent-light">
                        +237 640 170 487 <span class="text-white/50 text-[11px]">({{ $isFr ? 'Appel direct' : 'Direct Call' }})</span>
                    </a>
                </li>

                {{-- WhatsApp --}}
                <li class="flex items-center gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 text-emerald-400 shrink-0" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        <path d="M12.004 2C6.486 2 2 6.486 2 12.004c0 1.998.586 3.86 1.594 5.42L2 22l4.7-1.564A9.96 9.96 0 0012.004 22C17.522 22 22 17.522 22 12.004 22 6.486 17.522 2 12.004 2zm0 18.164a8.14 8.14 0 01-4.15-1.14l-.298-.176-2.789.928.938-2.719-.194-.28a8.15 8.15 0 01-1.256-4.373c0-4.512 3.672-8.184 8.184-8.184a8.13 8.13 0 018.184 8.184c0 4.512-3.672 8.184-8.184 8.184z"/>
                    </svg>
                    <a href="https://wa.me/237682600401" target="_blank" rel="noopener" class="font-medium transition-colors hover:text-accent-light">
                        +237 682 600 401 <span class="text-white/50 text-[11px]">(WhatsApp)</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Colonne 3 : Services --}}
        <div class="space-y-4">
            <h3 class="text-sm font-semibold tracking-wider uppercase font-display text-accent-light">{{ __('Nos Services') }}</h3>
            <ul class="space-y-2 text-xs text-white/80">
                <li><a href="{{ route($localePrefix.'services.index') }}" class="hover:text-accent-light transition-colors flex items-center gap-1.5"><span class="text-accent">›</span> {{ $isFr ? 'Maternité' : 'Maternity' }}</a></li>
                <li><a href="{{ route($localePrefix.'services.index') }}" class="hover:text-accent-light transition-colors flex items-center gap-1.5"><span class="text-accent">›</span> {{ $isFr ? 'Kinésithérapie' : 'Physiotherapy' }}</a></li>
                <li><a href="{{ route($localePrefix.'services.index') }}" class="hover:text-accent-light transition-colors flex items-center gap-1.5"><span class="text-accent">›</span> {{ $isFr ? 'Laboratoire' : 'Laboratory' }}</a></li>
                <li><a href="{{ route($localePrefix.'services.index') }}" class="hover:text-accent-light transition-colors flex items-center gap-1.5"><span class="text-accent">›</span> {{ $isFr ? 'Médecine générale' : 'General medicine' }}</a></li>
                <li><a href="{{ route($localePrefix.'services.index') }}" class="hover:text-accent-light transition-colors flex items-center gap-1.5"><span class="text-accent">›</span> {{ $isFr ? 'Petite chirurgie' : 'Minor surgery' }}</a></li>
                <li><a href="{{ route($localePrefix.'services.index') }}" class="hover:text-accent-light transition-colors flex items-center gap-1.5"><span class="text-accent">›</span> {{ $isFr ? 'Pédiatrie' : 'Pediatrics' }}</a></li>
            </ul>
        </div>

        {{-- Colonne 4 : Réseaux & Modes de paiement --}}
        <div class="space-y-5">
            <div>
                <h3 class="mb-3 text-sm font-semibold tracking-wider uppercase font-display text-accent-light">{{ $isFr ? 'Rejoignez-nous' : 'Follow Us' }}</h3>
                <div class="flex gap-2.5">
                    <a href="https://wa.me/237682600401" target="_blank" rel="noopener" aria-label="WhatsApp"
                       class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-emerald-500 hover:text-white transition-all transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 text-emerald-400 shrink-0" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        <path d="M12.004 2C6.486 2 2 6.486 2 12.004c0 1.998.586 3.86 1.594 5.42L2 22l4.7-1.564A9.96 9.96 0 0012.004 22C17.522 22 22 17.522 22 12.004 22 6.486 17.522 2 12.004 2zm0 18.164a8.14 8.14 0 01-4.15-1.14l-.298-.176-2.789.928.938-2.719-.194-.28a8.15 8.15 0 01-1.256-4.373c0-4.512 3.672-8.184 8.184-8.184a8.13 8.13 0 018.184 8.184c0 4.512-3.672 8.184-8.184 8.184z"/>
                    </svg>
                    </a>
                    <a href="#" target="_blank" rel="noopener" aria-label="Facebook"
                       class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-blue-600 hover:text-white transition-all transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor">
                            <path d="M22 12.06C22 6.505 17.523 2 12 2S2 6.505 2 12.06c0 5.022 3.657 9.184 8.438 9.94v-7.03H7.898v-2.91h2.54V9.845c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.462h-1.26c-1.243 0-1.63.771-1.63 1.562v1.877h2.773l-.443 2.91h-2.33V22c4.78-.756 8.437-4.918 8.437-9.94z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Modes de paiement acceptés --}}
            <div class="pt-2 border-t border-white/10">
                <span class="block text-[11px] font-semibold text-white/60 mb-2 uppercase tracking-wider">
                    {{ $isFr ? 'Modes de paiement acceptés' : 'Accepted Payments' }}
                </span>
                <div class="flex flex-wrap gap-1.5 text-[11px]">
                    <span class="px-2.5 py-1 rounded bg-white/10 text-orange-300 font-medium">Orange Money</span>
                    <span class="px-2.5 py-1 rounded bg-white/10 text-yellow-300 font-medium">MTN MoMo</span>
                    <span class="px-2.5 py-1 rounded bg-white/10 text-emerald-300 font-medium">{{ $isFr ? 'Espèces' : 'Cash' }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Sub-footer / Copyright --}}
    <div class="pt-6 text-xs text-center border-t border-white/10 text-white/50">
        <p>© {{ date('Y') }} La Gloire Divine — {{ __('Tous droits réservés.') }}</p>
    </div>
</footer>