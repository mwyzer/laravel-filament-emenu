<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;

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
        // Force HTTPS scheme for ngrok links
        if (str_contains(request()->url(), 'ngrok-free.app')) {
            URL::forceScheme('https');
        }

        // Register Blade component for bottom navigation
        Blade::component('menus.bottom', 'bottomMenu');
    }
}
