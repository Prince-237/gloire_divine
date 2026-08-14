<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Nécessaire pour MySQL/MariaDB plus anciens (courant sur les
        // hébergements mutualisés type InfinityFree) : évite l'erreur
        // "1071 La clé est trop longue" sur les colonnes uniques/indexées
        // avec l'encodage utf8mb4 par défaut de Laravel.
        Schema::defaultStringLength(191);
    }
}
