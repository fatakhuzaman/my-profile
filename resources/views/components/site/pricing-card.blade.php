@props(['plan'])

@php
    /** @var \App\Models\PricingPlan $plan */
    $price = match (true) {
        $plan->price === null => null,
        $plan->currency === 'IDR' => 'Rp '.number_format((float) $plan->price, 0, ',', '.'),
        default => \Illuminate\Support\Number::currency((float) $plan->price, in: $plan->currency, locale: 'en', precision: 0),
    };
@endphp

<div class="col-lg-4 col-md-6">
    <div @class(['pricing-item wow fadeInUp delay-0-2s', 'highlighted' => $plan->is_highlighted])>
        <div class="pricing-header">
            <h3 class="title h4">{{ $plan->name }}</h3>
            @if ($plan->tagline)
                <p class="save-percent">{{ $plan->tagline }}</p>
            @endif
            @if ($price)
                <span class="price">{{ $price }}</span>
                <span class="price-suffix">{{ $plan->price_suffix ?: __('starting price') }}</span>
            @else
                <span class="price">{{ __('Contact me') }}</span>
            @endif
            @if ($plan->description)
                <p>{{ $plan->description }}</p>
            @endif
        </div>
        <div class="pricing-details">
            <ul>
                @foreach ($plan->features ?? [] as $feature)
                    <li><i class="ri-arrow-right-line"></i>{{ $feature }}</li>
                @endforeach
            </ul>
            <a href="{{ $plan->cta_url ?: localized_route('contact') }}" class="theme-btn" @unless ($plan->cta_url) wire:navigate @endunless>
                {{ $plan->cta_label ?: __('Order Now') }} <i class="ri-shopping-basket-line"></i>
            </a>
        </div>
    </div>
</div>
