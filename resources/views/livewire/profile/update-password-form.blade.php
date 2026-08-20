<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                // Min ET max, cohérent avec l'inscription (Phase 1).
                'password' => ['required', 'string', Password::min(8)->max(64), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

@php $isFr = app()->getLocale() === 'fr'; @endphp

<section>
    <header>
        <h2 class="font-display text-lg font-semibold text-primary-dark">
            {{ $isFr ? 'Modifier le mot de passe' : 'Update password' }}
        </h2>
        <p class="mt-1 text-sm text-ink-soft">
            {{ $isFr
                ? 'Utilisez un mot de passe long et unique pour rester en sécurité.'
                : 'Use a long, unique password to stay secure.' }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-5">
        <div>
            <x-input-label for="update_password_current_password" :value="$isFr ? 'Mot de passe actuel' : 'Current password'" />
            <x-text-input wire:model="current_password" id="update_password_current_password" type="password" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="$isFr ? 'Nouveau mot de passe' : 'New password'" />
            <x-text-input wire:model="password" id="update_password_password" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="$isFr ? 'Confirmer' : 'Confirm'" />
            <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ $isFr ? 'Enregistrer' : 'Save' }}</x-primary-button>

            <x-action-message on="password-updated">
                {{ $isFr ? 'Enregistré.' : 'Saved.' }}
            </x-action-message>
        </div>
    </form>
</section>
