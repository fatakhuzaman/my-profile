@php
    use App\Models\Setting;
@endphp

<section class="call-to-action-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="call-to-action-part wow fadeInUp delay-0-2s text-center">
                    <h2>{{ Setting::localized('footer.cta_heading') }}</h2>
                    <p>{{ Setting::localized('footer.cta_text') }}</p>
                    <div class="hero-btns">
                        <a href="{{ localized_route('contact') }}" class="theme-btn" wire:navigate>{{ __("Let's Talk") }} <i class="ri-message-2-line"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="main-footer">
    <div class="footer-bottom pt-50 pb-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="copyright-text">
                        <p>&copy; {{ now()->year }} <a href="{{ localized_route('home') }}" wire:navigate>{{ $siteName }}</a>. {{ __('All rights reserved.') }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="copyright-text extra-copyright">
                        <p>
                            @foreach ($navPages as $key => $title)
                                @continue(! in_array($key, ['about', 'services', 'works', 'blog', 'contact'], true))
                                <a href="{{ localized_route(in_array($key, ['about', 'contact'], true) ? $key : $key.'.index') }}" wire:navigate class="me-3">{{ $title }}</a>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<a href="#main-content" class="progress-wrap cursor-pointer" aria-label="{{ __('Back to top') }}">
    <i class="ri-arrow-up-double-line"></i>
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102" aria-hidden="true">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</a>
