<?php

use App\Models\RendezVous;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.public')] class extends Component
{
    public string $service_id = '';
    public string $date = '';
    public string $time = '';
    public string $notes = '';
    public bool $confirmed = false;

    public function mount(): void
    {
        // Pré-remplissage si on arrive depuis une carte service (?service=slug)
        $slug = request()->query('service');
        if ($slug) {
            $service = Service::active()->where('slug', $slug)->first();
            if ($service) {
                $this->service_id = (string) $service->id;
            }
        }
    }

    public function book(): void
    {
        $validated = $this->validate([
            'service_id' => ['required', 'exists:services,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['nullable', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'date.after_or_equal' => app()->getLocale() === 'fr'
                ? 'La date ne peut pas être dans le passé.'
                : 'The date cannot be in the past.',
        ]);

        RendezVous::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => 'confirme',
        ]);

        // TODO (Phase 8) : confirmation automatique par WhatsApp en plus
        // de l'enregistrement en base (déjà garanti ici).

        $this->reset(['service_id', 'date', 'time', 'notes']);
        $this->confirmed = true;
    }
}; ?>

@php
    $isFr = app()->getLocale() === 'fr';
    $localePrefix = $isFr ? '' : 'en.';
    $services = \App\Models\Service::active()->ordered()->get();
@endphp

<div class="max-w-xl mx-auto px-6 py-16 md:py-24">
    <div class="text-center mb-10">
        <span class="text-xs font-semibold tracking-widest uppercase text-primary">
            {{ $isFr ? 'Rendez-vous' : 'Appointment' }}
        </span>
        <h1 class="font-display text-3xl md:text-4xl font-semibold text-primary-dark mt-2 mb-3">
            {{ $isFr ? 'Prendre rendez-vous' : 'Book an appointment' }}
        </h1>
        <p class="text-ink-soft">
            {{ $isFr
                ? 'Votre rendez-vous est confirmé immédiatement — vous le retrouverez dans votre espace patient.'
                : 'Your appointment is confirmed immediately — you will find it in your patient space.' }}
        </p>
    </div>

    @if ($confirmed)
        <div class="bg-surface border border-primary/30 rounded-2xl p-8 text-center">
            <div class="w-12 h-12 rounded-full bg-tint flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            <h2 class="font-display text-xl font-semibold text-primary-dark mb-2">
                {{ $isFr ? 'Rendez-vous confirmé' : 'Appointment confirmed' }}
            </h2>
            <p class="text-ink-soft mb-6">
                {{ $isFr
                    ? "Votre rendez-vous a bien été enregistré et confirmé. À bientôt chez La Gloire Divine."
                    : 'Your appointment has been recorded and confirmed. See you soon at La Gloire Divine.' }}
            </p>
            <div class="flex justify-center gap-3">
                <a href="{{ route($localePrefix.'rendez-vous.index') }}"
                   class="px-5 py-2.5 rounded-full bg-primary text-white text-sm font-medium hover:bg-primary-light transition-colors">
                    {{ $isFr ? 'Voir mes rendez-vous' : 'View my appointments' }}
                </a>
                <button wire:click="$set('confirmed', false)"
                        class="px-5 py-2.5 rounded-full border border-border text-ink-soft text-sm font-medium hover:bg-tint transition-colors">
                    {{ $isFr ? 'Prendre un autre RDV' : 'Book another' }}
                </button>
            </div>
        </div>
    @else
        <form wire:submit="book" class="bg-surface rounded-2xl border border-border p-6 md:p-8 space-y-5">
            <div>
                <x-input-label for="service_id" :value="$isFr ? 'Service souhaité' : 'Requested service'" />
                <select wire:model="service_id" id="service_id" required
                        class="w-full rounded-lg border border-border bg-surface px-4 py-2.5 text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors">
                    <option value="">{{ $isFr ? 'Choisir un service' : 'Choose a service' }}</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('service_id')" class="mt-1.5" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="date" :value="$isFr ? 'Date souhaitée' : 'Preferred date'" />
                    <x-text-input wire:model="date" id="date" type="date" min="{{ now()->toDateString() }}" required />
                    <x-input-error :messages="$errors->get('date')" class="mt-1.5" />
                </div>
                <div>
                    <x-input-label for="time" :value="$isFr ? 'Heure (optionnel)' : 'Time (optional)'" />
                    <x-text-input wire:model="time" id="time" type="time" />
                    <x-input-error :messages="$errors->get('time')" class="mt-1.5" />
                </div>
            </div>

            <div>
                <x-input-label for="notes" :value="$isFr ? 'Message (optionnel)' : 'Message (optional)'" />
                <textarea wire:model="notes" id="notes" rows="3"
                          placeholder="{{ $isFr ? 'Précisez le motif de votre visite si vous le souhaitez' : "Let us know the reason for your visit if you'd like" }}"
                          class="w-full rounded-lg border border-border bg-surface px-4 py-2.5 text-ink placeholder:text-ink-soft/50 focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors"></textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-1.5" />
            </div>

            <x-primary-button type="submit" class="w-full">
                {{ $isFr ? 'Confirmer le rendez-vous' : 'Confirm appointment' }}
            </x-primary-button>
        </form>
    @endif
</div>
