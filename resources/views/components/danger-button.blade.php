<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 rounded-full bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition-colors disabled:opacity-60']) }}>
    {{ $slot }}
</button>
