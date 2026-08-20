<x-layouts.public :title="app()->getLocale() === 'fr' ? 'Mon profil' : 'My profile'">
    <div class="max-w-2xl px-6 py-16 mx-auto md:py-20">
        <h1 class="mb-1 text-3xl font-semibold font-display text-primary-dark">
            {{ app()->getLocale() === 'fr' ? 'Mon profil' : 'My profile' }}
        </h1>
        <p class="mb-8 text-ink-soft">
            {{ app()->getLocale() === 'fr' ? 'Gérez vos informations personnelles.' : 'Manage your personal information.' }}
        </p>

        <div class="space-y-6">
            <div class="p-6 border bg-surface border-border rounded-2xl md:p-8">
                <livewire:profile.update-profile-information-form />
            </div>

            <div class="p-6 border bg-surface border-border rounded-2xl md:p-8">
                <livewire:profile.update-password-form />
            </div>

            <div class="p-6 border bg-surface border-border rounded-2xl md:p-8">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-layouts.public>
