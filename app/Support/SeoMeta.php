<?php

namespace App\Support;

use App\Models\Page;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * The <head> data of a public page: title, description, share image and
 * the URL of the same page in every locale it exists in.
 */
class SeoMeta
{
    /**
     * Page-specific schema.org nodes, rendered after the site-wide ones.
     *
     * @var list<array<string, mixed>>
     */
    public array $schema = [];

    /**
     * @param  array<string, string>  $alternates  locale => URL
     */
    public function __construct(
        public string $title,
        public ?string $description,
        public array $alternates,
        public ?string $image = null,
        public string $type = 'website',
        public bool $indexable = true,
    ) {}

    /**
     * One of the fixed pages (home, about, ...), available in every locale.
     */
    public static function forPage(?Page $page, string $routeName, ?string $fallbackTitle = null): self
    {
        $title = $page?->meta_title ?: static::withSiteName($page?->title ?? $fallbackTitle ?? '');

        return new self(
            title: $routeName === 'home' && $page?->meta_title === null ? static::siteName() : $title,
            description: $page?->meta_description,
            alternates: static::staticAlternates($routeName),
            image: media_url($page?->og_image),
            indexable: $page?->is_indexable ?? true,
        );
    }

    /**
     * A translatable record with a slug (service, project, post), which only
     * exists in the locales its slug is written in.
     */
    public static function forRecord(Model $record, string $routeName, ?string $image = null, string $type = 'article'): self
    {
        $description = $record->meta_description
            ?: Str::limit(strip_tags((string) ($record->excerpt ?: $record->body)), 160);

        return new self(
            title: $record->meta_title ?: static::withSiteName($record->title),
            description: $description ?: null,
            alternates: static::recordAlternates($record, $routeName),
            image: media_url($record->og_image ?: $image),
            type: $type,
        );
    }

    /**
     * @return array<string, string>
     */
    public static function staticAlternates(string $routeName): array
    {
        $alternates = [];

        foreach (Localization::locales() as $locale) {
            $alternates[$locale] = Localization::route($routeName, [], $locale);
        }

        return $alternates;
    }

    /**
     * @return array<string, string>
     */
    public static function recordAlternates(Model $record, string $routeName): array
    {
        $alternates = [];

        foreach (Localization::locales() as $locale) {
            $slug = $record->getTranslationWithoutFallback('slug', $locale);

            if (filled($slug)) {
                $alternates[$locale] = Localization::route($routeName, ['slug' => $slug], $locale);
            }
        }

        return $alternates;
    }

    /**
     * @param  array<string, mixed>  ...$nodes
     */
    public function withSchema(array ...$nodes): static
    {
        array_push($this->schema, ...array_values($nodes));

        return $this;
    }

    /**
     * The JSON-LD graph of the page, safe to print inside a <script> tag.
     */
    public function jsonLd(): string
    {
        return json_encode([
            '@context' => 'https://schema.org',
            '@graph' => [...StructuredData::site(), ...$this->schema],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_THROW_ON_ERROR);
    }

    public function canonical(): string
    {
        return $this->alternates[app()->getLocale()] ?? url()->current();
    }

    /**
     * Absolute URL of the image shown when the page is shared; social
     * networks ignore relative URLs.
     */
    public function shareImage(): ?string
    {
        $image = $this->image ?? media_url(Setting::get('seo.default_og_image'));

        return $image === null ? null : url($image);
    }

    public static function siteName(): string
    {
        return (string) Setting::get('site.name', config('app.name'));
    }

    protected static function withSiteName(string $title): string
    {
        return trim($title) === '' ? static::siteName() : $title.' | '.static::siteName();
    }
}
