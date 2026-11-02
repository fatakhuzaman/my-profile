<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * Used by translatable models only.
 *
 * @method static void saving(\Closure|string $callback)
 *
 * @mixin Model
 * @mixin HasTranslations
 */
trait HasTranslatedSlug
{
    /**
     * Drop empty translations before saving. A locale left blank in the CMS
     * would otherwise be stored as `""`, which counts as "translated" and
     * collides with other blank slugs on the per-locale unique index.
     */
    public static function bootHasTranslatedSlug(): void
    {
        static::saving(function (self $model): void {
            $model->forgetEmptyTranslations();
        });
    }

    protected function forgetEmptyTranslations(): void
    {
        foreach ($this->getTranslatableAttributes() as $attribute) {
            if (! $this->isDirty($attribute)) {
                continue;
            }

            $translations = array_filter(
                json_decode($this->getAttributes()[$attribute] ?? '[]', true) ?: [],
                fn (mixed $value): bool => $value !== null && $value !== '',
            );

            $this->attributes[$attribute] = json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * Match the slug of the given locale, defaulting to the current locale.
     *
     * @param  Builder<static>  $query
     */
    public function scopeWhereSlug(Builder $query, string $slug, ?string $locale = null): void
    {
        $locale ??= app()->getLocale();

        $query->where("slug->{$locale}", $slug);
    }

    /**
     * Only include records that have content written in the given locale,
     * so untranslated records never show up as duplicate pages.
     *
     * @param  Builder<static>  $query
     */
    public function scopeTranslatedIn(Builder $query, ?string $locale = null): void
    {
        $locale ??= app()->getLocale();

        $query->whereNotNull("slug->{$locale}");
    }
}
