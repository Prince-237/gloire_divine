<?php

use App\Models\NewsArticle;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.admin')] class extends Component
{
    use WithPagination;

    public ?int $confirmingDeleteId = null;

    public function togglePublished(int $id): void
    {
        $article = NewsArticle::findOrFail($id);
        $article->update([
            'is_published' => ! $article->is_published,
            'published_at' => ! $article->is_published ? now() : $article->published_at,
        ]);
    }

    public function delete(int $id): void
    {
        NewsArticle::findOrFail($id)->delete();
        $this->confirmingDeleteId = null;
        session()->flash('status', 'Actualité supprimée.');
    }

    public function with(): array
    {
        return ['articles' => NewsArticle::latestFirst()->paginate(10)];
    }
}; ?>

<div>
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="font-display text-2xl font-semibold text-primary-dark">Actualités</h1>
            <p class="text-ink-soft text-sm mt-1">Publiez des nouvelles visibles sur le site public.</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="px-4 py-2.5 rounded-full bg-primary text-white text-sm font-medium hover:bg-primary-light transition-colors">
            + Nouvelle actualité
        </a>
    </div>

    @if (session('status'))
        <div class="bg-primary/10 text-primary text-sm rounded-xl px-4 py-3 mb-5">{{ session('status') }}</div>
    @endif

    <div class="bg-surface rounded-2xl border border-border overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-border bg-tint text-left text-ink-soft">
                    <th class="px-5 py-3 font-medium">Titre</th>
                    <th class="px-5 py-3 font-medium hidden sm:table-cell">Date</th>
                    <th class="px-5 py-3 font-medium hidden sm:table-cell">Statut</th>
                    <th class="px-5 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                    <tr class="border-b border-border last:border-0">
                        <td class="px-5 py-3">
                            <p class="font-medium text-ink">{{ $article->title_fr }}</p>
                            <p class="text-xs text-ink-soft">{{ $article->title_en }}</p>
                        </td>
                        <td class="px-5 py-3 hidden sm:table-cell text-ink-soft">
                            {{ optional($article->published_at ?? $article->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="px-5 py-3 hidden sm:table-cell">
                            <button wire:click="togglePublished({{ $article->id }})"
                                    class="text-xs font-semibold rounded-full px-2.5 py-1 transition-colors {{ $article->is_published ? 'bg-primary/10 text-primary' : 'bg-ink-soft/10 text-ink-soft' }}">
                                {{ $article->is_published ? 'Publié' : 'Brouillon' }}
                            </button>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-1">
                                <a href="{{ route('admin.news.edit', $article->id) }}" class="p-2 rounded-lg text-ink-soft hover:bg-tint hover:text-primary transition-colors" aria-label="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                    </svg>
                                </a>
                                <button wire:click="$set('confirmingDeleteId', {{ $article->id }})" class="p-2 rounded-lg text-ink-soft hover:bg-red-50 hover:text-red-600 transition-colors" aria-label="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-ink-soft">Aucune actualité pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $articles->links() }}</div>

    @if ($confirmingDeleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/40" wire:click="$set('confirmingDeleteId', null)"></div>
            <div class="relative bg-surface rounded-2xl border border-border p-6 w-full max-w-sm">
                <h2 class="font-display text-lg font-semibold text-primary-dark mb-2">Supprimer cette actualité ?</h2>
                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="$set('confirmingDeleteId', null)" class="px-4 py-2 rounded-full text-sm font-medium text-ink-soft hover:bg-tint transition-colors">Annuler</button>
                    <button wire:click="delete({{ $confirmingDeleteId }})" class="px-4 py-2 rounded-full text-sm font-medium bg-red-600 text-white hover:bg-red-700 transition-colors">Supprimer</button>
                </div>
            </div>
        </div>
    @endif
</div>
