<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Support\SeoMeta;
use App\Support\StructuredData;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $page = Page::findByKey('works');

        $projects = Project::published()
            ->translatedIn()
            ->with('categories')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latestPublished()
            ->get();

        return view('projects.index', [
            'page' => $page,
            'seo' => SeoMeta::forPage($page, 'works.index'),
            'projects' => $projects,
            'categories' => ProjectCategory::translatedIn()
                ->whereHas('projects', fn ($query) => $query->published())
                ->ordered()
                ->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $project = Project::published()->translatedIn()->whereSlug($slug)->with('categories')->firstOrFail();

        $seo = SeoMeta::forRecord($project, 'works.show', $project->cover_image);
        $seo->withSchema(
            StructuredData::creativeWork($project, $seo),
            StructuredData::breadcrumbs('works', 'works.index', $project->title),
        );

        return view('projects.show', [
            'project' => $project,
            'seo' => $seo,
        ]);
    }
}
