<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public const SUPPORTED = ['fr', 'en'];
    public const DEFAULT = 'fr';

    /**
     * Routes "de compte" partagées entre les deux langues (pas de version
     * /en/... dédiée) — on y respecte la langue déjà choisie par le
     * visiteur au lieu de la réinitialiser en français par défaut.
     */
    private const SHARED_PREFIXES = [
        'profile', 'dashboard', 'admin',
        'login', 'register', 'logout',
        'forgot-password', 'reset-password', 'verify-email', 'confirm-password',
    ];

    /**
     * Détermine la langue depuis le préfixe d'URL (ex: /en/services),
     * l'applique à l'application, et la mémorise en session pour que
     * la navigation ultérieure (ex: liens internes sans préfixe explicite)
     * reste cohérente.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        if ($path === 'en' || str_starts_with($path, 'en/')) {
            $locale = 'en';
        } elseif ($this->isSharedPath($path)) {
            // Page de compte partagée : on garde la langue déjà en session.
            $locale = session('locale', self::DEFAULT);
        } else {
            // Page de contenu FR (racine) : toujours français, peu importe
            // la langue précédemment choisie.
            $locale = self::DEFAULT;
        }

        App::setLocale($locale);
        session(['locale' => $locale]);

        return $next($request);
    }

    private function isSharedPath(string $path): bool
    {
        foreach (self::SHARED_PREFIXES as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix.'/')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Construit l'URL équivalente dans l'autre langue à partir de la route
     * courante (par son NOM, pas son chemin texte) — utilisé par le
     * sélecteur de langue dans la nav. Nécessaire car les slugs FR/EN
     * diffèrent volontairement (ex: /actualites vs /news), donc on ne peut
     * pas simplement ajouter/retirer un préfixe "en/" dans le texte de l'URL.
     */
    public static function urlForLocale(string $locale, ?Request $request = null): string
    {
        $request = $request ?? request();
        $currentName = optional($request->route())->getName();

        if (! $currentName) {
            return $locale === self::DEFAULT ? url('/') : url('/'.$locale);
        }

        // Nom "de base" de la route, sans le préfixe "en." s'il est présent.
        $baseName = str_starts_with($currentName, 'en.')
            ? substr($currentName, 3)
            : $currentName;

        $targetName = $locale === self::DEFAULT ? $baseName : 'en.'.$baseName;
        $parameters = $request->route()->parameters();

        if (\Illuminate\Support\Facades\Route::has($targetName)) {
            return route($targetName, $parameters);
        }

        // Repli : si la route équivalente n'existe pas dans l'autre langue
        // (ne devrait pas arriver si les deux groupes sont tenus symétriques),
        // on renvoie vers l'accueil de la langue cible plutôt qu'une 404.
        return $locale === self::DEFAULT ? url('/') : url('/'.$locale);
    }
}
