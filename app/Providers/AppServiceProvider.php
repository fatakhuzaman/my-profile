<?php

namespace App\Providers;

use App\Models\Page;
use App\Support\SeoMeta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewInstance;
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

        // Surface N+1 queries while developing instead of in production.
        Model::preventLazyLoading(! $this->app->isProduction());

        View::composer(['components.site.header', 'components.site.footer'], function (ViewInstance $view): void {
            $view->with([
                'siteName' => SeoMeta::siteName(),
                'navPages' => Page::query()->orderBy('id')->get()
                    ->mapWithKeys(fn (Page $page): array => [$page->key => $page->title])
                    ->all(),
            ]);
        });
    }
}
