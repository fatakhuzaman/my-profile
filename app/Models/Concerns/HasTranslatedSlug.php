<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

trait HasTranslatedSlug
{
    /**
     * Match the slug of the given locale, defaulting to the current locale.
     */
    #[Scope]
    protected function whereSlug(Builder $query, string $slug, ?string $locale = null): void
    {
        $locale ??= app()->getLocale();

        $query->where("slug->{$locale}", $slug);
    }

    /**
     * Only include records that have content written in the given locale,
     * so untranslated records never show up as duplicate pages.
     */
    #[Scope]
    protected function translatedIn(Builder $query, ?string $locale = null): void
    {
        $locale ??= app()->getLocale();

        $query->whereNotNull("slug->{$locale}");
    }
}
