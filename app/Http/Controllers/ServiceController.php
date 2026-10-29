<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Support\SeoMeta;
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

        return view('services.show', [
            'service' => $service,
            'seo' => SeoMeta::forRecord($service, 'services.show', $service->image, 'website'),
            'plans' => $service->pricingPlans()->published()->ordered()->get(),
            'otherServices' => Service::published()->translatedIn()->whereKeyNot($service->getKey())->ordered()->get(),
        ]);
    }
}
