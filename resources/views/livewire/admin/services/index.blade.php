<?php

use App\Models\Service;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin')] class extends Component
{
    public bool $showModal = false;
    public ?int $editingId = null;
    public bool $slugTouched = false;

    public string $slug = '';
    public string $name_fr = '';
    public string $name_en = '';
    public string $description_fr = '';
    public string $description_en = '';
    public string $icon = 'stethoscope';
    public int $order = 0;
    public bool $is_active = true;

    public ?int $confirmingDeleteId = null;

    public function updatedNameFr(string $value): void
    {
        if (! $this->slugTouched) {
            $this->slug = Str::slug($value);
        }
    }

    public function updatedSlug(): void
    {
        $this->slugTouched = true;
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'slug', 'name_fr', 'name_en', 'description_fr', 'description_en', 'order', 'slugTouched']);
        $this->icon = 'stethoscope';
        $this->is_active = true;
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $service = Service::findOrFail($id);
        $this->editingId = $service->id;
        $this->slug = $service->slug;
        $this->name_fr = $service->name_fr;
        $this->name_en = $service->name_en;
        $this->description_fr = $service->description_fr;
        $this->description_en = $service->description_en;
        $this->icon = $service->icon;
        $this->order = $service->order;
        $this->is_active = $service->is_active;
        $this->slugTouched = true;
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'slug' => ['required', 'string', 'max:150', 'unique:services,slug,'.$this->editingId],
            'name_fr' => ['required', 'string', 'max:150'],
            'name_en' => ['required', 'string', 'max:150'],
            'description_fr' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        Service::updateOrCreate(['id' => $this->editingId], $validated);

        $this->showModal = false;
        session()->flash('status', $this->editingId ? 'Service mis à jour.' : 'Service créé.');
    }

    public function delete(int $id): void
    {
        Service::findOrFail($id)->delete();
        $this->confirmingDeleteId = null;
        session()->flash('status', 'Service supprimé.');
    }

    public function with(): array
    {
        return ['services' => Service::orderBy('order')->orderBy('name_fr')->get()];
    }
}; ?>

@php
    $icons = ['stethoscope', 'heart', 'activity', 'flask', 'scissors', 'baby'];
@endphp

