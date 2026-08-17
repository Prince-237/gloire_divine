<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.admin')] class extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';

    // Formulaire de création d'un compte admin
    public bool $showCreateForm = false;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function createAdmin(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{9}$/', 'unique:users,phone'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->max(64)],
        ], [
            'phone.regex' => 'Le numéro de téléphone doit contenir exactement 9 chiffres.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        $this->reset(['name', 'email', 'phone', 'password', 'password_confirmation', 'showCreateForm']);
        session()->flash('status', 'Compte administrateur créé avec succès.');
    }

    public function toggleRole(int $userId): void
    {
        $user = User::findOrFail($userId);

        // Un admin ne peut pas se rétrograder lui-même (évite de se
        // retrouver bloqué hors du dashboard par erreur).
        if ($user->id === Auth::id()) {
            session()->flash('error', 'Vous ne pouvez pas modifier votre propre rôle.');
            return;
        }

        $user->update(['role' => $user->isAdmin() ? 'patient' : 'admin']);
    }

    public function with(): array
    {
        $users = User::query()
            ->when($this->search, fn ($q) => $q->where(fn ($q2) => $q2
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhere('phone', 'like', "%{$this->search}%")
            ))
            ->when($this->roleFilter, fn ($q) => $q->where('role', $this->roleFilter))
            ->orderByDesc('created_at')
            ->paginate(15);

        return ['users' => $users];
    }
}; ?>

<div>
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="font-display text-2xl font-semibold text-primary-dark">Utilisateurs</h1>
            <p class="text-ink-soft text-sm mt-1">Patients et membres de l'équipe administrative.</p>
        </div>
        <button wire:click="$toggle('showCreateForm')"
                class="px-4 py-2.5 rounded-full bg-primary text-white text-sm font-medium hover:bg-primary-light transition-colors">
            {{ $showCreateForm ? 'Annuler' : '+ Nouveau compte admin' }}
        </button>
    </div>

    @if (session('status'))
        <div class="bg-primary/10 text-primary text-sm rounded-xl px-4 py-3 mb-5">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 text-red-600 text-sm rounded-xl px-4 py-3 mb-5">{{ session('error') }}</div>
    @endif

    @if ($showCreateForm)
        <form wire:submit="createAdmin" class="bg-surface rounded-2xl border border-border p-6 mb-6 space-y-4">
            <h2 class="font-display text-base font-semibold text-primary-dark">Créer un compte administrateur</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="name" value="Nom complet" />
                    <x-text-input wire:model="name" id="name" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                </div>
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="email" id="email" type="email" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="phone" value="Téléphone" />
                    <x-text-input wire:model="phone" id="phone" type="tel" inputmode="numeric" maxlength="9"
                                  x-on:input="$el.value = $el.value.replace(/\D/g,'').slice(0,9)" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="password" value="Mot de passe" />
                    <x-text-input wire:model="password" id="password" type="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>
                <div>
                    <x-input-label for="password_confirmation" value="Confirmer" />
                    <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password" required />
                </div>
            </div>
            <x-primary-button type="submit">Créer le compte</x-primary-button>
        </form>
    @endif

    <div class="flex flex-wrap gap-3 mb-4">
        <input wire:model.live.debounce.300ms="search" type="search" placeholder="Rechercher (nom, email, téléphone)…"
               class="flex-1 min-w-[200px] rounded-lg border border-border bg-surface px-4 py-2 text-sm text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none" />
        <select wire:model.live="roleFilter" class="rounded-lg border border-border bg-surface px-4 py-2 text-sm text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none">
            <option value="">Tous les rôles</option>
            <option value="patient">Patients</option>
            <option value="admin">Admins</option>
        </select>
    </div>

    <div class="bg-surface rounded-2xl border border-border overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-border bg-tint text-left text-ink-soft">
                    <th class="px-5 py-3 font-medium">Utilisateur</th>
                    <th class="px-5 py-3 font-medium hidden md:table-cell">Téléphone</th>
                    <th class="px-5 py-3 font-medium">Rôle</th>
                    <th class="px-5 py-3 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b border-border last:border-0">
                        <td class="px-5 py-3">
                            <p class="font-medium text-ink">{{ $user->name }}</p>
                            <p class="text-xs text-ink-soft">{{ $user->email }}</p>
                        </td>
                        <td class="px-5 py-3 hidden md:table-cell text-ink-soft">{{ $user->phone ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-semibold rounded-full px-2.5 py-1 {{ $user->isAdmin() ? 'bg-primary/10 text-primary' : 'bg-tint text-ink-soft' }}">
                                {{ $user->isAdmin() ? 'Admin' : 'Patient' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            @if ($user->id !== auth()->id())
                                <button wire:click="toggleRole({{ $user->id }})"
                                        wire:confirm="{{ $user->isAdmin() ? 'Rétrograder ce compte en patient ?' : 'Promouvoir ce compte en administrateur ?' }}"
                                        class="text-xs font-medium text-primary hover:text-accent underline">
                                    {{ $user->isAdmin() ? 'Rétrograder' : 'Promouvoir admin' }}
                                </button>
                            @else
                                <span class="text-xs text-ink-soft/60">Vous</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-ink-soft">Aucun utilisateur trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
