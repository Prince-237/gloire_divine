@php
$isFr = app()->getLocale() === 'fr';
$localePrefix = $isFr ? '' : 'en.';
@endphp

<x-layouts.public :title="$isFr ? 'Accueil' : 'Home'">
    

    {{-- Hero --}}
    <section class="relative flex items-center min-h-screen overflow-hidden bg-tint">
        <div class="grid items-center w-full max-w-6xl gap-8 px-6 py-12 mx-auto md:grid-cols-2 md:gap-12">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 mb-4 text-xs font-semibold tracking-widest uppercase bg-white border rounded-full text-primary border-primary/20 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ $isFr ? 'Centre de santé' : 'Health center' }}
                </span>
                <h1 class="mb-4 text-3xl font-semibold leading-tight font-display md:text-5xl text-primary-dark md:mb-6">
                    {{ $isFr
                    ? 'Humanisation des soins de qualité pour une médecine de proximité'
                    : 'Humanizing quality care for community-focused medicine' }}
                </h1>
                <p class="max-w-md mb-6 text-base leading-relaxed text-ink-soft md:text-lg md:mb-8">
                    {{ $isFr
                    ? "La Gloire Divine vous accueille 24h/24, 7j/7 — Entrée Lycée, derrière le Collège La Perfection, Douala."
                    : 'La Gloire Divine welcomes you 24/7 — Entrée Lycée, behind Collège La Perfection, Douala.' }}
                </p>
                <div class="flex flex-wrap gap-3 md:gap-4">
                    <a href="{{ route($localePrefix.'rendez-vous.create') }}"
                        class="px-5 py-2.5 md:px-6 md:py-3 rounded-full bg-primary text-white font-medium hover:bg-primary-light transition-all shadow-md hover:shadow-lg active:scale-95 text-sm md:text-base">
                        {{ $isFr ? 'Prendre rendez-vous' : 'Book an appointment' }}
                    </a>
                    <a href="{{ route($localePrefix.'services.index') }}"
                        class="px-5 py-2.5 md:px-6 md:py-3 rounded-full border border-primary text-primary font-medium hover:bg-white transition-all text-sm md:text-base">
                        {{ $isFr ? 'Découvrir nos services' : 'Explore our services' }}
                    </a>
                </div>
            </div>

            {{-- Bloc visuel --}}
            <div class="relative items-center justify-center hidden p-8 md:flex">
                <div class="relative w-full max-w-sm p-8 transition-transform bg-white border shadow-xl border-border rounded-3xl ">
                    <img src="{{ asset('images/logo.png') }}" alt="La Gloire Divine" class="w-full h-auto mx-auto">
                </div>
            </div>
        </div>
    </section>

    {{-- Trust points --}}
    <section class="max-w-6xl px-6 py-20 mx-auto">
        <h2 class="mb-12 text-2xl font-semibold text-center font-display md:text-3xl text-primary-dark">
            {{ $isFr ? 'Pourquoi choisir La Gloire Divine' : 'Why choose La Gloire Divine' }}
        </h2>
        <div class="grid gap-6 md:grid-cols-3">
            @php
            $points = $isFr ? [
            ['icon' => 'clock', 'title' => 'Ouvert 24h/24, 7j/7', 'text' => "Une équipe disponible à toute heure, tous les jours de l'année."],
            ['icon' => 'heart', 'title' => 'Soins humains', 'text' => "Une prise en charge attentive, centrée sur chaque patient."],
            ['icon' => 'user-check', 'title' => 'Personnel qualifié', 'text' => "Une équipe médicale expérimentée et formée aux bonnes pratiques."],
            ] : [
            ['icon' => 'clock', 'title' => 'Open 24/7', 'text' => 'A team available at any time, every day of the year.'],
            ['icon' => 'heart', 'title' => 'Human-centered care', 'text' => 'Attentive care, centered on every patient.'],
            ['icon' => 'user-check', 'title' => 'Qualified staff', 'text' => 'An experienced medical team trained in best practices.'],
            ];
            @endphp
            @foreach ($points as $point)
            <div class="p-6 text-center transition-all duration-200 border shadow-xs bg-surface border-border rounded-2xl hover:shadow-md hover:-translate-y-1">
                <div class="flex items-center justify-center mx-auto mb-4 rounded-2xl w-14 h-14 bg-tint text-primary">
                    @if ($point['icon'] === 'clock')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    @elseif ($point['icon'] === 'heart')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    @endif
                </div>
                <h3 class="mb-2 text-lg font-semibold font-display text-primary-dark">{{ $point['title'] }}</h3>
                <p class="text-sm leading-relaxed text-ink-soft">{{ $point['text'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    {{-- Services preview --}}
    <section class="py-20 bg-tint">
        <div class="max-w-6xl px-6 mx-auto">
            <div class="max-w-xl mx-auto mb-12 text-center">
                <span class="text-xs font-semibold tracking-widest uppercase text-primary">
                    {{ $isFr ? 'Nos services' : 'Our services' }}
                </span>
                <h2 class="mt-2 text-2xl font-semibold font-display md:text-3xl text-primary-dark">
                    {{ $isFr ? 'Des soins pour toute la famille' : 'Care for the whole family' }}
                </h2>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($services as $service)
                <x-service-card :service="$service" />
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <a href="{{ route($localePrefix.'services.index') }}"
                    class="inline-flex items-center gap-1 font-medium transition-colors text-primary hover:text-accent">
                    {{ $isFr ? 'Voir tous les services' : 'See all services' }} <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Section Offre Spéciale / Carte de Fidélité --}}
    @if ($loyaltyOffer->is_active)
    <section class="max-w-6xl px-6 py-20 mx-auto">
        <div class="relative p-8 overflow-hidden text-white shadow-xl bg-gradient-to-br from-primary-dark to-primary rounded-3xl md:p-12">
            {{-- Decorative background glow --}}
            <div class="absolute top-0 right-0 rounded-full pointer-events-none w-96 h-96 bg-emerald-400/10 blur-3xl"></div>

            <div class="relative z-10 grid items-center gap-8 md:grid-cols-3">
                <div class="md:col-span-2">
                    <span class="inline-block text-xs font-semibold tracking-widest uppercase bg-white/10 text-emerald-300 px-3.5 py-1 rounded-full mb-4 border border-white/10">
                        {{ $isFr ? 'Avantage Famille' : 'Family Advantage' }}
                    </span>
                    <h2 class="mb-4 text-2xl font-bold font-display md:text-4xl">
                        {{ $loyaltyOffer->title }}
                    </h2>
                    <p class="mb-6 text-base leading-relaxed text-white/90">
                        {{ $isFr
                                ? ($loyaltyOffer->description_fr ?: 'Prenez soin de vous et de toute votre famille ! Notre carte de fidélité couvre le titulaire, son/sa conjoint(e) ainsi que leurs enfants.')
                                : ($loyaltyOffer->description_en ?: 'Take care of yourself and your entire family! Our loyalty card covers the cardholder, their spouse, and their children.') }}
                    </p>
                    <div class="inline-block p-4 mb-6 border bg-white/10 backdrop-blur-md border-white/20 rounded-2xl">
                        <p class="flex items-center gap-2 text-sm font-medium text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>
                                {{ $isFr
                                        ? "Profitez de {$loyaltyOffer->discount_percent}% de remise sur vos factures à partir de ".number_format($loyaltyOffer->min_amount, 0, ',', ' ').' FCFA.'
                                        : "Get {$loyaltyOffer->discount_percent}% discount on bills over ".number_format($loyaltyOffer->min_amount, 0, '.', ',').' XAF.' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <a href="https://wa.me/237682600401?text=Bonjour,%20j'aimerais%20en%20savoir%20plus%20sur%20la%20carte%20de%20fid%C3%A9lit%C3%A9"
                            target="_blank" rel="noopener"
                            class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white transition-all rounded-full shadow-md bg-emerald-500 hover:bg-emerald-600 hover:shadow-lg active:scale-95">
                            <span>{{ $isFr ? 'Demander ma carte' : 'Request my card' }}</span>
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>

                {{-- Mockup Carte de Fidélité CSS --}}
                <div class="justify-center hidden md:flex">
                    <div class="flex flex-col justify-between w-64 h-40 p-5 transition-transform duration-300 transform border shadow-2xl rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 border-white/20 rotate-3 hover:rotate-0">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-bold tracking-wider uppercase text-white/90">La Gloire Divine</span>
                            <span class="text-xs bg-white/20 px-2 py-0.5 rounded text-white font-mono">VIP</span>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-white/70">Carte Famille</p>
                            <p class="mt-1 text-lg font-bold tracking-widest text-white">•••• •••• {{ $loyaltyOffer->discount_percent }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

</x-layouts.public>