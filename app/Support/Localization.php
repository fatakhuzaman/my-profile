<?php

namespace App\Support;

use Illuminate\Routing\Route;

/**
 * Locale aware URLs. The default locale is served without a prefix and uses
 * the plain route names (`about`); other locales are prefixed (`/en/...`)
 * and their route names carry the locale (`en.about`).
 */
class Localization
{
    /**
     * @return list<string>
     */
    public static function locales(): array
    {
        return config('app.supported_locales');
    }

    public static function defaultLocale(): string
    {
        return static::locales()[0];
    }

    public static function isDefault(string $locale): bool
    {
        return $locale === static::defaultLocale();
    }

    /**
     * The route name for a page in the given locale.
     */
    public static function routeName(string $name, ?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        return static::isDefault($locale) ? $name : "{$locale}.{$name}";
    }

    /**
     * The page's route name without its locale prefix.
     */
    public static function baseRouteName(?Route $route): ?string
    {
        $name = $route?->getName();

        if ($name === null) {
            return null;
        }

        foreach (static::locales() as $locale) {
            if (! static::isDefault($locale) && str_starts_with($name, "{$locale}.")) {
                return substr($name, strlen($locale) + 1);
            }
        }

        return $name;
    }

    /**
     * @param  array<string, mixed>|string  $parameters
     */
    public static function route(string $name, array|string $parameters = [], ?string $locale = null): string
    {
        return route(static::routeName($name, $locale), $parameters);
    }

    /**
     * URL segment of a page in the given locale, e.g. "tentang" or "about".
     */
    public static function segment(string $key, string $locale): string
    {
        return trans("routes.{$key}", [], $locale);
    }
}
