<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateProfileInformationForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $sex = '';
    public string $date_of_birth = '';

    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->sex = $user->sex ?? '';
        $this->date_of_birth = optional($user->date_of_birth)->format('Y-m-d') ?? '';
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'string', 'regex:/^[0-9]{9}$/', Rule::unique('users', 'phone')->ignore($user->id)],
            'sex' => ['required', Rule::in(['M', 'F'])],
            'date_of_birth' => ['required', 'date', 'before:today'],
        ], [
            'phone.regex' => app()->getLocale() === 'fr'
                ? 'Le numéro de téléphone doit contenir exactement 9 chiffres.'
                : 'The phone number must contain exactly 9 digits.',
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }
}
