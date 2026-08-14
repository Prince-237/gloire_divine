<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => app()->getLocale() === 'fr'
                    ? 'Les identifiants fournis sont incorrects.'
                    : trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        session()->regenerate();

        $this->redirect(route('home'), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new \Illuminate\Auth\Events\Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
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
            {{ app()->getLocale() === 'fr' ? 'Connexion' : 'Log in' }}
        </h1>
        <p class="mt-1 text-sm text-ink-soft">
            {{ app()->getLocale() === 'fr'
                ? 'Accédez à votre espace patient.'
                : 'Access your patient space.' }}
        </p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="px-3 py-2 mb-4 text-sm rounded-lg text-primary bg-tint">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="login" class="space-y-4">
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input wire:model="email" id="email" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password" :value="app()->getLocale() === 'fr' ? 'Mot de passe' : 'Password'" />
            <x-text-input wire:model="password" id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-ink-soft">
                <x-checkbox wire:model="remember" name="remember" />
                {{ app()->getLocale() === 'fr' ? 'Se souvenir de moi' : 'Remember me' }}
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm underline text-primary hover:text-primary-light" href="{{ route('password.request') }}" wire:navigate>
                    {{ app()->getLocale() === 'fr' ? 'Mot de passe oublié ?' : 'Forgot your password?' }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm underline text-primary hover:text-primary-light" href="{{ route('register') }}" wire:navigate>
                {{ app()->getLocale() === 'fr' ? 'Créer un compte' : 'Create an account' }}
            </a>

            <x-primary-button>
                {{ app()->getLocale() === 'fr' ? 'Se connecter' : 'Log in' }}
            </x-primary-button>
        </div>
    </form>
</div>
