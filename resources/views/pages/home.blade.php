@php
    use App\Models\Setting;
@endphp

<x-layouts.app :seo="$seo">
    <section id="about" class="about-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <x-site.profile-card />
                </div>
                <div class="col-lg-8">
                    <div class="about-content-part wow fadeInUp delay-0-2s">
                        <p>{{ $page?->section('hero.greeting') }}</p>
                        <h1>{{ $page?->section('hero.heading') }}</h1>
                        @if (Setting::get('person.available_for_work'))
                            <div class="adress-field">
                                <ul>
                                    <li><i class="ri-circle-fill"></i>{{ __('Available for Freelancing') }}</li>
                                </ul>
                            </div>
                        @endif
                        <div class="hero-btns">
                            @if ($cv = media_url(Setting::get('person.cv_file')))
                                <a href="{{ $cv }}" class="theme-btn" target="_blank" rel="noopener">{{ __('Download CV') }} <i class="ri-download-line"></i></a>
                            @endif
                        </div>
                    </div>
                    <x-site.services-marquee :services="$services" />
                </div>
            </div>
        </div>
    </section>

    @if ($clients->isNotEmpty())
        <div class="client-logo-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <x-site.section-title class="pt-5 mb-65" :label="$page?->section('clients.label')" :heading="$page?->section('clients.heading')" />
                    </div>
                </div>
                <div class="client-logo-wrap">
                    @foreach ($clients as $client)
                        @php($tag = $client->url ? 'a' : 'div')
                        <{{ $tag }} class="client-logo-item wow fadeInUp delay-0-{{ min($loop->iteration + 1, 9) }}s"
                            @if ($client->url) href="{{ $client->url }}" target="_blank" rel="noopener" @endif>
                            <img src="{{ media_url($client->logo) }}" alt="{{ $client->name }}" width="200" height="200" loading="lazy" />
                        </{{ $tag }}>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if ($projects->isNotEmpty())
        <section class="projects-area pt-100">
            <div class="container">
                <x-site.section-title :label="__('Portfolio')" :heading="__('Featured Projects')" />
                <div class="row project-masonry-active">
                    @foreach ($projects as $project)
                        <x-site.project-card :project="$project" />
                    @endforeach
                </div>
                <div class="text-center pt-30">
                    <a href="{{ localized_route('works.index') }}" class="theme-btn" wire:navigate>{{ __('See all projects') }} <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>
        </section>
    @endif

    @if ($posts->isNotEmpty())
        <section class="blog-area pt-100">
            <div class="container">
                <x-site.section-title label="Blog" :heading="__('Latest Articles')" />
                @foreach ($posts as $post)
                    <x-site.post-card :post="$post" />
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.app>
