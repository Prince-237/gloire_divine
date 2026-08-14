@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-lg border border-border bg-surface px-4 py-2.5 text-ink placeholder:text-ink-soft/50 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors']) }}>
