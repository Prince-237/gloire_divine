<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

@php $isFr = app()->getLocale() === 'fr'; @endphp

<section class="space-y-6">
    <header>
        <h2 class="font-display text-lg font-semibold text-primary-dark">
            {{ $isFr ? 'Supprimer le compte' : 'Delete account' }}
        </h2>
        <p class="mt-1 text-sm text-ink-soft">
            {{ $isFr
                ? 'Une fois votre compte supprimé, toutes vos données seront définitivement effacées, y compris votre historique de rendez-vous.'
                : 'Once your account is deleted, all your data will be permanently erased, including your appointment history.' }}
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ $isFr ? 'Supprimer le compte' : 'Delete account' }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">
            <h2 class="font-display text-lg font-semibold text-primary-dark">
                {{ $isFr ? 'Confirmer la suppression du compte' : 'Confirm account deletion' }}
            </h2>
            <p class="mt-1 text-sm text-ink-soft">
                {{ $isFr
                    ? 'Cette action est irréversible. Entrez votre mot de passe pour confirmer.'
                    : 'This action is irreversible. Enter your password to confirm.' }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" :value="$isFr ? 'Mot de passe' : 'Password'" class="sr-only" />
                <x-text-input wire:model="password" id="password" type="password"
                              class="block w-3/4" :placeholder="$isFr ? 'Mot de passe' : 'Password'" />
                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ $isFr ? 'Annuler' : 'Cancel' }}
                </x-secondary-button>
                <x-danger-button>
                    {{ $isFr ? 'Supprimer le compte' : 'Delete account' }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
