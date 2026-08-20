<?php

use App\Models\Message;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.admin')] class extends Component
{
    use WithPagination;

    public bool $unreadOnly = false;
    public ?int $confirmingDeleteId = null;

    public function markAsRead(int $id): void
    {
        $message = Message::findOrFail($id);
        if (! $message->read_at) {
            $message->update(['read_at' => now()]);
        }
    }

    public function delete(int $id): void
    {
        Message::findOrFail($id)->delete();
        $this->confirmingDeleteId = null;
        session()->flash('status', 'Message supprimé.');
    }

    public function with(): array
    {
        $query = Message::query()->latest();

        if ($this->unreadOnly) {
            $query->whereNull('read_at');
        }

        return [
            'messages' => $query->paginate(15),
            'unreadCount' => Message::whereNull('read_at')->count(),
        ];
    }
}; ?>

<div>
    <h1 class="font-display text-2xl font-semibold text-primary-dark mb-1">Messages</h1>
    <p class="text-ink-soft text-sm mb-6">Messages reçus via le formulaire de contact du site.</p>

    @if (session('status'))
        <div class="bg-primary/10 text-primary text-sm rounded-xl px-4 py-3 mb-5">{{ session('status') }}</div>
    @endif

    <div class="flex flex-wrap gap-2 mb-5">
        <button wire:click="$set('unreadOnly', false)" class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ ! $unreadOnly ? 'bg-primary text-white' : 'bg-surface border border-border text-ink-soft hover:bg-tint' }}">
            Tous
        </button>
        <button wire:click="$set('unreadOnly', true)" class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ $unreadOnly ? 'bg-primary text-white' : 'bg-surface border border-border text-ink-soft hover:bg-tint' }}">
            Non lus ({{ $unreadCount }})
        </button>
    </div>

    <div class="space-y-3">
        @forelse ($messages as $message)
            <div class="bg-surface rounded-2xl border {{ $message->read_at ? 'border-border' : 'border-primary/40 bg-primary/[0.02]' }} p-5">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-2">
                    <div class="flex items-center gap-2">
                        @if (! $message->read_at)
                            <span class="w-2 h-2 rounded-full bg-primary shrink-0"></span>
                        @endif
                        <div>
                            <p class="font-medium text-ink">{{ $message->name }}</p>
                            <p class="text-sm text-primary">{{ $message->email }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-ink-soft shrink-0">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                </div>

                @if ($message->phone)
                    <p class="text-sm text-ink-soft mb-1">Téléphone : {{ $message->phone }}</p>
                @endif
                @if ($message->subject)
                    <p class="text-sm font-medium text-ink mb-1">{{ $message->subject }}</p>
                @endif
                <p class="text-sm text-ink-soft leading-relaxed mb-4">{{ $message->message }}</p>

                <div class="flex flex-wrap gap-2 pt-2 border-t border-border">
                    @if (! $message->read_at)
                        <button wire:click="markAsRead({{ $message->id }})"
                                class="px-3 py-1.5 rounded-full text-xs font-medium bg-primary text-white hover:bg-primary-light transition-colors">
                            Marquer comme lu
                        </button>
                    @endif
                    <a href="mailto:{{ $message->email }}"
                       class="px-3 py-1.5 rounded-full text-xs font-medium border border-border text-ink-soft hover:bg-tint transition-colors">
                        Répondre par email
                    </a>
                    @if ($message->phone)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $message->phone) }}" target="_blank" rel="noopener"
                           class="px-3 py-1.5 rounded-full text-xs font-medium border border-border text-ink-soft hover:bg-tint transition-colors">
                            WhatsApp
                        </a>
                    @endif
                    <button wire:click="$set('confirmingDeleteId', {{ $message->id }})"
                            class="px-3 py-1.5 rounded-full text-xs font-medium text-red-600 hover:bg-red-50 transition-colors ml-auto">
                        Supprimer
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-surface rounded-2xl border border-border p-8 text-center text-ink-soft">
                Aucun message {{ $unreadOnly ? 'non lu' : '' }}.
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $messages->links() }}</div>

    @if ($confirmingDeleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('confirmingDeleteId', null)"></div>
            <div class="relative bg-surface rounded-2xl border border-border p-6 w-full max-w-sm">
                <h2 class="font-display text-lg font-semibold text-primary-dark mb-2">Supprimer ce message ?</h2>
                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="$set('confirmingDeleteId', null)" class="px-4 py-2 rounded-full text-sm font-medium text-ink-soft hover:bg-tint transition-colors">Annuler</button>
                    <button wire:click="delete({{ $confirmingDeleteId }})" class="px-4 py-2 rounded-full text-sm font-medium bg-red-600 text-white hover:bg-red-700 transition-colors">Supprimer</button>
                </div>
            </div>
        </div>
    @endif
</div>
