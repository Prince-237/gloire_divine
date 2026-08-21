@php
    $isFr = app()->getLocale() === 'fr';
    $faqs = $isFr ? [
        ['q' => 'Quels sont vos horaires ?', 'a' => "Le centre est ouvert 24h/24, 7 jours sur 7, y compris les jours fériés."],
        ['q' => 'Dois-je prendre rendez-vous à l\'avance ?', 'a' => "C'est recommandé pour les consultations planifiées (maternité, kinésithérapie, etc.), mais les urgences sont prises en charge à toute heure sans rendez-vous."],
        ['q' => 'Quels moyens de paiement acceptez-vous ?', 'a' => "Nous acceptons Orange Money, MTN Mobile Money, et les espèces. Nous n'acceptons pas les cartes bancaires ni les assurances pour le moment."],
        ['q' => 'Certains examens de laboratoire nécessitent-ils une préparation ?', 'a' => "Oui, certains examens (comme la glycémie à jeun) demandent d'être à jeun. Nous vous informerons de la préparation nécessaire lors de la prise de rendez-vous."],
        ['q' => 'Comment vous contacter en urgence ?', 'a' => "Appelez notre ligne directe au +237 640 170 487, disponible 24h/24, ou écrivez-nous sur WhatsApp au +237 682 600 401."],
        ['q' => 'Dois-je créer un compte pour prendre rendez-vous ?', 'a' => "Oui, un compte patient est nécessaire afin de pouvoir suivre l'historique de vos rendez-vous et vous contacter si besoin."],
    ] : [
        ['q' => 'What are your opening hours?', 'a' => 'The center is open 24/7, including public holidays.'],
        ['q' => 'Do I need to book in advance?', 'a' => "It's recommended for planned consultations (maternity, physiotherapy, etc.), but emergencies are handled at any time without an appointment."],
        ['q' => 'What payment methods do you accept?', 'a' => "We accept Orange Money, MTN Mobile Money, and cash. We currently don't accept bank cards or insurance."],
        ['q' => 'Do some lab tests require preparation?', 'a' => 'Yes, some tests (like fasting blood glucose) require fasting. We will let you know when you book your appointment.'],
        ['q' => 'How can I contact you in an emergency?', 'a' => 'Call our direct line at +237 640 170 487, available 24/7, or message us on WhatsApp at +237 682 600 401.'],
        ['q' => 'Do I need an account to book an appointment?', 'a' => 'Yes, a patient account is required so we can track your appointment history and reach you if needed.'],
    ];
@endphp

<x-layouts.public title="FAQ">
    <div class="max-w-3xl px-6 py-16 mx-auto md:py-24">
        <div class="mb-12 text-center">
            <span class="text-xs font-semibold tracking-widest uppercase text-primary">FAQ</span>
            <h1 class="mt-2 text-3xl font-semibold font-display md:text-4xl text-primary-dark">
                {{ $isFr ? 'Questions fréquentes' : 'Frequently asked questions' }}
            </h1>
        </div>

        <div class="space-y-3">
            @foreach ($faqs as $i => $faq)
                <div class="overflow-hidden border bg-surface rounded-2xl border-border" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center justify-between w-full gap-4 px-5 py-4 text-left">
                        <span class="font-medium text-ink">{{ $faq['q'] }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform text-primary shrink-0" :class="open && 'rotate-45'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition style="display: none;" class="px-5 pb-4">
                        <p class="text-sm leading-relaxed text-ink-soft">{{ $faq['a'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.public>
