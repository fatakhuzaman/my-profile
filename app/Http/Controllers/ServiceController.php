<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Support\SeoMeta;
use App\Support\StructuredData;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $page = Page::findByKey('services');

        return view('services.index', [
            'page' => $page,
            'seo' => SeoMeta::forPage($page, 'services.index'),
            'services' => Service::published()->ordered()->get(),
            'plans' => PricingPlan::published()->ordered()->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $service = Service::published()->translatedIn()->whereSlug($slug)->firstOrFail();

        $plans = $service->pricingPlans()->published()->ordered()->get();

        $seo = SeoMeta::forRecord($service, 'services.show', $service->image, 'website');
        $seo->withSchema(
            StructuredData::service($service, $plans, $seo),
            StructuredData::breadcrumbs('services', 'services.index', $service->title),
        );

        return view('services.show', [
            'service' => $service,
            'seo' => $seo,
            'plans' => $plans,
            'otherServices' => Service::published()->translatedIn()->whereKeyNot($service->getKey())->ordered()->get(),
        ]);
    }
}
