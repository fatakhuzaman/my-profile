<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Translatable\Facades\Translatable;

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
        // Content is authored in the default locale first, so untranslated
        // fields fall back to it rather than to the framework fallback.
        Translatable::fallback(fallbackLocale: config('app.supported_locales')[0]);
    }
}
