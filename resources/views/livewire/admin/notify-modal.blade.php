<div>
    <button wire:click="$set('showModal', true)"
            class="px-4 py-2.5 rounded-full border border-primary text-primary text-sm font-medium hover:bg-tint transition-colors inline-flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12.004 2C6.486 2 2 6.486 2 12.004c0 1.998.586 3.86 1.594 5.42L2 22l4.7-1.564A9.96 9.96 0 0012.004 22C17.522 22 22 17.522 22 12.004 22 6.486 17.522 2 12.004 2z"/>
        </svg>
        Notifier des patients
    </button>

    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('showModal', false)"></div>
            <div class="relative bg-surface rounded-2xl border border-border w-full max-w-lg max-h-[85vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-border sticky top-0 bg-surface">
                    <h2 class="font-display text-lg font-semibold text-primary-dark">Notifier par WhatsApp</h2>
                    <button wire:click="$set('showModal', false)" class="text-ink-soft hover:text-ink">✕</button>
                </div>

                <div class="p-6">
                    @if ($justSent)
                        <div class="text-center py-6">
                            <div class="w-12 h-12 rounded-full bg-tint flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                            <p class="text-ink-soft mb-1">Notification mise en file d'attente.</p>
                            <p class="text-xs text-ink-soft/70 mb-6">
                                L'envoi effectif via WhatsApp sera activé en Phase 8 — les destinataires sont déjà enregistrés.
                            </p>
                            <button wire:click="$set('justSent', false)" class="text-sm text-primary hover:text-accent underline">
                                Fermer
                            </button>
                        </div>
                    @else
                        <p class="text-sm text-ink-soft mb-4">
                            Sélectionnez les patients à notifier (seuls ceux ayant un numéro et ayant accepté les notifications WhatsApp apparaissent ici).
                        </p>

                        <label class="flex items-center gap-2 text-sm font-medium text-ink pb-3 mb-3 border-b border-border">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-border text-primary focus:ring-primary">
                            Tous les patients ({{ $this->patients->count() }})
                        </label>

                        @error('selected') <p class="text-sm text-red-600 mb-3">{{ $message }}</p> @enderror

                        <div class="space-y-2 max-h-64 overflow-y-auto mb-5">
                            @forelse ($this->patients as $patient)
                                <label class="flex items-center gap-2.5 text-sm text-ink py-1.5">
                                    <input type="checkbox" wire:model.live="selected" value="{{ $patient->id }}"
                                           class="rounded border-border text-primary focus:ring-primary">
                                    <span>{{ $patient->name }}</span>
                                    <span class="text-ink-soft text-xs">{{ $patient->phone }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-ink-soft">Aucun patient éligible pour l'instant.</p>
                            @endforelse
                        </div>

                        <div class="flex justify-end gap-3">
                            <button wire:click="$set('showModal', false)" class="px-4 py-2 rounded-full text-sm font-medium text-ink-soft hover:bg-tint transition-colors">
                                Annuler
                            </button>
                            <button wire:click="send" class="px-5 py-2 rounded-full text-sm font-medium bg-primary text-white hover:bg-primary-light transition-colors">
                                Notifier ({{ count($selected) }})
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
