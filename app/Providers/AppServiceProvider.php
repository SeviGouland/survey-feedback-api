<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

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
        // custom throttle for submit survey per IP
        RateLimiter::for('submit-survey', function ($request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // custom throttle for getting current logged-in responder details per IP
        RateLimiter::for('me', function ($request) {
            return Limit::perMinute(10)->by($request->ip());
        });
    }
}
