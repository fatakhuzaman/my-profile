<?php

use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\SetLocale;
use App\Support\Localization;
use Illuminate\Support\Facades\Route;

/*
 * The public site is registered once per locale. The default locale (id)
 * has no URL prefix and plain route names; other locales live under
 * /{locale} with route names prefixed by "{locale}.". URL segments come
 * from lang/{locale}/routes.php, e.g. /tentang and /en/about.
 */
$publicRoutes = function (string $locale): void {
    $segment = fn (string $key): string => Localization::segment($key, $locale);

    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get($segment('about'), [PageController::class, 'about'])->name('about');

    Route::get($segment('services'), [ServiceController::class, 'index'])->name('services.index');
    Route::get($segment('services').'/{slug}', [ServiceController::class, 'show'])->name('services.show');

    Route::get($segment('works'), [ProjectController::class, 'index'])->name('works.index');
    Route::get($segment('works').'/{slug}', [ProjectController::class, 'show'])->name('works.show');

    Route::get($segment('blog'), [PostController::class, 'index'])->name('blog.index');
    Route::get($segment('blog').'/{slug}', [PostController::class, 'show'])->name('blog.show');

    Route::get($segment('contact'), [PageController::class, 'contact'])->name('contact');
    Route::post($segment('contact'), [ContactMessageController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('contact.store');
};

foreach (Localization::locales() as $locale) {
    $group = Route::middleware(SetLocale::class.':'.$locale);

    if (! Localization::isDefault($locale)) {
        $group->prefix($locale)->name("{$locale}.");
    }

    $group->group(fn () => $publicRoutes($locale));
}

Route::get('sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('robots.txt', RobotsController::class)->name('robots');

/*
 * URLs of the first version of the site (English paths without a prefix).
 */
Route::permanentRedirect('/about', '/'.Localization::segment('about', 'id'));
Route::permanentRedirect('/services', '/'.Localization::segment('services', 'id'));
Route::permanentRedirect('/works', '/'.Localization::segment('works', 'id'));
Route::permanentRedirect('/contact', '/'.Localization::segment('contact', 'id'));
