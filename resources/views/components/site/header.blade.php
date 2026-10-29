@props(['alternates' => []])

@php
    use App\Support\Localization;

    $navigation = [
        'about' => 'about',
        'services.index' => 'services',
        'works.index' => 'works',
        'blog.index' => 'blog',
        'contact' => 'contact',
    ];
    $current = Localization::baseRouteName(request()->route());
@endphp

<header class="main-header">
    <div class="header-upper">
        <div class="container">
            <div class="header-inner d-flex align-items-center">
                <div class="logo-outer">
                    <div class="logo">
                        <a href="{{ localized_route('home') }}" wire:navigate>
                            <img src="{{ asset('images/logo.png') }}" alt="{{ $siteName }}" width="150" height="50" />
                        </a>
                    </div>
                </div>
                <div class="nav-outer clearfix mx-auto">
                    <nav class="main-menu navbar-expand-lg" aria-label="{{ __('Main navigation') }}">
                        <div class="navbar-header">
                            <div class="mobile-logo">
                                <a href="{{ localized_route('home') }}" wire:navigate>
                                    <img src="{{ asset('images/logo.png') }}" alt="{{ $siteName }}" width="150" height="50" />
                                </a>
                            </div>
                            <button type="button" class="navbar-toggle" aria-controls="main-navigation" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="navbar-collapse collapse" id="main-navigation">
                            <ul class="navigation clearfix">
                                @foreach ($navigation as $route => $pageKey)
                                    <li @class(['current' => $current !== null && str_starts_with($current, strtok($route, '.'))])>
                                        <a href="{{ localized_route($route) }}" wire:navigate.hover>{{ $navPages[$pageKey] ?? __(ucfirst($pageKey)) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="menu-btns d-flex align-items-center">
                    <div class="language-switcher" aria-label="{{ __('Language') }}">
                        @foreach (Localization::locales() as $locale)
                            <a href="{{ $alternates[$locale] ?? localized_route('home', [], $locale) }}"
                               hreflang="{{ $locale }}"
                               lang="{{ $locale }}"
                               @class(['active' => app()->getLocale() === $locale])
                               @if (app()->getLocale() === $locale) aria-current="true" @endif>{{ $locale }}</a>
                        @endforeach
                    </div>
                    <a href="{{ localized_route('contact') }}" class="theme-btn" wire:navigate>{{ __('Hire Me') }}<i class="ri-shake-hands-line"></i></a>
                </div>
            </div>
        </div>
    </div>
</header>
