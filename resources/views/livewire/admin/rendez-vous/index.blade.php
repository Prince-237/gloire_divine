<?php

use App\Models\RendezVous;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.admin')] class extends Component
{
    use WithPagination;

    public string $filter = 'a_venir'; // a_venir | tous | annules
    public ?int $confirmingDeleteId = null;

    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    public function cancel(int $id): void
    {
        RendezVous::findOrFail($id)->update(['status' => 'annule']);
        session()->flash('status', 'Rendez-vous annulé.');
    }

    public function restore(int $id): void
    {
        RendezVous::findOrFail($id)->update(['status' => 'confirme']);
        session()->flash('status', 'Rendez-vous réactivé.');
    }

    public function delete(int $id): void
    {
        RendezVous::findOrFail($id)->delete();
        $this->confirmingDeleteId = null;
        session()->flash('status', 'Rendez-vous supprimé.');
    }

    public function with(): array
    {
        $query = RendezVous::with(['user', 'service']);

        match ($this->filter) {
            'a_venir' => $query->where('status', 'confirme')->where('date', '>=', now()->toDateString())->orderBy('date')->orderBy('time'),
            'annules' => $query->where('status', 'annule')->orderByDesc('date'),
            default => $query->orderByDesc('date'),
        };

        return ['rendezVous' => $query->paginate(15)];
    }
}; ?>

@php
    $statusStyles = ['confirme' => 'bg-primary/10 text-primary', 'annule' => 'bg-red-50 text-red-600'];
    $statusLabels = ['confirme' => 'Confirmé', 'annule' => 'Annulé'];
@endphp

<div>
    <h1 class="font-display text-2xl font-semibold text-primary-dark mb-1">Rendez-vous</h1>
    <p class="text-ink-soft text-sm mb-6">Consultez et gérez les rendez-vous pris sur le site.</p>

    @if (session('status'))
        <div class="bg-primary/10 text-primary text-sm rounded-xl px-4 py-3 mb-5">{{ session('status') }}</div>
    @endif

    <div class="flex flex-wrap gap-2 mb-5">
        <button wire:click="$set('filter', 'a_venir')" class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ $filter === 'a_venir' ? 'bg-primary text-white' : 'bg-surface border border-border text-ink-soft hover:bg-tint' }}">
            À venir
        </button>
        <button wire:click="$set('filter', 'tous')" class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ $filter === 'tous' ? 'bg-primary text-white' : 'bg-surface border border-border text-ink-soft hover:bg-tint' }}">
            Tous
        </button>
        <button wire:click="$set('filter', 'annules')" class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ $filter === 'annules' ? 'bg-primary text-white' : 'bg-surface border border-border text-ink-soft hover:bg-tint' }}">
            Annulés
        </button>
    </div>

    <div class="space-y-3">
        @forelse ($rendezVous as $rdv)
            <div class="bg-surface rounded-2xl border border-border p-5">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-2">
                    <div>
                        <p class="font-medium text-ink">{{ $rdv->user->name }}</p>
                        <p class="text-sm text-primary">{{ $rdv->service->name_fr }}</p>
                    </div>
                    <span class="text-xs font-semibold rounded-full px-3 py-1 shrink-0 {{ $statusStyles[$rdv->status] }}">
                        {{ $statusLabels[$rdv->status] }}
                    </span>
                </div>

                <div class="grid sm:grid-cols-2 gap-x-6 gap-y-1 text-sm text-ink-soft mb-3">
                    <div><span class="font-medium text-ink">Date :</span> {{ $rdv->date->format('d/m/Y') }}{{ $rdv->time ? ' à '.\Illuminate\Support\Carbon::parse($rdv->time)->format('H:i') : '' }}</div>
                    <div><span class="font-medium text-ink">Téléphone :</span> {{ $rdv->user->phone }}</div>
                    <div class="sm:col-span-2"><span class="font-medium text-ink">Email :</span> {{ $rdv->user->email }}</div>
                    @if ($rdv->notes)
                        <div class="sm:col-span-2"><span class="font-medium text-ink">Notes :</span> {{ $rdv->notes }}</div>
                    @endif
                </div>

                <div class="flex flex-wrap gap-2 pt-2 border-t border-border">
                    @if ($rdv->status === 'confirme')
                        <button wire:click="cancel({{ $rdv->id }})" wire:confirm="Annuler ce rendez-vous ?"
                                class="px-3 py-1.5 rounded-full text-xs font-medium border border-border text-ink-soft hover:bg-tint transition-colors">
                            Annuler
                        </button>
                    @else
                        <button wire:click="restore({{ $rdv->id }})"
                                class="px-3 py-1.5 rounded-full text-xs font-medium bg-primary text-white hover:bg-primary-light transition-colors">
                            Réactiver
                        </button>
                    @endif
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $rdv->user->phone) }}" target="_blank" rel="noopener"
                       class="px-3 py-1.5 rounded-full text-xs font-medium border border-border text-ink-soft hover:bg-tint transition-colors">
                        Contacter (WhatsApp)
                    </a>
                    <button wire:click="$set('confirmingDeleteId', {{ $rdv->id }})"
                            class="px-3 py-1.5 rounded-full text-xs font-medium text-red-600 hover:bg-red-50 transition-colors ml-auto">
                        Supprimer
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-surface rounded-2xl border border-border p-8 text-center text-ink-soft">
                Aucun rendez-vous pour ce filtre.
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $rendezVous->links() }}</div>

    @if ($confirmingDeleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('confirmingDeleteId', null)"></div>
            <div class="relative bg-surface rounded-2xl border border-border p-6 w-full max-w-sm">
                <h2 class="font-display text-lg font-semibold text-primary-dark mb-2">Supprimer ce rendez-vous ?</h2>
                <p class="text-sm text-ink-soft mb-6">Cette action est définitive.</p>
                <div class="flex justify-end gap-3">
                    <button wire:click="$set('confirmingDeleteId', null)" class="px-4 py-2 rounded-full text-sm font-medium text-ink-soft hover:bg-tint transition-colors">Annuler</button>
                    <button wire:click="delete({{ $confirmingDeleteId }})" class="px-4 py-2 rounded-full text-sm font-medium bg-red-600 text-white hover:bg-red-700 transition-colors">Supprimer</button>
                </div>
            </div>
        </div>
    @endif
</div>
