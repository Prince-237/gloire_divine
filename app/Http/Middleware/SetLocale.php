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
     * Détermine la langue depuis le préfixe d'URL (ex: /en/services),
     * l'applique à l'application, et la mémorise en session pour que
     * la navigation ultérieure (ex: liens internes sans préfixe explicite)
     * reste cohérente.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        $locale = ($path === 'en' || str_starts_with($path, 'en/')) ? 'en' : self::DEFAULT;

        App::setLocale($locale);
        session(['locale' => $locale]);

        return $next($request);
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
