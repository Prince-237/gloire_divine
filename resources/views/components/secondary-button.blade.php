<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 rounded-full border border-border text-ink-soft text-sm font-medium hover:bg-tint transition-colors disabled:opacity-60']) }}>
    {{ $slot }}
</button>
