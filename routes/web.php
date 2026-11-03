<?php

use App\Http\Controllers\Frontend\CommunityController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\DownloadController;
use App\Http\Controllers\Frontend\EventController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MediaController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\OfficeBearerController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PlayerController;
use App\Http\Controllers\Frontend\StateAssociationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Site
|--------------------------------------------------------------------------
|
| One route per public page in CLAUDE.md section 4. Content pages read from
| the database (Phase 2A). The contact and registration forms post to
| controllers with FormRequests (Phase 2B), throttled by the "public-forms"
| limiter. Player login and the certificate pages are still view routes;
| they are wired in Phases 3 and 4. Contact details come from settings.
|
*/

Route::name('frontend.')->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::get('/about-federation', PageController::class)->defaults('slug', 'about-federation')->name('about.federation');
    Route::get('/about-jumpball', PageController::class)->defaults('slug', 'about-jumpball')->name('about.jumpball');
    Route::get('/president-message', PageController::class)->defaults('slug', 'president-message')->name('about.president');
    Route::get('/office-bearers/national', [OfficeBearerController::class, 'national'])->name('office-bearers.national');
    Route::get('/office-bearers/state', [OfficeBearerController::class, 'state'])->name('office-bearers.state');

    Route::get('/state-associations', [StateAssociationController::class, 'index'])->name('associations.index');
    Route::get('/state-associations/register', [StateAssociationController::class, 'create'])->name('associations.register');
    Route::post('/state-associations/register', [StateAssociationController::class, 'store'])->middleware('throttle:public-forms')->name('associations.store');

    Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
    Route::get('/players/register', [PlayerController::class, 'create'])->name('players.register');
    Route::post('/players/register', [PlayerController::class, 'store'])->middleware('throttle:public-forms')->name('players.store');
    Route::view('/players/login', 'frontend.players.login')->name('players.login');
    Route::get('/international-players', [PlayerController::class, 'international'])->name('players.international');

    Route::get('/events/current', [EventController::class, 'index'])->defaults('period', 'current')->name('events.current');
    Route::get('/events/upcoming', [EventController::class, 'index'])->defaults('period', 'upcoming')->name('events.upcoming');
    Route::get('/events/previous', [EventController::class, 'index'])->defaults('period', 'previous')->name('events.previous');
    Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

    Route::get('/results', [EventController::class, 'results'])->defaults('position', 0)->name('results.index');
    Route::get('/results/winners', [EventController::class, 'results'])->defaults('position', 1)->name('results.winners');
    Route::get('/results/runners-up', [EventController::class, 'results'])->defaults('position', 2)->name('results.runners-up');
    Route::get('/results/third-place', [EventController::class, 'results'])->defaults('position', 3)->name('results.third-place');

    Route::view('/certificates', 'frontend.certificates.index')->name('certificates.index');
    Route::view('/certificates/verify/{code}', 'frontend.certificates.verify')->name('certificates.verify');

    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
    Route::get('/gallery', [MediaController::class, 'galleries'])->name('gallery.index');
    Route::get('/gallery/{slug}', [MediaController::class, 'gallery'])->name('gallery.show');
    Route::get('/videos', [MediaController::class, 'videos'])->name('videos');
    Route::get('/downloads', [DownloadController::class, 'index'])->name('downloads');
    Route::get('/rule-book', [DownloadController::class, 'index'])->defaults('mode', 'rule-book')->name('rule-book');

    Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
    Route::get('/community/{slug}', [CommunityController::class, 'show'])->name('community.show');

    Route::view('/contact', 'frontend.contact')->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:public-forms')->name('contact.store');
    Route::get('/privacy-policy', PageController::class)->defaults('slug', 'privacy-policy')->name('legal.privacy');
    Route::get('/terms-and-conditions', PageController::class)->defaults('slug', 'terms-and-conditions')->name('legal.terms');
});
