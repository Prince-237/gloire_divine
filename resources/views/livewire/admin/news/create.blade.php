<?php

use App\Models\NewsArticle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('components.layouts.admin')] class extends Component
{
    use WithFileUploads;

    public bool $slugTouched = false;
    public string $slug = '';
    public string $title_fr = '';
    public string $title_en = '';
    public string $excerpt_fr = '';
    public string $excerpt_en = '';
    public string $content_fr = '';
    public string $content_en = '';
    public string $image_url = '';
    public $imageUpload = null; // fichier temporaire (Livewire)
    public bool $is_published = true;

    public function updatedTitleFr(string $value): void
    {
        if (! $this->slugTouched) {
            $this->slug = Str::slug($value);
        }
    }

    public function updatedSlug(): void
    {
        $this->slugTouched = true;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'slug' => ['required', 'string', 'max:200', 'unique:news_articles,slug'],
            'title_fr' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'excerpt_fr' => ['nullable', 'string', 'max:255'],
            'excerpt_en' => ['nullable', 'string', 'max:255'],
            'content_fr' => ['required', 'string'],
            'content_en' => ['required', 'string'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'imageUpload' => ['nullable', 'image', 'max:4096'], // 4 Mo max
            'is_published' => ['boolean'],
        ]);

        unset($validated['imageUpload']);

        // Une image uploadée prime sur un lien collé manuellement.
        if ($this->imageUpload) {
            $path = $this->imageUpload->store('news', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        NewsArticle::create([
            ...$validated,
            'author_id' => Auth::id(),
            'published_at' => $validated['is_published'] ? now() : null,
        ]);

        session()->flash('status', 'Actualité créée.');
        $this->redirect(route('admin.news.index'), navigate: true);
    }
}; ?>

<div class="max-w-3xl">
    <a href="{{ route('admin.news.index') }}" class="inline-flex items-center gap-1.5 text-sm text-primary hover:text-accent mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Actualités
    </a>

    <h1 class="font-display text-2xl font-semibold text-primary-dark mb-6">Nouvelle actualité</h1>

    <form wire:submit="save" class="bg-surface rounded-2xl border border-border p-6 md:p-8 space-y-5">
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="title_fr" value="Titre (français)" />
                <x-text-input wire:model.live="title_fr" id="title_fr" />
                <x-input-error :messages="$errors->get('title_fr')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="title_en" value="Titre (anglais)" />
                <x-text-input wire:model="title_en" id="title_en" />
                <x-input-error :messages="$errors->get('title_en')" class="mt-1.5" />
            </div>
        </div>

        <div>
            <x-input-label for="slug" value="Identifiant URL (slug)" />
            <x-text-input wire:model="slug" id="slug" />
            <x-input-error :messages="$errors->get('slug')" class="mt-1.5" />
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="excerpt_fr" value="Résumé court (français, optionnel)" />
                <x-text-input wire:model="excerpt_fr" id="excerpt_fr" />
                <p class="text-xs text-ink-soft mt-1">Laissé vide : le début du contenu sera utilisé automatiquement.</p>
                <x-input-error :messages="$errors->get('excerpt_fr')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="excerpt_en" value="Résumé court (anglais, optionnel)" />
                <x-text-input wire:model="excerpt_en" id="excerpt_en" />
                <x-input-error :messages="$errors->get('excerpt_en')" class="mt-1.5" />
            </div>
        </div>

        <div>
            <x-input-label for="content_fr" value="Contenu (français)" />
            <textarea wire:model="content_fr" id="content_fr" rows="6"
                      class="w-full rounded-lg border border-border bg-surface px-3.5 py-2 text-sm text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"></textarea>
            <x-input-error :messages="$errors->get('content_fr')" class="mt-1.5" />
        </div>
        <div>
            <x-input-label for="content_en" value="Contenu (anglais)" />
            <textarea wire:model="content_en" id="content_en" rows="6"
                      class="w-full rounded-lg border border-border bg-surface px-3.5 py-2 text-sm text-ink focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"></textarea>
            <x-input-error :messages="$errors->get('content_en')" class="mt-1.5" />
        </div>

        <div class="border-t border-border pt-5">
            <x-input-label value="Image (optionnel)" />
            <p class="text-xs text-ink-soft mb-3">Uploade un fichier, ou colle un lien — si les deux sont remplis, le fichier uploadé est prioritaire.</p>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <input type="file" wire:model="imageUpload" accept="image/*"
                           class="w-full text-sm text-ink file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-tint file:text-primary file:text-sm file:font-medium hover:file:bg-primary/10" />
                    <div wire:loading wire:target="imageUpload" class="text-xs text-ink-soft mt-1">Téléversement…</div>
                    <x-input-error :messages="$errors->get('imageUpload')" class="mt-1.5" />
                    @if ($imageUpload)
                        <img src="{{ $imageUpload->temporaryUrl() }}" class="mt-3 rounded-lg border border-border h-24 object-cover">
                    @endif
                </div>
                <div>
                    <x-text-input wire:model="image_url" id="image_url" type="url" placeholder="https://..." />
                    <x-input-error :messages="$errors->get('image_url')" class="mt-1.5" />
                </div>
            </div>
        </div>

        <label class="flex items-center gap-2 text-sm text-ink">
            <x-checkbox wire:model="is_published" />
            Publier immédiatement (sinon enregistré comme brouillon)
        </label>

        <x-primary-button type="submit">Créer l'actualité</x-primary-button>
    </form>
</div>
