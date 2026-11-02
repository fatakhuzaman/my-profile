<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Support\SeoMeta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    /**
     * Fixed pages by their CMS key, with the route that serves them.
     *
     * @var array<string, string>
     */
    private const PAGES = [
        'home' => 'home',
        'about' => 'about',
        'services' => 'services.index',
        'works' => 'works.index',
        'blog' => 'blog.index',
        'contact' => 'contact',
    ];

    /**
     * Every indexable page, once per locale, each listing its translations.
     */
    public function __invoke(): Response
    {
        $pages = Page::query()->whereIn('key', array_keys(self::PAGES))->get()->keyBy('key');

        /** @var list<array{alternates: array<string, string>, lastmod: ?Carbon}> $entries */
        $entries = [];

        foreach (self::PAGES as $key => $routeName) {
            if ($pages->get($key)?->is_indexable === false) {
                continue;
            }

            $entries[] = [
                'alternates' => SeoMeta::staticAlternates($routeName),
                'lastmod' => $pages->get($key)?->updated_at,
            ];
        }

        $records = [
            'services.show' => Service::published()->ordered()->get(),
            'works.show' => Project::published()->latestPublished()->get(),
            'blog.show' => Post::published()->latestPublished()->get(),
        ];

        foreach ($records as $routeName => $models) {
            foreach ($models as $model) {
                /** @var Model $model */
                $entries[] = [
                    'alternates' => SeoMeta::recordAlternates($model, $routeName),
                    'lastmod' => $model->updated_at,
                ];
            }
        }

        return response()
            ->view('sitemap', ['entries' => $entries])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
