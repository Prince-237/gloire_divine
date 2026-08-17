<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyOffer extends Model
{
    protected $table = 'loyalty_offer';

    protected $fillable = [
        'discount_percent', 'min_amount', 'title_fr', 'title_en',
        'description_fr', 'description_en', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    /**
     * Retourne l'unique enregistrement de l'offre, en le créant avec des
     * valeurs par défaut s'il n'existe pas encore. Le dashboard (Phase 5)
     * modifiera directement cet enregistrement.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'en' ? $this->title_en : $this->title_fr;
    }
}
