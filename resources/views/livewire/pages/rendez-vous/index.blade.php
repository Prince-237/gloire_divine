<?php

use App\Models\RendezVous;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.public')] class extends Component
{
    public function with(): array
    {
        return [
            'upcoming' => RendezVous::where('user_id', Auth::id())
                ->with('service')
                ->where('date', '>=', now()->toDateString())
                ->where('status', '!=', 'annule')
                ->orderBy('date')
                ->orderBy('time')
                ->get(),
            'past' => RendezVous::where('user_id', Auth::id())
                ->with('service')
                ->where(function ($q) {
                    $q->where('date', '<', now()->toDateString())
                        ->orWhere('status', 'annule');
                })
                ->orderByDesc('date')
                ->get(),
        ];
    }
}; ?>

@php
    $isFr = app()->getLocale() === 'fr';
    $localePrefix = $isFr ? '' : 'en.';

    $statusStyles = [
        'confirme' => 'bg-primary/10 text-primary',
        'annule' => 'bg-red-50 text-red-600',
    ];
    $statusLabels = $isFr
        ? ['confirme' => 'Confirmé', 'annule' => 'Annulé']
        : ['confirme' => 'Confirmed', 'annule' => 'Cancelled'];
@endphp

<div class="max-w-2xl mx-auto px-6 py-16 md:py-20">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="font-display text-3xl font-semibold text-primary-dark mb-1">
                {{ $isFr ? 'Mes rendez-vous' : 'My appointments' }}
            </h1>
            <p class="text-ink-soft">
                {{ $isFr ? 'Historique de vos rendez-vous chez La Gloire Divine.' : 'Your appointment history at La Gloire Divine.' }}
            </p>
        </div>
        <a href="{{ route($localePrefix.'rendez-vous.create') }}"
           class="px-5 py-2.5 rounded-full bg-primary text-white text-sm font-medium hover:bg-primary-light transition-colors shrink-0">
            {{ $isFr ? 'Nouveau rendez-vous' : 'New appointment' }}
        </a>
    </div>

    <h2 class="font-display text-lg font-semibold text-primary-dark mb-4">
        {{ $isFr ? 'À venir' : 'Upcoming' }}
    </h2>
    @if ($upcoming->isEmpty())
        <div class="bg-surface rounded-2xl border border-border p-6 text-center text-ink-soft mb-10">
            {{ $isFr ? 'Aucun rendez-vous à venir.' : 'No upcoming appointments.' }}
        </div>
    @else
        <div class="space-y-3 mb-10">
            @foreach ($upcoming as $rdv)
                <div class="bg-surface rounded-2xl border border-border p-5">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <div>
                            <p class="font-medium text-ink">{{ $rdv->service->name }}</p>
                            <p class="text-sm text-ink-soft">
                                {{ \Illuminate\Support\Carbon::parse($rdv->date)->translatedFormat('d M Y') }}
                                @if ($rdv->time) — {{ \Illuminate\Support\Carbon::parse($rdv->time)->format('H:i') }} @endif
                            </p>
                        </div>
                        <span class="text-xs font-semibold rounded-full px-3 py-1 shrink-0 {{ $statusStyles[$rdv->status] }}">
                            {{ $statusLabels[$rdv->status] }}
                        </span>
                    </div>
                    @if ($rdv->notes)
                        <p class="text-sm text-ink-soft border-t border-border pt-2 mt-2">{{ $rdv->notes }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <h2 class="font-display text-lg font-semibold text-primary-dark mb-4">
        {{ $isFr ? 'Passés / annulés' : 'Past / cancelled' }}
    </h2>
    @if ($past->isEmpty())
        <div class="bg-surface rounded-2xl border border-border p-6 text-center text-ink-soft">
            {{ $isFr ? 'Aucun historique pour le moment.' : 'No history yet.' }}
        </div>
    @else
        <div class="space-y-3">
            @foreach ($past as $rdv)
                <div class="bg-surface/60 rounded-2xl border border-border p-5 opacity-80">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="font-medium text-ink">{{ $rdv->service->name }}</p>
                            <p class="text-sm text-ink-soft">
                                {{ \Illuminate\Support\Carbon::parse($rdv->date)->translatedFormat('d M Y') }}
                                @if ($rdv->time) — {{ \Illuminate\Support\Carbon::parse($rdv->time)->format('H:i') }} @endif
                            </p>
                        </div>
                        <span class="text-xs font-semibold rounded-full px-3 py-1 shrink-0 {{ $statusStyles[$rdv->status] }}">
                            {{ $statusLabels[$rdv->status] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
