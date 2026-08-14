<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 rounded-full bg-primary text-white text-sm font-medium hover:bg-primary-light transition-colors disabled:opacity-60']) }}>
    {{ $slot }}
</button>
