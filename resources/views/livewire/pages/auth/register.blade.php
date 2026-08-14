<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $sex = '';
    public string $date_of_birth = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'regex:/^[0-9]{9}$/', 'unique:'.User::class],
            'sex' => ['required', Rule::in(['M', 'F'])],
            'date_of_birth' => ['required', 'date', 'before:today'],
            // Min ET max pour éviter les abus (hachage de mots de passe
            // anormalement longs, attaque par déni de service applicatif).
            'password' => ['required', 'string', 'confirmed', Password::min(8)->max(64)],
        ], [
            'phone.regex' => app()->getLocale() === 'fr'
                ? 'Le numéro de téléphone doit contenir exactement 9 chiffres.'
                : 'The phone number must contain exactly 9 digits.',
            'phone.unique' => app()->getLocale() === 'fr'
                ? 'Ce numéro de téléphone est déjà associé à un compte.'
                : 'This phone number is already linked to an account.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        // Consentement WhatsApp activé par défaut (voir migration
        // set_whatsapp_opt_in_default_true) — plus de case à cocher.

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('home'), navigate: true);
    }
}; ?>

<div>
    {{-- Bouton/Lien de retour à l'accueil --}}
    <div class="mb-4">
        <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-1.5 text-xs font-medium text-ink-soft hover:text-primary transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Retour à l\'accueil' : 'Back to home' }}</span>
        </a>
    </div>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-semibold font-display text-primary-dark">
            {{ app()->getLocale() === 'fr' ? 'Créer un compte patient' : 'Create a patient account' }}
        </h1>
        <p class="mt-1 text-sm text-ink-soft">
            {{ app()->getLocale() === 'fr'
                ? 'Pour prendre rendez-vous et suivre votre historique.'
                : 'To book appointments and track your history.' }}
        </p>
    </div>

    <form wire:submit="register" class="space-y-4">
        <div>
            <x-input-label for="name" :value="app()->getLocale() === 'fr' ? 'Nom complet' : 'Full name'" />
            <x-text-input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input wire:model="email" id="email" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="sex" :value="app()->getLocale() === 'fr' ? 'Sexe' : 'Sex'" />
                <select wire:model="sex" id="sex" required
                        class="w-full rounded-lg border border-border bg-surface px-4 py-2.5 text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-colors">
                    <option value="">—</option>
                    <option value="M">{{ app()->getLocale() === 'fr' ? 'Homme' : 'Male' }}</option>
                    <option value="F">{{ app()->getLocale() === 'fr' ? 'Femme' : 'Female' }}</option>
                </select>
                <x-input-error :messages="$errors->get('sex')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="date_of_birth" :value="app()->getLocale() === 'fr' ? 'Date de naissance' : 'Date of birth'" />
                <x-text-input wire:model="date_of_birth" id="date_of_birth" type="date" name="date_of_birth" required />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1.5" />
            </div>
        </div>

        <div>
            <x-input-label for="phone" :value="app()->getLocale() === 'fr' ? 'Téléphone' : 'Phone'" />
            <x-text-input wire:model="phone" id="phone" type="tel" inputmode="numeric" maxlength="9"
                          name="phone" required placeholder="6XXXXXXXX"
                          x-on:input="$el.value = $el.value.replace(/\D/g,'').slice(0,9)" />
            <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" :value="app()->getLocale() === 'fr' ? 'Mot de passe' : 'Password'" />
                <x-text-input wire:model="password" id="password" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="password_confirmation" :value="app()->getLocale() === 'fr' ? 'Confirmer' : 'Confirm'" />
                <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password"
                              name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
            </div>
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm underline text-primary hover:text-primary-light" href="{{ route('login') }}" wire:navigate>
                {{ app()->getLocale() === 'fr' ? 'Déjà inscrit ?' : 'Already registered?' }}
            </a>

            <x-primary-button>
                {{ app()->getLocale() === 'fr' ? "S'inscrire" : 'Register' }}
            </x-primary-button>
        </div>
    </form>
</div>
