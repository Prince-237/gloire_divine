@props(['on'])

<div x-data="{ shown: false, timeout: null }"
     x-on:{{ $on }}.window="
        shown = true;
        clearTimeout(timeout);
        timeout = setTimeout(() => { shown = false }, 2000);
     "
     x-show.transition.out.opacity.duration.1500ms="shown"
     style="display: none;"
     {{ $attributes->merge(['class' => 'text-sm text-primary font-medium']) }}
>
    {{ $slot }}
</div>
