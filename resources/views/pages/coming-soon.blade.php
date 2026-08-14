<x-layouts.public :title="$title ?? ''">
    <div class="max-w-3xl mx-auto px-6 py-24 text-center">
        <h1 class="font-display text-2xl font-semibold text-primary-dark mb-3">{{ $title ?? '' }}</h1>
        <p class="text-ink-soft">
            {{ app()->getLocale() === 'fr' ? 'Cette page sera construite dans une prochaine phase.' : 'This page will be built in an upcoming phase.' }}
        </p>
    </div>
</x-layouts.public>
