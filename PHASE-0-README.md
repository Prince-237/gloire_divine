# La Gloire Divine — Phase 0 : Fondations

Ce dossier contient uniquement les fichiers **custom** (design, structure FR/EN,
favicon, correctifs). Il vient se poser par-dessus un projet Laravel + Breeze
(Livewire) fraîchement généré chez toi.

## 1. Créer le projet Laravel (chez toi)

```cmd
cd C:\Users\THERICH\Desktop\code\pro
composer create-project laravel/laravel gloire-divine
cd gloire-divine
composer require laravel/breeze --dev
php artisan breeze:install livewire
npm install
```

Pendant l'installation de Breeze : **Dark mode support? → no** (on n'en veut pas
cette fois), **Testing framework? → laisse le défaut**.

## 2. Copier les fichiers fournis par-dessus (CMD)

Depuis le dossier qui contient ce `gloire-divine/` (celui que je t'ai donné) et
ton nouveau projet Laravel — **attention, les deux dossiers s'appellent pareil,
renomme le mien avant si besoin pour éviter la confusion** (ex. `gloire-divine-src`) :

```cmd
xcopy gloire-divine-src\app gloire-divine\app /E /I /Y
xcopy gloire-divine-src\resources gloire-divine\resources /E /I /Y
xcopy gloire-divine-src\public gloire-divine\public /E /I /Y
copy /Y gloire-divine-src\routes\web-additions.php gloire-divine\routes\web-additions.php
```

⚠️ `xcopy resources` va écraser certains fichiers que Breeze a générés
(views d'auth, `app.css`, `app.js` de base) — **c'est voulu pour `resources/css`,
`resources/lang` et `resources/views/pages|components|layouts`**, mais vérifie
que `resources/views/auth/*.blade.php` et `resources/js/app.js` de Breeze
n'ont pas été écrasés par erreur (ils ne sont pas dans mon dossier, donc `xcopy`
ne doit pas les toucher — juste une vérification de precaution).

## 3. Brancher les nouvelles routes

Ouvre `routes/web.php` (généré par Breeze) et ajoute **tout en bas** :

```php
require __DIR__.'/web-additions.php';
```

## 4. Enregistrer le middleware de langue

Ouvre `bootstrap/app.php`, dans `->withMiddleware(function (Middleware $middleware) {`
ajoute :

```php
$middleware->web(append: [
    \App\Http\Middleware\SetLocale::class,
]);
```

## 5. Vérifier la version de Tailwind

```cmd
npm list tailwindcss
```

- Si tu vois `4.x.x` → rien à faire, `resources/css/app.css` est déjà prêt.
- Si tu vois `3.x.x` → suis les instructions en commentaire dans
  `tailwind.config.fallback-v3.js` (remplace ton config + adapte `app.css`).

## 6. Base de données

Le fichier `app/Providers/AppServiceProvider.php` fourni inclut déjà le
correctif `Schema::defaultStringLength(191)` — pas besoin de le rajouter
manuellement cette fois.

Dans `.env` :
```
DB_DATABASE=gloire_divine
DB_USERNAME=root
DB_PASSWORD=
```

Crée la base `gloire_divine` dans phpMyAdmin, puis :
```cmd
php artisan migrate
```

## 7. Lancer et vérifier

Terminal 1 :
```cmd
npm run dev
```
Terminal 2 :
```cmd
php artisan serve
```

Puis va sur :
- `http://localhost:8000` → page d'accueil FR avec navbar/footer stylés, logo, favicon dans l'onglet
- `http://localhost:8000/en` → même page en anglais
- Clique sur le sélecteur **FR/EN** dans la nav → doit basculer correctement
- `http://localhost:8000/services`, `/actualites`, `/faq`, `/contact` → doivent afficher "cette page sera construite dans une prochaine phase" (normal, pages réelles = phases suivantes)
- Inscription/connexion Breeze → doivent fonctionner comme avant

## Checklist de validation Phase 0

- [ ] Page d'accueil FR et EN s'affichent avec le bon design (vert/blanc, logo, polices)
- [ ] Favicon visible dans l'onglet du navigateur
- [ ] Sélecteur de langue fonctionnel
- [ ] Navbar responsive (menu mobile) fonctionne
- [ ] Inscription/connexion Breeze fonctionnent toujours
- [ ] Aucune erreur PHP dans le terminal `php artisan serve`

Dis-moi le résultat de cette checklist avant qu'on attaque la Phase 1.
