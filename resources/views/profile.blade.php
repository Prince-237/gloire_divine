<x-layouts.public :title="app()->getLocale() === 'fr' ? 'Mon profil' : 'My profile'">
    <div class="max-w-2xl mx-auto px-6 py-16 md:py-20">
        <h1 class="font-display text-3xl font-semibold text-primary-dark mb-1">
            {{ app()->getLocale() === 'fr' ? 'Mon profil' : 'My profile' }}
        </h1>
        <p class="text-ink-soft mb-8">
            {{ app()->getLocale() === 'fr' ? 'Gérez vos informations personnelles.' : 'Manage your personal information.' }}
        </p>

        <div class="space-y-6">
            <div class="bg-surface border border-border rounded-2xl p-6 md:p-8">
                <livewire:profile.update-profile-information-form />
            </div>

            <div class="bg-surface border border-border rounded-2xl p-6 md:p-8">
                <livewire:profile.update-password-form />
            </div>

            <div class="bg-surface border border-border rounded-2xl p-6 md:p-8">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-layouts.public>
