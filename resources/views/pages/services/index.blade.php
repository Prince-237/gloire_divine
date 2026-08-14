@php $isFr = app()->getLocale() === 'fr'; @endphp

<x-layouts.public title="Services">
    <div class="max-w-6xl mx-auto px-6 py-16 md:py-24">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-semibold tracking-widest uppercase text-primary">
                {{ $isFr ? 'Nos services' : 'Our services' }}
            </span>
            <h1 class="font-display text-3xl md:text-4xl font-semibold text-primary-dark mt-2 mb-3">
                {{ $isFr ? 'Des soins pour toute la famille' : 'Care for the whole family' }}
            </h1>
            <p class="text-ink-soft">
                {{ $isFr
                    ? 'Découvrez les services proposés par notre centre. Pour toute question, contactez-nous directement.'
                    : 'Discover the services offered at our center. For any question, contact us directly.' }}
            </p>
        </div>

        @if ($services->isEmpty())
            <p class="text-center text-ink-soft">
                {{ $isFr ? 'Aucun service disponible pour le moment.' : 'No services available at the moment.' }}
            </p>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($services as $service)
                    <x-service-card :service="$service" />
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.public>
