<?php

namespace App\Http\Controllers;

use App\Enums\ResumeEntryType;
use App\Models\Client;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\ResumeEntry;
use App\Models\Service;
use App\Models\Skill;
use App\Support\SeoMeta;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $page = Page::findByKey('home');

        return view('pages.home', [
            'page' => $page,
            'seo' => SeoMeta::forPage($page, 'home'),
            'services' => Service::published()->ordered()->get(),
            'clients' => Client::published()->ordered()->get(),
            'projects' => Project::published()->translatedIn()->where('is_featured', true)
                ->with('categories')->latestPublished()->limit(3)->get(),
            'posts' => Post::published()->translatedIn()->with('category')->latestPublished()->limit(3)->get(),
        ]);
    }

    public function about(): View
    {
        $page = Page::findByKey('about');

        return view('pages.about', [
            'page' => $page,
            'seo' => SeoMeta::forPage($page, 'about'),
            'services' => Service::published()->ordered()->get(),
            'resume' => ResumeEntry::published()->ordered()->get()->groupBy(fn (ResumeEntry $entry): string => $entry->type->value),
            'resumeTypes' => ResumeEntryType::cases(),
            'skills' => Skill::published()->ordered()->get(),
        ]);
    }

    public function contact(): View
    {
        $page = Page::findByKey('contact');

        return view('pages.contact', [
            'page' => $page,
            'seo' => SeoMeta::forPage($page, 'contact'),
            'services' => Service::published()->ordered()->get(),
        ]);
    }
}
