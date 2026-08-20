<?php

use App\Models\LoyaltyOffer;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin')] class extends Component
{
    public int $discount_percent = 15;
    public int $min_amount = 5000;
    public string $title_fr = '';
    public string $title_en = '';
    public string $description_fr = '';
    public string $description_en = '';
    public bool $is_active = true;

    public function mount(): void
    {
        $offer = LoyaltyOffer::current();
        $this->discount_percent = $offer->discount_percent;
        $this->min_amount = $offer->min_amount;
        $this->title_fr = $offer->title_fr;
        $this->title_en = $offer->title_en;
        $this->description_fr = $offer->description_fr ?? '';
        $this->description_en = $offer->description_en ?? '';
        $this->is_active = $offer->is_active;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'discount_percent' => ['required', 'integer', 'min:0', 'max:100'],
            'min_amount' => ['required', 'integer', 'min:0'],
            'title_fr' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'description_fr' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        LoyaltyOffer::current()->update($validated);

        session()->flash('status', 'Offre de fidélité mise à jour.');
    }
}; ?>

<div>
    <h1 class="font-display text-2xl font-semibold text-primary-dark mb-1">Offre fidélité</h1>
    <p class="text-ink-soft text-sm mb-6">Ce bloc s'affiche sur la page d'accueil du site public.</p>

    @if (session('status'))
        <div class="bg-primary/10 text-primary text-sm rounded-xl px-4 py-3 mb-5">{{ session('status') }}</div>
    @endif

    <form wire:submit="save" class="bg-surface rounded-2xl border border-border p-6 md:p-8 space-y-5 max-w-2xl">
        <label class="flex items-center gap-2 text-sm text-ink">
            <x-checkbox wire:model="is_active" />
            Afficher cette offre sur le site
        </label>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="discount_percent" value="Pourcentage de remise" />
                <x-text-input wire:model="discount_percent" id="discount_percent" type="number" min="0" max="100" />
                <x-input-error :messages="$errors->get('discount_percent')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="min_amount" value="Montant minimum (FCFA)" />
                <x-text-input wire:model="min_amount" id="min_amount" type="number" min="0" />
                <x-input-error :messages="$errors->get('min_amount')" class="mt-1.5" />
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="title_fr" value="Titre (français)" />
                <x-text-input wire:model="title_fr" id="title_fr" />
                <x-input-error :messages="$errors->get('title_fr')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="title_en" value="Titre (anglais)" />
                <x-text-input wire:model="title_en" id="title_en" />
                <x-input-error :messages="$errors->get('title_en')" class="mt-1.5" />
            </div>
        </div>

        <div>
            <x-input-label for="description_fr" value="Description (français)" />
            <textarea wire:model="description_fr" id="description_fr" rows="3"
                      class="w-full rounded-lg border border-border bg-surface px-3.5 py-2 text-sm text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"></textarea>
        </div>
        <div>
            <x-input-label for="description_en" value="Description (anglais)" />
            <textarea wire:model="description_en" id="description_en" rows="3"
                      class="w-full rounded-lg border border-border bg-surface px-3.5 py-2 text-sm text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"></textarea>
        </div>

        <x-primary-button type="submit">Enregistrer</x-primary-button>
    </form>
</div>
