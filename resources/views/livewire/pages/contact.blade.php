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
    <div class="max-w-6xl mx-auto px-6 py-16 md:py-24">
        <div class="text-center max-w-xl mx-auto mb-14">
            <span class="text-xs font-semibold tracking-widest uppercase text-primary">Contact</span>
            <h1 class="font-display text-3xl md:text-4xl font-semibold text-primary-dark mt-2 mb-3">
                {{ $isFr ? 'Nous contacter' : 'Get in touch' }}
            </h1>
            <p class="text-ink-soft">
                {{ $isFr ? 'Une question ? Écrivez-nous ou contactez-nous directement.' : 'A question? Write to us or contact us directly.' }}
            </p>
        </div>

        <div class="grid md:grid-cols-5 gap-10">
            {{-- Infos --}}
            <div class="md:col-span-2 space-y-5">
                <div class="flex gap-4">
                    <div class="w-11 h-11 rounded-xl bg-tint flex items-center justify-center shrink-0">
                        <x-service-icon name="heart" class="w-5 h-5 text-primary" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary-dark text-sm mb-0.5">{{ $isFr ? 'Adresse' : 'Address' }}</h3>
                        <p class="text-sm text-ink-soft">Entrée Lycée, derrière le Collège La Perfection, Douala, Cameroun</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-11 h-11 rounded-xl bg-tint flex items-center justify-center shrink-0">
                        <x-service-icon name="activity" class="w-5 h-5 text-primary" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary-dark text-sm mb-0.5">{{ $isFr ? 'Ligne directe' : 'Direct line' }}</h3>
                        <a href="tel:+237640170487" class="text-sm text-ink-soft hover:text-primary">+237 640 170 487</a>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-11 h-11 rounded-xl bg-tint flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 text-primary" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                            <path d="M12.004 2C6.486 2 2 6.486 2 12.004c0 1.998.586 3.86 1.594 5.42L2 22l4.7-1.564A9.96 9.96 0 0012.004 22C17.522 22 22 17.522 22 12.004 22 6.486 17.522 2 12.004 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary-dark text-sm mb-0.5">WhatsApp</h3>
                        <a href="https://wa.me/237682600401" target="_blank" rel="noopener" class="text-sm text-ink-soft hover:text-primary">+237 682 600 401</a>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-11 h-11 rounded-xl bg-tint flex items-center justify-center shrink-0">
                        <x-service-icon name="stethoscope" class="w-5 h-5 text-primary" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary-dark text-sm mb-0.5">{{ $isFr ? 'Horaires' : 'Hours' }}</h3>
                        <p class="text-sm text-ink-soft">{{ $isFr ? 'Ouvert 24h/24, 7j/7' : 'Open 24/7' }}</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-11 h-11 rounded-xl bg-tint flex items-center justify-center shrink-0">
                        <x-service-icon name="flask" class="w-5 h-5 text-primary" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-primary-dark text-sm mb-0.5">{{ $isFr ? 'Paiement' : 'Payment' }}</h3>
                        <p class="text-sm text-ink-soft">Orange Money, MTN MoMo, {{ $isFr ? 'espèces' : 'cash' }}</p>
                    </div>
                </div>
            </div>

            {{-- Formulaire --}}
            <div class="md:col-span-3">
                @if ($sent)
                    <div class="bg-surface border border-primary/30 rounded-2xl p-8 text-center h-full flex flex-col items-center justify-center">
                        <div class="w-12 h-12 rounded-full bg-tint flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <p class="text-ink-soft">
                            {{ $isFr ? 'Votre message a bien été envoyé. Nous vous répondrons rapidement.' : 'Your message has been sent. We will get back to you soon.' }}
                        </p>
                        <button wire:click="$set('sent', false)" class="text-sm text-primary hover:text-accent mt-4 underline">
                            {{ $isFr ? 'Envoyer un autre message' : 'Send another message' }}
                        </button>
                    </div>
                @else
                    <form wire:submit="send" class="bg-surface rounded-2xl border border-border p-6 md:p-8 space-y-5">
                        <div class="grid md:grid-cols-2 gap-5">
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
