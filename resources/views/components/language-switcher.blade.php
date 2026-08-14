@php
    use App\Http\Middleware\SetLocale;
@endphp
<div class="flex items-center gap-1 text-sm font-medium">
    <a href="{{ SetLocale::urlForLocale('fr') }}"
       class="px-2 py-1 rounded-full transition-colors {{ app()->getLocale() === 'fr' ? 'bg-primary text-white' : 'text-ink-soft hover:text-primary' }}">
        FR
    </a>
    <a href="{{ SetLocale::urlForLocale('en') }}"
       class="px-2 py-1 rounded-full transition-colors {{ app()->getLocale() === 'en' ? 'bg-primary text-white' : 'text-ink-soft hover:text-primary' }}">
        EN
    </a>
</div>
