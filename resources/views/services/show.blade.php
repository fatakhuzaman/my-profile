<x-layouts.app :seo="$seo">
    <div class="single-project-page-design">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center pb-30">
                    <p><a href="{{ localized_route('services.index') }}" wire:navigate>{{ __('Services') }}</a></p>
                    <h1>{{ $service->title }}</h1>
                    @if ($service->excerpt)
                        <p class="lead">{{ $service->excerpt }}</p>
                    @endif
                </div>
            </div>
        </div>
        @if ($service->image)
            <div class="single-project-image">
                <img src="{{ media_url($service->image) }}" alt="{{ $service->title }}" fetchpriority="high">
            </div>
        @endif
        <div class="container pt-30">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-project-page-right rich-content">
                        {{ rich_content($service->body) }}
                    </div>
                    <div class="hero-btns pt-30">
                        <a href="{{ localized_route('contact', ['service' => $service->id]) }}" class="theme-btn" wire:navigate>{{ __('Discuss your project') }} <i class="ri-message-2-line"></i></a>
                    </div>
                </div>
                @if ($otherServices->isNotEmpty())
                    <div class="col-lg-4">
                        <div class="single-project-page-left">
                            <h2 class="h4">{{ __('Other services') }}</h2>
                            <ul class="list-unstyled">
                                @foreach ($otherServices as $other)
                                    <li class="mb-2"><a href="{{ localized_route('services.show', ['slug' => $other->slug]) }}" wire:navigate>{{ $other->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if ($plans->isNotEmpty())
        <section class="pricing-area">
            <div class="container">
                <div class="row justify-content-center">
                    @foreach ($plans as $plan)
                        <x-site.pricing-card :plan="$plan" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
