<?php

namespace App\Support;

use App\Models\Page;
use App\Models\Post;
use App\Models\PricingPlan;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Collection;

/**
 * schema.org nodes rendered as JSON-LD, so search engines understand who
 * the site belongs to and what each page is about.
 */
class StructuredData
{
    /**
     * Nodes describing the site and its owner, present on every page.
     *
     * @return list<array<string, mixed>>
     */
    public static function site(): array
    {
        return [
            static::withoutEmpty([
                '@type' => 'WebSite',
                '@id' => static::id('website'),
                'url' => Localization::route('home'),
                'name' => SeoMeta::siteName(),
                'inLanguage' => app()->getLocale(),
                'publisher' => ['@id' => static::id('person')],
            ]),
            static::person(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function person(): array
    {
        $photo = media_url(Setting::get('person.photo'));

        return static::withoutEmpty([
            '@type' => 'Person',
            '@id' => static::id('person'),
            'name' => Setting::get('person.full_name'),
            'alternateName' => Setting::get('person.short_name'),
            'description' => Setting::localized('person.headline'),
            'url' => Localization::route('about'),
            'image' => $photo === null ? null : url($photo),
            'email' => Setting::get('contact.email'),
            'sameAs' => array_values(array_filter([
                Setting::get('social.linkedin'),
                Setting::get('social.github'),
                Setting::get('social.instagram'),
            ])),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function blogPosting(Post $post, SeoMeta $seo): array
    {
        return static::withoutEmpty([
            '@type' => 'BlogPosting',
            '@id' => $seo->canonical().'#article',
            'mainEntityOfPage' => $seo->canonical(),
            'headline' => $post->title,
            'description' => $seo->description,
            'image' => $seo->shareImage(),
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => $post->updated_at?->toIso8601String(),
            'inLanguage' => app()->getLocale(),
            'author' => $post->author === null
                ? ['@id' => static::id('person')]
                : ['@type' => 'Person', 'name' => $post->author->name],
            'publisher' => ['@id' => static::id('person')],
            'articleSection' => $post->category?->name,
            'keywords' => $post->tags->pluck('name')->implode(', '),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function creativeWork(Project $project, SeoMeta $seo): array
    {
        return static::withoutEmpty([
            '@type' => 'CreativeWork',
            '@id' => $seo->canonical().'#work',
            'url' => $seo->canonical(),
            'name' => $project->title,
            'description' => $seo->description,
            'image' => $seo->shareImage(),
            'dateCreated' => $project->year === null ? null : (string) $project->year,
            'inLanguage' => app()->getLocale(),
            'creator' => ['@id' => static::id('person')],
            'keywords' => $project->categories->pluck('name')->implode(', '),
        ]);
    }

    /**
     * @param  Collection<int, PricingPlan>  $plans
     * @return array<string, mixed>
     */
    public static function service(Service $service, Collection $plans, SeoMeta $seo): array
    {
        return static::withoutEmpty([
            '@type' => 'Service',
            '@id' => $seo->canonical().'#service',
            'url' => $seo->canonical(),
            'name' => $service->title,
            'description' => $seo->description,
            'image' => $seo->shareImage(),
            'provider' => ['@id' => static::id('person')],
            'offers' => $plans
                ->filter(fn (PricingPlan $plan): bool => $plan->price !== null)
                ->map(fn (PricingPlan $plan): array => [
                    '@type' => 'Offer',
                    'name' => $plan->name,
                    'price' => $plan->price,
                    'priceCurrency' => $plan->currency,
                ])
                ->values()
                ->all(),
        ]);
    }

    /**
     * Home › section › current page, using the page titles from the CMS.
     *
     * @return array<string, mixed>
     */
    public static function breadcrumbs(string $sectionKey, string $sectionRouteName, string $title): array
    {
        $titles = Page::query()->whereIn('key', ['home', $sectionKey])->get()
            ->mapWithKeys(fn (Page $page): array => [$page->key => $page->title]);

        $items = [
            [$titles['home'] ?? SeoMeta::siteName(), Localization::route('home')],
            [$titles[$sectionKey] ?? $sectionKey, Localization::route($sectionRouteName)],
            [$title, url()->current()],
        ];

        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(fn (array $item, int $index): array => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item[0],
                'item' => $item[1],
            ], $items, array_keys($items)),
        ];
    }

    /**
     * Stable node identifier, shared by every page and locale.
     */
    protected static function id(string $fragment): string
    {
        return url('/').'#'.$fragment;
    }

    /**
     * @param  array<string, mixed>  $node
     * @return array<string, mixed>
     */
    protected static function withoutEmpty(array $node): array
    {
        return array_filter($node, fn (mixed $value): bool => filled($value));
    }
}
