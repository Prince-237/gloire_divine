@props(['service'])
@php $localePrefix = app()->getLocale() === 'en' ? 'en.' : ''; @endphp

<div class="group bg-surface rounded-2xl p-6 border border-border hover:border-primary/40 hover:shadow-lg hover:shadow-primary/5 transition-all duration-300 flex flex-col">
    <div class="w-12 h-12 rounded-xl bg-tint flex items-center justify-center mb-4 group-hover:bg-accent-light/40 transition-colors">
        <x-service-icon :name="$service->icon" class="w-6 h-6 text-primary" />
    </div>
    <h3 class="font-display text-lg font-semibold text-primary-dark mb-2">{{ $service->name }}</h3>
    <p class="text-sm text-ink-soft leading-relaxed mb-5 flex-1">{{ $service->description }}</p>
    <a href="{{ route($localePrefix.'rendez-vous.create', ['service' => $service->slug]) }}"
       class="text-sm font-medium text-primary inline-flex items-center gap-1 hover:gap-2 hover:text-accent transition-all w-fit">
        {{ app()->getLocale() === 'fr' ? 'Prendre rendez-vous' : 'Book appointment' }} <span aria-hidden="true">→</span>
    </a>
</div>
