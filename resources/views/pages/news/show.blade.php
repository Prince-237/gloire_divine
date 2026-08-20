@php
    $isFr = app()->getLocale() === 'fr';
    $localePrefix = $isFr ? '' : 'en.';
@endphp

<x-layouts.public :title="$article->title">
    <article class="max-w-3xl mx-auto px-6 py-16 md:py-24">
        <a href="{{ route($localePrefix.'news.index') }}" class="inline-flex items-center gap-1.5 text-sm text-primary hover:text-accent mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            {{ $isFr ? 'Toutes les actualités' : 'All news' }}
        </a>

        @if ($article->image_url)
            <div class="rounded-2xl overflow-hidden border border-border mb-8">
                <img src="{{ $article->image_url }}" alt="" class="w-full">
            </div>
        @endif

        <p class="text-sm text-ink-soft mb-3">
            {{ optional($article->published_at ?? $article->created_at)->translatedFormat('d M Y') }}
        </p>
        <h1 class="font-display text-3xl md:text-4xl font-semibold text-primary-dark mb-8">
            {{ $article->title }}
        </h1>

        <div class="text-ink-soft leading-relaxed whitespace-pre-line text-base">
            {{ $article->content }}
        </div>
    </article>
</x-layouts.public>
