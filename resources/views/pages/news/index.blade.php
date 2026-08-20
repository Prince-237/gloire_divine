@php
    $isFr = app()->getLocale() === 'fr';
    $localePrefix = $isFr ? '' : 'en.';
@endphp

<x-layouts.public :title="$isFr ? 'Actualités' : 'News'">
    <div class="max-w-5xl mx-auto px-6 py-16 md:py-24">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-semibold tracking-widest uppercase text-primary">
                {{ $isFr ? 'Actualités' : 'News' }}
            </span>
            <h1 class="font-display text-3xl md:text-4xl font-semibold text-primary-dark mt-2 mb-3">
                {{ $isFr ? 'Les nouvelles de La Gloire Divine' : 'News from La Gloire Divine' }}
            </h1>
        </div>

        @if ($articles->isEmpty())
            <p class="text-center text-ink-soft">
                {{ $isFr ? "Aucune actualité publiée pour le moment." : 'No news published yet.' }}
            </p>
        @else
            <div class="grid sm:grid-cols-2 gap-6">
                @foreach ($articles as $article)
                    <a href="{{ route($localePrefix.'news.show', $article->slug) }}"
                       class="group bg-surface rounded-2xl border border-border overflow-hidden hover:border-primary/40 hover:shadow-lg hover:shadow-primary/5 transition-all duration-300 flex flex-col">
                        @if ($article->image_url)
                            <div class="aspect-video overflow-hidden bg-tint">
                                <img src="{{ $article->image_url }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @endif
                        <div class="p-6 flex-1 flex flex-col">
                            <p class="text-xs text-ink-soft mb-2">
                                {{ optional($article->published_at ?? $article->created_at)->translatedFormat('d M Y') }}
                            </p>
                            <h2 class="font-display text-lg font-semibold text-primary-dark mb-2 group-hover:text-primary transition-colors">
                                {{ $article->title }}
                            </h2>
                            <p class="text-sm text-ink-soft leading-relaxed flex-1">{{ $article->excerpt }}</p>
                            <span class="text-sm font-medium text-primary inline-flex items-center gap-1 mt-4 group-hover:gap-2 transition-all">
                                {{ $isFr ? 'Lire la suite' : 'Read more' }} <span aria-hidden="true">→</span>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">{{ $articles->links() }}</div>
        @endif
    </div>
</x-layouts.public>
