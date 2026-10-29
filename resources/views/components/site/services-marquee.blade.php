@props(['services'])

@if ($services->isNotEmpty())
    <div class="about-content-part-bottom wow fadeInUp delay-0-2s">
        <div class="company-list">
            <div class="scroller" data-direction="left" data-speed="slow">
                <div class="scroller__inner">
                    @foreach ($services as $service)
                        @if ($service->hasTranslation('slug', app()->getLocale()))
                            <a href="{{ localized_route('services.show', ['slug' => $service->slug]) }}" wire:navigate><h4>{{ $service->title }}</h4></a>
                        @else
                            <h4>{{ $service->title }}</h4>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
