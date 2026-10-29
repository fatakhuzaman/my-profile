<x-layouts.app :seo="$seo">
    <section id="service" class="services-area innerpage-single-area">
        <div class="container">
            <div class="container-inner">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <x-site.section-title level="h1" :label="$page?->section('services.label')" :heading="$page?->section('services.heading')" />
                    </div>
                </div>
                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-lg-4 col-md-6">
                            <div class="service-item wow fadeInUp delay-0-{{ ($loop->index % 3) * 2 + 2 }}s">
                                <i class="{{ $service->icon ?: 'ri-code-s-slash-line' }}"></i>
                                <h2 class="h4">
                                    @if ($service->hasTranslation('slug', app()->getLocale()))
                                        <a href="{{ localized_route('services.show', ['slug' => $service->slug]) }}" wire:navigate>{{ $service->title }}</a>
                                    @else
                                        {{ $service->title }}
                                    @endif
                                </h2>
                                @if ($service->excerpt)
                                    <p>{{ $service->excerpt }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @if ($plans->isNotEmpty())
        <section id="pricing" class="pricing-area">
            <div class="container">
                <div class="container-inner">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <x-site.section-title :label="$page?->section('pricing.label')" :heading="$page?->section('pricing.heading')" />
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        @foreach ($plans as $plan)
                            <x-site.pricing-card :plan="$plan" />
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
