<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;
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

        // The site's own CSS/JS in public/assets is not bundled by Vite, and
        // the server lets browsers cache it for a week. Adding the file's
        // modification time to the URL makes browsers fetch each new deploy.
        // Usage: href="@versionedAsset('assets/css/jfi-theme.css')"
        Blade::directive('versionedAsset', fn (string $path): string => "<?php echo e(asset({$path}).(is_file(public_path({$path})) ? '?v='.filemtime(public_path({$path})) : '')); ?>");

        // Contact and registration forms: 5 submissions per minute per IP.
        RateLimiter::for('public-forms', fn (Request $request): Limit => Limit::perMinute(5)->by($request->ip()));

        // Public certificate lookup (Player ID + date of birth): 10 per minute per IP.
        RateLimiter::for('certificate-lookup', fn (Request $request): Limit => Limit::perMinute(10)->by($request->ip()));

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
