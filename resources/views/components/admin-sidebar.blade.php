@php
    $links = [
        ['route' => 'admin.dashboard', 'label' => 'Tableau de bord', 'icon' => 'activity'],
        ['route' => 'admin.users.index', 'label' => 'Utilisateurs', 'icon' => 'baby'],
        ['route' => 'admin.services.index', 'label' => 'Services', 'icon' => 'stethoscope'],
        ['route' => 'admin.rendez-vous.index', 'label' => 'Rendez-vous', 'icon' => 'heart'],
        ['route' => 'admin.messages.index', 'label' => 'Messages', 'icon' => 'flask'],
        ['route' => 'admin.loyalty.edit', 'label' => 'Offre fidélité', 'icon' => 'scissors'],
    ];
@endphp

<aside x-data="{ mobileOpen: false }" class="lg:w-64 shrink-0">
    <div class="lg:hidden flex items-center justify-between px-4 h-16 border-b border-white/10 bg-primary-dark">
        <span class="text-white font-display font-semibold">La Gloire Divine — Admin</span>
        <button @click="mobileOpen = !mobileOpen" class="text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </div>

    <nav :class="mobileOpen ? 'block' : 'hidden'" class="lg:block bg-primary-dark lg:min-h-screen lg:sticky lg:top-0">
        <div class="hidden lg:flex items-center gap-2 px-5 h-16 border-b border-white/10">
            <img src="{{ asset('images/logo.png') }}" alt="" class="w-8 h-8 rounded-full">
            <span class="text-white font-display font-semibold">Admin</span>
        </div>

        <div class="px-3 py-5 space-y-1">
            @foreach ($links as $link)
                <a href="{{ route($link['route']) }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs($link['route']) || request()->routeIs($link['route'].'.*') ? 'bg-primary text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <x-service-icon :name="$link['icon']" class="w-4.5 h-4.5" />
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="px-3 py-4 border-t border-white/10 mt-auto">
            <div class="px-4 py-2 mb-1">
                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-white/50 truncate">{{ auth()->user()->email }}</p>
            </div>
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-colors">
                {{ 'Voir le site public' }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-colors">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>
</aside>
