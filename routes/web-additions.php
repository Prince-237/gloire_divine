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

Route::get('/actualites', fn () => view('pages.news.index', ['articles' => \App\Models\NewsArticle::published()->latestFirst()->paginate(6)]))
    ->name('news.index');
Route::get('/actualites/{article:slug}', fn (\App\Models\NewsArticle $article) => view('pages.news.show', ['article' => $article]))
    ->name('news.show');

Route::middleware('auth')->group(function () {
    Volt::route('/rendez-vous/nouveau', 'pages.rendez-vous.create')->name('rendez-vous.create');
    Volt::route('/rendez-vous', 'pages.rendez-vous.index')->name('rendez-vous.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Volt::route('/', 'admin.dashboard')->name('dashboard');
    Volt::route('/utilisateurs', 'admin.users.index')->name('users.index');

    Volt::route('/services', 'admin.services.index')->name('services.index');
    Volt::route('/rendez-vous', 'admin.rendez-vous.index')->name('rendez-vous.index');
    Volt::route('/messages', 'admin.messages.index')->name('messages.index');
    Volt::route('/offre-fidelite', 'admin.loyalty.edit')->name('loyalty.edit');

    Volt::route('/actualites', 'admin.news.index')->name('news.index');
    Volt::route('/actualites/nouvelle', 'admin.news.create')->name('news.create');
    Volt::route('/actualites/{article}/modifier', 'admin.news.edit')->name('news.edit');
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

    Route::get('/news', fn () => view('pages.news.index', ['articles' => \App\Models\NewsArticle::published()->latestFirst()->paginate(6)]))
        ->name('news.index');
    Route::get('/news/{article:slug}', fn (\App\Models\NewsArticle $article) => view('pages.news.show', ['article' => $article]))
        ->name('news.show');

    Route::middleware('auth')->group(function () {
        Volt::route('/appointments/new', 'pages.rendez-vous.create')->name('rendez-vous.create');
        Volt::route('/appointments', 'pages.rendez-vous.index')->name('rendez-vous.index');
    });
});
