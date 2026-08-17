<?php

use App\Models\Message;
use App\Models\RendezVous;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.admin')] class extends Component
{
    public function with(): array
    {
        return [
            'servicesCount' => Service::active()->count(),
            'upcomingCount' => RendezVous::where('status', 'confirme')->where('date', '>=', now()->toDateString())->count(),
            'unreadMessagesCount' => Message::whereNull('read_at')->count(),
            'recentRdv' => RendezVous::with(['user', 'service'])
                ->where('status', 'confirme')
                ->where('date', '>=', now()->toDateString())
                ->orderBy('date')->orderBy('time')
                ->take(5)->get(),
        ];
    }
}; ?>

<div>
    <h1 class="font-display text-2xl font-semibold text-primary-dark mb-1">Tableau de bord</h1>
    <p class="text-ink-soft mb-6">Vue d'ensemble de l'activité du centre.</p>

    <div class="grid sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-surface rounded-2xl border border-border p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-tint flex items-center justify-center shrink-0">
                <x-service-icon name="stethoscope" class="w-6 h-6 text-primary" />
            </div>
            <div>
                <p class="text-sm text-ink-soft">Services actifs</p>
                <p class="font-display text-2xl font-semibold text-primary-dark">{{ $servicesCount }}</p>
            </div>
        </div>
        <div class="bg-surface rounded-2xl border border-border p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-tint flex items-center justify-center shrink-0">
                <x-service-icon name="heart" class="w-6 h-6 text-primary" />
            </div>
            <div>
                <p class="text-sm text-ink-soft">RDV à venir</p>
                <p class="font-display text-2xl font-semibold text-primary-dark">{{ $upcomingCount }}</p>
            </div>
        </div>
        <div class="bg-surface rounded-2xl border border-border p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-tint flex items-center justify-center shrink-0">
                <x-service-icon name="flask" class="w-6 h-6 text-primary" />
            </div>
            <div>
                <p class="text-sm text-ink-soft">Messages non lus</p>
                <p class="font-display text-2xl font-semibold text-primary-dark">{{ $unreadMessagesCount }}</p>
            </div>
        </div>
    </div>

    <div class="bg-surface rounded-2xl border border-border p-6">
        <h2 class="font-display text-lg font-semibold text-primary-dark mb-4">Prochains rendez-vous</h2>
        @if ($recentRdv->isEmpty())
            <p class="text-sm text-ink-soft">Aucun rendez-vous à venir.</p>
        @else
            <ul class="divide-y divide-border">
                @foreach ($recentRdv as $rdv)
                    <li class="py-3 flex items-center justify-between text-sm">
                        <div>
                            <p class="font-medium text-ink">{{ $rdv->user->name }}</p>
                            <p class="text-ink-soft">{{ $rdv->service->name_fr }} — {{ $rdv->date->format('d/m/Y') }}{{ $rdv->time ? ' à '.\Illuminate\Support\Carbon::parse($rdv->time)->format('H:i') : '' }}</p>
                        </div>
                        <span class="text-xs font-semibold bg-primary/10 text-primary rounded-full px-3 py-1">Confirmé</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
