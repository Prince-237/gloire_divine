@php $isFr = app()->getLocale() === 'fr'; @endphp

<div>
    <header class="mb-6">
        <h2 class="font-display text-lg font-semibold text-primary-dark">
            {{ $isFr ? 'Informations personnelles' : 'Personal information' }}
        </h2>
        <p class="text-sm text-ink-soft mt-1">
            {{ $isFr ? 'Modifiez vos informations et votre adresse email.' : 'Update your information and email address.' }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="space-y-5">
        <div>
            <x-input-label for="name" :value="$isFr ? 'Nom complet' : 'Full name'" />
            <x-text-input wire:model="name" id="name" type="text" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input wire:model="email" id="email" type="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="sex" :value="$isFr ? 'Sexe' : 'Sex'" />
                <select wire:model="sex" id="sex" required
                        class="w-full rounded-lg border border-border bg-surface px-4 py-2.5 text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors">
                    <option value="M">{{ $isFr ? 'Homme' : 'Male' }}</option>
                    <option value="F">{{ $isFr ? 'Femme' : 'Female' }}</option>
                </select>
                <x-input-error :messages="$errors->get('sex')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="date_of_birth" :value="$isFr ? 'Date de naissance' : 'Date of birth'" />
                <x-text-input wire:model="date_of_birth" id="date_of_birth" type="date" required />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1.5" />
            </div>
        </div>

        <div>
            <x-input-label for="phone" :value="$isFr ? 'Téléphone' : 'Phone'" />
            <x-text-input wire:model="phone" id="phone" type="tel" inputmode="numeric" maxlength="9"
                          x-on:input="$el.value = $el.value.replace(/\D/g,'').slice(0,9)" />
            <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button type="submit">{{ $isFr ? 'Enregistrer' : 'Save' }}</x-primary-button>

            <x-action-message on="profile-updated">
                {{ $isFr ? 'Enregistré.' : 'Saved.' }}
            </x-action-message>
        </div>
    </form>
</div>
