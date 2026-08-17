<?php

use App\Models\LoyaltyOffer;
use App\Models\Service;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Routes publiques du site — FR (racine, par défaut) + EN (préfixe /en)
|--------------------------------------------------------------------------
| Ce fichier est chargé depuis routes/web.php via un simple `require`,
| pour ne jamais entrer en conflit avec les routes générées par Breeze
| (auth, settings, etc.).
|
| "Mes rendez-vous" (liste/historique) pointe encore vers "coming-soon" —
| elle arrive en Phase 4 (Espace patient). La prise de RDV, elle, est
| pleinement fonctionnelle depuis la Phase 3.
*/

Route::get('/', fn () => view('pages.home', [
    'services' => Service::active()->ordered()->take(4)->get(),
    'loyaltyOffer' => LoyaltyOffer::current(),
]))->name('home');

Route::get('/services', fn () => view('pages.services.index', ['services' => Service::active()->ordered()->get()]))
    ->name('services.index');

Route::get('/faq', fn () => view('pages.faq'))->name('faq');

Volt::route('/contact', 'pages.contact')->name('contact');

Route::get('/actualites', fn () => view('pages.coming-soon', ['title' => 'Actualités']))->name('news.index');

Route::middleware('auth')->group(function () {
    Volt::route('/rendez-vous/nouveau', 'pages.rendez-vous.create')->name('rendez-vous.create');
    Volt::route('/rendez-vous', 'pages.rendez-vous.index')->name('rendez-vous.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Volt::route('/', 'admin.dashboard')->name('dashboard');
    Volt::route('/utilisateurs', 'admin.users.index')->name('users.index');

    Volt::route('/services', 'admin.services.index')->name('services.index');
    Route::get('/rendez-vous', fn () => view('pages.coming-soon', ['title' => 'Gestion des rendez-vous']))->name('rendez-vous.index');
    Route::get('/messages', fn () => view('pages.coming-soon', ['title' => 'Gestion des messages']))->name('messages.index');
    Route::get('/offre-fidelite', fn () => view('pages.coming-soon', ['title' => "Offre fidélité"]))->name('loyalty.edit');
});

Route::prefix('en')->name('en.')->group(function () {
    Route::get('/', fn () => view('pages.home', [
        'services' => Service::active()->ordered()->take(4)->get(),
        'loyaltyOffer' => LoyaltyOffer::current(),
    ]))->name('home');

    Route::get('/services', fn () => view('pages.services.index', ['services' => Service::active()->ordered()->get()]))
        ->name('services.index');

    Route::get('/faq', fn () => view('pages.faq'))->name('faq');

    Volt::route('/contact', 'pages.contact')->name('contact');

    Route::get('/news', fn () => view('pages.coming-soon', ['title' => 'News']))->name('news.index');

    Route::middleware('auth')->group(function () {
        Volt::route('/appointments/new', 'pages.rendez-vous.create')->name('rendez-vous.create');
        Volt::route('/appointments', 'pages.rendez-vous.index')->name('rendez-vous.index');
    });
});
