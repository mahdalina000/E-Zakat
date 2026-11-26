<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\RateLimiter::for(
            'login',
            fn (\Illuminate\Http\Request $r) => \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($r->ip())
        );

        \Illuminate\Support\Facades\RateLimiter::for(
            'register',
            fn (\Illuminate\Http\Request $r) => \Illuminate\Cache\RateLimiting\Limit::perMinute(3)->by($r->ip())
        );
    }
}
