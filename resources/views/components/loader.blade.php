@props(['storageKey' => 'lgd_site_loaded'])

<div
    x-data="{ loading: ! sessionStorage.getItem('{{ $storageKey }}') }"
    x-init="
        if (loading) {
            setTimeout(() => {
                loading = false;
                sessionStorage.setItem('{{ $storageKey }}', '1');
            }, 3000);
        }
    "
    x-show="loading"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[100] flex flex-col items-center justify-center gap-6 bg-gray-100"
>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-14 h-14 text-primary" fill="currentColor">
        <path d="M10 2a1 1 0 00-1 1v6H3a1 1 0 00-1 1v4a1 1 0 001 1h6v6a1 1 0 001 1h4a1 1 0 001-1v-6h6a1 1 0 001-1v-4a1 1 0 00-1-1h-6V3a1 1 0 00-1-1h-4z" />
    </svg>
    <div class="w-8 h-8 border-2 rounded-full border-primary/20 border-t-primary animate-spin"></div>
</div>
