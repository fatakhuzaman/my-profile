<?php

namespace App\Http\Middleware;

use App\Support\Localization;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

/**
 * Switches the app locale for a group of public routes, e.g.
 * `SetLocale::class.':en'` for everything under /en.
 */
class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $locale = null): Response
    {
        $locale = in_array($locale, Localization::locales(), true) ? $locale : Localization::defaultLocale();

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
