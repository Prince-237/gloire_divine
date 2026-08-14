# La Gloire Divine — Phase 1 : Authentification patient

## Fichiers fournis dans ce lot

```
app/Providers/AppServiceProvider.php          (déjà fait en Phase 0 — inchangé)
database/migrations/2026_02_01_000000_add_patient_fields_to_users_table.php
resources/views/components/input-label.blade.php
resources/views/components/text-input.blade.php
resources/views/components/input-error.blade.php
resources/views/components/primary-button.blade.php
resources/views/components/secondary-button.blade.php
resources/views/components/checkbox.blade.php
resources/views/components/layouts/guest.blade.php
resources/views/livewire/pages/auth/register.blade.php
resources/views/livewire/pages/auth/login.blade.php
```

## 1. Copier les fichiers (CMD)

```cmd
cd C:\projets\gloire-divine
copy /Y gloire-divine-src\database\migrations\2026_02_01_000000_add_patient_fields_to_users_table.php database\migrations\
copy /Y gloire-divine-src\resources\views\components\input-label.blade.php resources\views\components\
copy /Y gloire-divine-src\resources\views\components\text-input.blade.php resources\views\components\
copy /Y gloire-divine-src\resources\views\components\input-error.blade.php resources\views\components\
copy /Y gloire-divine-src\resources\views\components\primary-button.blade.php resources\views\components\
copy /Y gloire-divine-src\resources\views\components\secondary-button.blade.php resources\views\components\
copy /Y gloire-divine-src\resources\views\components\checkbox.blade.php resources\views\components\
copy /Y gloire-divine-src\resources\views\components\layouts\guest.blade.php resources\views\components\layouts\
copy /Y gloire-divine-src\resources\views\livewire\pages\auth\register.blade.php resources\views\livewire\pages\auth\
```

**Pour `login.blade.php` : vérifie d'abord** que ton fichier actuel
(`resources\views\livewire\pages\auth\login.blade.php`) a une structure PHP
similaire à celui que je t'ai donné (validation, `Auth::attempt`, rate
limiting). Si oui :

```cmd
copy /Y gloire-divine-src\resources\views\livewire\pages\auth\login.blade.php resources\views\livewire\pages\auth\
```

Si sa logique PHP est vraiment différente de la mienne, colle-le-moi avant de
remplacer — je ne veux pas casser un comportement que je n'ai pas vérifié.

## 2. Migrer la base

```cmd
php artisan migrate
```

Tu dois voir `add_patient_fields_to_users_table ... DONE`.

## 3. Tester

- `http://localhost:8000/register` → formulaire complet (nom, email, sexe,
  date de naissance, téléphone 9 chiffres avec filtrage automatique des
  caractères non numériques, mot de passe + confirmation, case WhatsApp) —
  design vert/blanc cohérent avec le reste du site
- Inscris un compte test → tu dois être connecté automatiquement et redirigé
  vers la page d'accueil
- `http://localhost:8000/login` → même design, connexion fonctionnelle
- Essaie un mauvais mot de passe 6 fois de suite → message de blocage
  temporaire (protection anti-bruteforce déjà incluse par Breeze, on l'a
  juste redessinée)
- Essaie un téléphone à 8 ou 10 chiffres → message d'erreur clair
- Essaie deux mots de passe différents dans les champs mot de
  passe/confirmation → erreur claire

## Notes de conception

- **Redirection après connexion/inscription** : vers la page d'accueil
  (`/`) plutôt que `/dashboard` — le `/dashboard` par défaut de Breeze est
  plus pensé pour un back-office, ce qui correspondra à l'espace **admin**
  qu'on construira en Phase 5. Le patient, lui, revient sur le site public.
- **Mot de passe min 8 / max 64 caractères** : le minimum protège contre les
  mots de passe trop faibles, le maximum évite qu'un attaquant envoie des
  mots de passe volontairement énormes pour ralentir le serveur (le hachage
  bcrypt devient coûteux avec des entrées très longues).
- Les pages **mot de passe oublié / réinitialisation** (générées par Breeze)
  hériteront automatiquement du même design puisqu'elles utilisent les mêmes
  composants partagés qu'on vient de redessiner — normalement rien à faire
  de plus, mais teste-les pour confirmer (`/forgot-password`).
