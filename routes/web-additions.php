<?php

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
| Actualités et RDV pointent encore vers "coming-soon" — elles arrivent
| en Phase 3 (RDV) et Phase 6 (Actualités).
*/

Route::get('/', fn () => view('pages.home', ['services' => Service::active()->ordered()->take(4)->get()]))
    ->name('home');

Route::get('/services', fn () => view('pages.services.index', ['services' => Service::active()->ordered()->get()]))
    ->name('services.index');

Route::get('/faq', fn () => view('pages.faq'))->name('faq');

Volt::route('/contact', 'pages.contact')->name('contact');

Route::get('/actualites', fn () => view('pages.coming-soon', ['title' => 'Actualités']))->name('news.index');
Route::get('/rendez-vous', fn () => view('pages.coming-soon', ['title' => 'Mes rendez-vous']))
    ->middleware('auth')->name('rendez-vous.index');
Route::get('/rendez-vous/nouveau', fn () => view('pages.coming-soon', ['title' => 'Prendre rendez-vous']))
    ->name('rendez-vous.create');

Route::prefix('en')->name('en.')->group(function () {
    Route::get('/', fn () => view('pages.home', ['services' => Service::active()->ordered()->take(4)->get()]))
        ->name('home');

    Route::get('/services', fn () => view('pages.services.index', ['services' => Service::active()->ordered()->get()]))
        ->name('services.index');

    Route::get('/faq', fn () => view('pages.faq'))->name('faq');

    Volt::route('/contact', 'pages.contact')->name('contact');

    Route::get('/news', fn () => view('pages.coming-soon', ['title' => 'News']))->name('news.index');
    Route::get('/appointments', fn () => view('pages.coming-soon', ['title' => 'My appointments']))
        ->middleware('auth')->name('rendez-vous.index');
    Route::get('/appointments/new', fn () => view('pages.coming-soon', ['title' => 'Book an appointment']))
        ->name('rendez-vous.create');
});
