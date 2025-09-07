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
            $limit = env('SUBMIT_SURVEY_LIMIT');
            return Limit::perMinute($limit)->by($request->ip());
        });

        // custom throttle for getting current logged-in responder details per IP
        RateLimiter::for('me', function ($request) {
            $limit = env('ME_LIMIT');
            return Limit::perMinute($limit)->by($request->ip());
        });
    }
}