<div>
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="font-display text-2xl font-semibold text-primary-dark">Services</h1>
            <p class="text-ink-soft text-sm mt-1">Gérez les services affichés sur le site public.</p>
        </div>
        <button wire:click="openCreate" class="px-4 py-2.5 rounded-full bg-primary text-white text-sm font-medium hover:bg-primary-light transition-colors">
            + Nouveau service
        </button>
    </div>

    @if (session('status'))
        <div class="bg-primary/10 text-primary text-sm rounded-xl px-4 py-3 mb-5">{{ session('status') }}</div>
    @endif

    <div class="bg-surface rounded-2xl border border-border overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-border bg-tint text-left text-ink-soft">
                    <th class="px-5 py-3 font-medium">Service</th>
                    <th class="px-5 py-3 font-medium hidden md:table-cell">Ordre</th>
                    <th class="px-5 py-3 font-medium hidden sm:table-cell">Statut</th>
                    <th class="px-5 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr class="border-b border-border last:border-0">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-tint flex items-center justify-center shrink-0">
                                    <x-service-icon :name="$service->icon" class="w-4 h-4 text-primary" />
                                </div>
                                <div>
                                    <p class="font-medium text-ink">{{ $service->name_fr }}</p>
                                    <p class="text-xs text-ink-soft">{{ $service->name_en }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 hidden md:table-cell text-ink-soft">{{ $service->order }}</td>
                        <td class="px-5 py-3 hidden sm:table-cell">
                            <span class="text-xs font-semibold rounded-full px-2.5 py-1 {{ $service->is_active ? 'bg-primary/10 text-primary' : 'bg-ink-soft/10 text-ink-soft' }}">
                                {{ $service->is_active ? 'Actif' : 'Désactivé' }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-1">
                                <button wire:click="openEdit({{ $service->id }})" class="p-2 rounded-lg text-ink-soft hover:bg-tint hover:text-primary transition-colors" aria-label="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                    </svg>
                                </button>
                                <button wire:click="$set('confirmingDeleteId', {{ $service->id }})" class="p-2 rounded-lg text-ink-soft hover:bg-red-50 hover:text-red-600 transition-colors" aria-label="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-ink-soft">Aucun service pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal création/édition --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('showModal', false)"></div>
            <div class="relative bg-surface rounded-2xl border border-border w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-border sticky top-0 bg-surface">
                    <h2 class="font-display text-lg font-semibold text-primary-dark">
                        {{ $editingId ? 'Modifier le service' : 'Nouveau service' }}
                    </h2>
                    <button wire:click="$set('showModal', false)" class="text-ink-soft hover:text-ink">✕</button>
                </div>

                <form wire:submit="save" class="p-6 space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="name_fr" value="Nom (français)" />
                            <x-text-input wire:model.live="name_fr" id="name_fr" />
                            <x-input-error :messages="$errors->get('name_fr')" class="mt-1.5" />
                        </div>
                        <div>
                            <x-input-label for="name_en" value="Nom (anglais)" />
                            <x-text-input wire:model="name_en" id="name_en" />
                            <x-input-error :messages="$errors->get('name_en')" class="mt-1.5" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="slug" value="Identifiant URL (slug)" />
                        <x-text-input wire:model="slug" id="slug" />
                        <x-input-error :messages="$errors->get('slug')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="description_fr" value="Description (français)" />
                        <textarea wire:model="description_fr" id="description_fr" rows="3"
                                  class="w-full rounded-lg border border-border bg-surface px-3.5 py-2 text-sm text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"></textarea>
                        <x-input-error :messages="$errors->get('description_fr')" class="mt-1.5" />
                    </div>
                    <div>
                        <x-input-label for="description_en" value="Description (anglais)" />
                        <textarea wire:model="description_en" id="description_en" rows="3"
                                  class="w-full rounded-lg border border-border bg-surface px-3.5 py-2 text-sm text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"></textarea>
                        <x-input-error :messages="$errors->get('description_en')" class="mt-1.5" />
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Icône" />
                            <div class="grid grid-cols-6 gap-2">
                                @foreach ($icons as $iconName)
                                    <button type="button" wire:click="$set('icon', '{{ $iconName }}')"
                                            class="aspect-square rounded-lg flex items-center justify-center border transition-colors {{ $icon === $iconName ? 'bg-primary border-primary text-white' : 'border-border text-ink-soft hover:bg-tint' }}">
                                        <x-service-icon :name="$iconName" class="w-4 h-4" />
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <x-input-label for="order" value="Ordre d'affichage" />
                            <x-text-input wire:model="order" id="order" type="number" min="0" />
                            <label class="flex items-center gap-2 mt-4 text-sm text-ink">
                                <x-checkbox wire:model="is_active" />
                                Service actif (visible sur le site)
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 rounded-full text-sm font-medium text-ink-soft hover:bg-tint transition-colors">
                            Annuler
                        </button>
                        <x-primary-button type="submit">Enregistrer</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Confirmation suppression --}}
    @if ($confirmingDeleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('confirmingDeleteId', null)"></div>
            <div class="relative bg-surface rounded-2xl border border-border p-6 w-full max-w-sm">
                <h2 class="font-display text-lg font-semibold text-primary-dark mb-2">Supprimer ce service ?</h2>
                <p class="text-sm text-ink-soft mb-6">Il ne sera plus visible sur le site public.</p>
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('confirmingDeleteId', null)" class="px-4 py-2 rounded-full text-sm font-medium text-ink-soft hover:bg-tint transition-colors">
                        Annuler
                    </button>
                    <button wire:click="delete({{ $confirmingDeleteId }})" class="px-4 py-2 rounded-full text-sm font-medium bg-red-600 text-white hover:bg-red-700 transition-colors">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
