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
        RateLimiter::for(
            'login',
            fn($request) =>
            Limit::perMinute(5)->by(
                $request->input('username') . '|' . $request->ip()
            )
        );

        RateLimiter::for(
            'api',
            fn($request) =>
            Limit::perMinute(120)->by($request->user()?->id ?: $request->ip())
        );
    }
}
