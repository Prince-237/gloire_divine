<?php

namespace App\Models;

// Equipe: si ton fichier généré par Breeze a des imports/traits différents
// de ceux ci-dessous, garde LES TIENS et ajoute seulement les lignes
// indiquées par les commentaires "AJOUT" — le plus important est
// $fillable et la relation rendezVous().

use App\Models\RendezVous;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',        // AJOUT Phase 1
        'sex',          // AJOUT Phase 1
        'date_of_birth', // AJOUT Phase 1
        'role',         // AJOUT Phase 5
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date', // AJOUT Phase 1
        ];
    }

    // AJOUT Phase 3 — historique des rendez-vous du patient
    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }

    // AJOUT Phase 5 — accès au back-office
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
