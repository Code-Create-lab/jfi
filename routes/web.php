<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OfficeBearerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Site (design stage)
|--------------------------------------------------------------------------
|
| One route per public page in CLAUDE.md section 4. These are view routes
| for now; the views fall back to design preview data until frontend
| controllers pass real data. Form submissions are wired in a later step.
|
*/

Route::name('frontend.')->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::view('/about-federation', 'frontend.page', ['slug' => 'about-federation'])->name('about.federation');
    Route::view('/about-jumpball', 'frontend.page', ['slug' => 'about-jumpball'])->name('about.jumpball');
    Route::view('/president-message', 'frontend.page', ['slug' => 'president-message'])->name('about.president');
    Route::get('/office-bearers/national', [OfficeBearerController::class, 'national'])->name('office-bearers.national');
    Route::view('/office-bearers/state', 'frontend.office-bearers', ['level' => 'state'])->name('office-bearers.state');

    Route::view('/state-associations', 'frontend.associations.index')->name('associations.index');
    Route::view('/state-associations/register', 'frontend.associations.register')->name('associations.register');

    Route::view('/players', 'frontend.players.index')->name('players.index');
    Route::view('/players/register', 'frontend.players.register')->name('players.register');
    Route::view('/players/login', 'frontend.players.login')->name('players.login');
    Route::view('/international-players', 'frontend.players.international')->name('players.international');

    Route::view('/events/current', 'frontend.events.index', ['period' => 'current'])->name('events.current');
    Route::view('/events/upcoming', 'frontend.events.index', ['period' => 'upcoming'])->name('events.upcoming');
    Route::view('/events/previous', 'frontend.events.index', ['period' => 'previous'])->name('events.previous');
    Route::view('/events/{slug}', 'frontend.events.show')->name('events.show');

    Route::view('/results', 'frontend.results.index', ['position' => 0])->name('results.index');
    Route::view('/results/winners', 'frontend.results.index', ['position' => 1])->name('results.winners');
    Route::view('/results/runners-up', 'frontend.results.index', ['position' => 2])->name('results.runners-up');
    Route::view('/results/third-place', 'frontend.results.index', ['position' => 3])->name('results.third-place');

    Route::view('/certificates', 'frontend.certificates.index')->name('certificates.index');
    Route::view('/certificates/verify/{code}', 'frontend.certificates.verify')->name('certificates.verify');

    Route::view('/news', 'frontend.news.index')->name('news.index');
    Route::view('/news/{slug}', 'frontend.news.show')->name('news.show');
    Route::view('/gallery', 'frontend.gallery.index')->name('gallery.index');
    Route::view('/gallery/{slug}', 'frontend.gallery.show')->name('gallery.show');
    Route::view('/videos', 'frontend.videos')->name('videos');
    Route::view('/downloads', 'frontend.downloads')->name('downloads');
    Route::view('/rule-book', 'frontend.downloads', ['mode' => 'rule-book'])->name('rule-book');

    Route::view('/community', 'frontend.community.index')->name('community.index');
    Route::view('/community/{slug}', 'frontend.community.show')->name('community.show');

    Route::view('/contact', 'frontend.contact')->name('contact');
    Route::view('/privacy-policy', 'frontend.page', ['slug' => 'privacy-policy'])->name('legal.privacy');
    Route::view('/terms-and-conditions', 'frontend.page', ['slug' => 'terms-and-conditions'])->name('legal.terms');
});
