<?php

namespace App\Providers;

use App\Models\Advertisement;
use Illuminate\Support\Facades\URL;
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
        if (config('app.env') === 'production' || !empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            URL::forceScheme('https');
        }

        View::composer(['layouts.public', 'welcome', 'articles.show', 'categories.show'], function ($view) {
            $portalAds = Advertisement::active()->get()->groupBy('placement');
            $view->with('portalAds', $portalAds);
        });
    }
}
