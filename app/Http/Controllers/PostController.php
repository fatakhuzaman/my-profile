<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Support\SeoMeta;
use App\Support\StructuredData;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $page = Page::findByKey('blog');

        return view('posts.index', [
            'page' => $page,
            'seo' => SeoMeta::forPage($page, 'blog.index'),
            'posts' => Post::published()
                ->translatedIn()
                ->with('category')
                ->latestPublished()
                ->paginate(9),
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::published()->translatedIn()->whereSlug($slug)->with(['author', 'category', 'tags'])->firstOrFail();

        $seo = SeoMeta::forRecord($post, 'blog.show', $post->cover_image);
        $seo->withSchema(
            StructuredData::blogPosting($post, $seo),
            StructuredData::breadcrumbs('blog', 'blog.index', $post->title),
        );

        return view('posts.show', [
            'post' => $post,
            'seo' => $seo,
            'relatedPosts' => Post::published()
                ->translatedIn()
                ->with('category')
                ->whereKeyNot($post->getKey())
                ->when($post->category_id, fn ($query) => $query->where('category_id', $post->category_id))
                ->latestPublished()
                ->limit(3)
                ->get(),
        ]);
    }
}
