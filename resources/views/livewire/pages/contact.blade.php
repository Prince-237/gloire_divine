<?php

use App\Models\Message;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.public')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $subject = '';
    public string $message = '';
    public bool $sent = false;

    public function send(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'regex:/^[0-9]{9}$/'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'phone.regex' => app()->getLocale() === 'fr'
                ? 'Le numéro doit contenir exactement 9 chiffres (ou laissez vide).'
                : 'The number must contain exactly 9 digits (or leave empty).',
        ]);

        Message::create($validated);

        // TODO (Phase 8) : envoi automatique vers le WhatsApp officiel du
        // centre en plus de l'enregistrement en base (déjà garanti ici).

        $this->reset(['name', 'email', 'phone', 'subject', 'message']);
        $this->sent = true;
    }
}; ?>

@php $isFr = app()->getLocale() === 'fr'; @endphp

<div>
    <div class="max-w-6xl px-6 py-16 mx-auto md:py-24">
        <div class="max-w-xl mx-auto text-center mb-14">
            <span class="text-xs font-semibold tracking-widest uppercase text-primary">Contact</span>
            <h1 class="mt-2 mb-3 text-3xl font-semibold font-display md:text-4xl text-primary-dark">
                {{ $isFr ? 'Nous contacter' : 'Get in touch' }}
            </h1>
            <p class="text-ink-soft">
                {{ $isFr ? 'Une question ? Écrivez-nous ou contactez-nous directement.' : 'A question? Write to us or contact us directly.' }}
            </p>
        </div>

        <div class="grid gap-10 md:grid-cols-5">
            {{-- Infos --}}
            <div class="space-y-5 md:col-span-2">
                {{-- Adresse : Icône Localisation --}}
                <div class="flex gap-4">
                    <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-tint shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-5 h-5 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary-dark text-sm mb-0.5">{{ $isFr ? 'Adresse' : 'Address' }}</h3>
                        <p class="text-sm text-ink-soft">Entrée Lycée, derrière le Collège La Perfection, Douala, Cameroun</p>
                    </div>
                </div>

                {{-- Ligne directe : Icône Téléphone --}}
                <div class="flex gap-4">
                    <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-tint shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-5 h-5 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.828-1.015-5.183-3.37-6.198-6.198l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary-dark text-sm mb-0.5">{{ $isFr ? 'Ligne directe' : 'Direct line' }}</h3>
                        <a href="tel:+237640170487" class="text-sm text-ink-soft hover:text-primary">+237 640 170 487</a>
                    </div>
                </div>

                {{-- WhatsApp --}}
                <div class="flex gap-4">
                    <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-tint shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 text-primary" fill="currentColor">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.01c0 2.13.66 4.11 1.79 5.74L2.35 22l4.39-1.39A9.956 9.956 0 0 0 12 22c5.523 0 10-4.484 10-9.99C22 6.484 17.523 2 12 2zm.05 16.5c-1.55 0-3.03-.43-4.32-1.22l-.31-.19-2.61.83.84-2.52-.21-.33a7.94 7.94 0 0 1-1.39-4.56c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8.01-8 8.01zm4.39-5.96c-.24-.12-1.42-.7-1.64-.78-.22-.08-.38-.12-.54.12-.16.24-.62.78-.76.94-.14.16-.28.18-.52.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.43-1.34-1.67-.14-.24-.01-.37.11-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.31-.74-1.8-.2-.48-.4-.41-.54-.42h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2 0 1.18.86 2.32.98 2.48.12.16 1.7 2.6 4.12 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.47-.07 1.42-.58 1.62-1.14.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary-dark text-sm mb-0.5">WhatsApp</h3>
                        <a href="https://wa.me/237682600401" target="_blank" rel="noopener" class="text-sm text-ink-soft hover:text-primary">+237 682 600 401</a>
                    </div>
                </div>

                {{-- Horaires : Icône Horloge / Temps --}}
                <div class="flex gap-4">
                    <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-tint shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-5 h-5 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary-dark text-sm mb-0.5">{{ $isFr ? 'Horaires' : 'Hours' }}</h3>
                        <p class="text-sm text-ink-soft">{{ $isFr ? 'Ouvert 24h/24, 7j/7' : 'Open 24/7' }}</p>
                    </div>
                </div>

                {{-- Paiement : Icône Carte / Mode de paiement --}}
                <div class="flex gap-4">
                    <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-tint shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-5 h-5 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary-dark text-sm mb-0.5">{{ $isFr ? 'Paiement' : 'Payment' }}</h3>
                        <p class="text-sm text-ink-soft">Orange Money, MTN MoMo, {{ $isFr ? 'espèces' : 'cash' }}</p>
                    </div>
                </div>

                <div class="mt-2 overflow-hidden border rounded-2xl border-border">
                    <iframe
                        title="{{ $isFr ? 'Localisation La Gloire Divine' : 'La Gloire Divine location' }}"
                        class="w-full h-56"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q=Coll%C3%A8ge+La+Perfection,+Douala,+Cameroun&output=embed">
                    </iframe>
                </div>
                <p class="-mt-2 text-xs text-ink-soft/80">
                    {{ $isFr
                        ? "Le repère affiché est le Collège La Perfection — le centre se trouve juste derrière."
                        : 'The pin shown is Collège La Perfection — the center is located right behind it.' }}
                </p>
            </div>

            {{-- Formulaire --}}
            <div class="md:col-span-3">
                @if ($sent)
                    <div class="flex flex-col items-center justify-center h-full p-8 text-center border bg-surface border-primary/30 rounded-2xl">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-full bg-tint">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <p class="text-ink-soft">
                            {{ $isFr ? 'Votre message a bien été envoyé. Nous vous répondrons rapidement.' : 'Your message has been sent. We will get back to you soon.' }}
                        </p>
                        <button wire:click="$set('sent', false)" class="mt-4 text-sm underline text-primary hover:text-accent">
                            {{ $isFr ? 'Envoyer un autre message' : 'Send another message' }}
                        </button>
                    </div>
                @else
                    <form wire:submit="send" class="p-6 space-y-5 border bg-surface rounded-2xl border-border md:p-8">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <x-input-label for="name" :value="$isFr ? 'Nom' : 'Name'" />
                                <x-text-input wire:model="name" id="name" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                            </div>
                            <div>
                                <x-input-label for="email" value="Email" />
                                <x-text-input wire:model="email" id="email" type="email" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="phone" :value="($isFr ? 'Téléphone' : 'Phone').' ('.($isFr ? 'optionnel' : 'optional').')'" />
                            <x-text-input wire:model="phone" id="phone" type="tel" inputmode="numeric" maxlength="9"
                                          placeholder="6XXXXXXXX"
                                          x-on:input="$el.value = $el.value.replace(/\D/g,'').slice(0,9)" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
                        </div>

                        <div>
                            <x-input-label for="subject" :value="$isFr ? 'Sujet' : 'Subject'" />
                            <x-text-input wire:model="subject" id="subject" />
                        </div>

                        <div>
                            <x-input-label for="message" :value="$isFr ? 'Message' : 'Message'" />
                            <textarea wire:model="message" id="message" rows="5" required
                                      class="w-full rounded-lg border border-border bg-surface px-4 py-2.5 text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors"></textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-1.5" />
                        </div>

                        <x-primary-button type="submit">
                            {{ $isFr ? 'Envoyer' : 'Send' }}
                        </x-primary-button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>