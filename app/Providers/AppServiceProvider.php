<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Catch N+1 queries during development and tests.
        Model::preventLazyLoading(! $this->app->isProduction());

        Paginator::defaultView('partials.pagination');

        // Site settings for the public layout, footer and contact page
        // (managed in /admin/site-settings; read from one cache entry).
        View::composer(['layouts.frontend', 'partials.footer', 'frontend.contact'], function ($view): void {
            $view->with([
                'site' => [
                    'name' => Setting::get('site_name', 'Jumpball Federation of India'),
                    'tagline' => Setting::get('tagline'),
                    'footer_text' => Setting::get('footer_text', 'Jumpball Federation of India. All rights reserved.'),
                    'meta_description' => Setting::get('default_meta_description', 'Jumpball Federation of India is the national body for the development, competition and governance of Jumpball in India.'),
                ],
                'contact' => [
                    'email' => Setting::get('contact_email'),
                    'phone' => Setting::get('contact_phone'),
                    'address' => Setting::get('contact_address'),
                    'map_embed' => Setting::get('map_embed'),
                ],
                'social' => array_filter([
                    'Facebook' => ['url' => Setting::get('facebook_url'), 'icon' => 'fa-brands fa-facebook-f'],
                    'Instagram' => ['url' => Setting::get('instagram_url'), 'icon' => 'fa-brands fa-instagram'],
                    'YouTube' => ['url' => Setting::get('youtube_url'), 'icon' => 'fa-brands fa-youtube'],
                    'X' => ['url' => Setting::get('x_url'), 'icon' => 'fa-brands fa-x-twitter'],
                ], fn (array $link): bool => filled($link['url'])),
            ]);
        });
    }
}
