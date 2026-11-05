<?php

use App\Http\Controllers\CertificatePdfController;
use App\Http\Controllers\Frontend\CertificateController;
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
use App\Http\Controllers\Player\CertificateController as PlayerCertificateController;
use App\Http\Controllers\Player\DashboardController;
use App\Http\Controllers\Player\LoginController;
use App\Http\Controllers\Player\PasswordController;
use App\Http\Controllers\Player\PhotoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Site
|--------------------------------------------------------------------------
|
| One route per public page in CLAUDE.md section 4. Content pages read from
| the database (Phase 2A). The contact and registration forms post to
| controllers with FormRequests (Phase 2B), throttled by the "public-forms"
| limiter. Certificates (Phase 3): lookup by Player ID + date of birth,
| throttled by "certificate-lookup", gives 30-minute signed PDF links; the QR
| code on each PDF opens the verify page. Contact details come from settings.
| Player sign-in (Phase 4) is on the "player" guard; the player area follows.
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
    Route::middleware('guest:player')->group(function () {
        Route::get('/players/login', [LoginController::class, 'create'])->name('players.login');
        Route::post('/players/login', [LoginController::class, 'store'])->middleware('throttle:login')->name('players.login.store');
    });
    Route::get('/international-players', [PlayerController::class, 'international'])->name('players.international');

    Route::get('/events/current', [EventController::class, 'index'])->defaults('period', 'current')->name('events.current');
    Route::get('/events/upcoming', [EventController::class, 'index'])->defaults('period', 'upcoming')->name('events.upcoming');
    Route::get('/events/previous', [EventController::class, 'index'])->defaults('period', 'previous')->name('events.previous');
    Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

    Route::get('/results', [EventController::class, 'results'])->defaults('position', 0)->name('results.index');
    Route::get('/results/winners', [EventController::class, 'results'])->defaults('position', 1)->name('results.winners');
    Route::get('/results/runners-up', [EventController::class, 'results'])->defaults('position', 2)->name('results.runners-up');
    Route::get('/results/third-place', [EventController::class, 'results'])->defaults('position', 3)->name('results.third-place');

    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::post('/certificates', [CertificateController::class, 'lookup'])->middleware('throttle:certificate-lookup')->name('certificates.lookup');
    Route::get('/certificates/verify/{code}', [CertificateController::class, 'verify'])->name('certificates.verify');
    // Relative signatures: the link stays valid behind proxies and on any host alias (www, http/https).
    Route::get('/certificates/{certificate}/download', CertificatePdfController::class)->middleware('signed:relative')->name('certificates.download');

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

/*
|--------------------------------------------------------------------------
| Player Area
|--------------------------------------------------------------------------
|
| Registered players on the "player" guard (admins use the Filament panel
| at /admin). Pending and rejected players can sign in and see their status;
| certificate downloads also need an approved registration.
|
*/

Route::prefix('player')->name('player.')->group(function () {
    Route::middleware('guest:player')->group(function () {
        Route::get('/forgot-password', [PasswordController::class, 'request'])->name('password.request');
        Route::post('/forgot-password', [PasswordController::class, 'email'])->middleware('throttle:public-forms')->name('password.email');
        Route::get('/reset-password/{token}', [PasswordController::class, 'reset'])->name('password.reset');
        Route::post('/reset-password', [PasswordController::class, 'update'])->middleware('throttle:public-forms')->name('password.update');
    });

    Route::middleware('auth:player')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/photo', PhotoController::class)->name('photo');
        Route::get('/certificates/{certificate}/download', PlayerCertificateController::class)->middleware('player.approved')->name('certificates.download');
        Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    });
});
