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
                        <p>{{ $page?->section('intro.greeting') }}</p>
                        <h1>{{ $page?->section('intro.heading') }}</h1>
                        @foreach (preg_split('/\R{2,}/', (string) $page?->section('intro.body')) as $paragraph)
                            @if (filled($paragraph))
                                <p>{{ $paragraph }}</p>
                            @endif
                        @endforeach
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

    @foreach (collect($resumeTypes)->chunk(2) as $pair)
        @continue($pair->every(fn ($type) => $resume->get($type->value, collect())->isEmpty()))
        <section class="resume-area">
            <div class="container">
                <div class="resume-items">
                    <div class="row">
                        @foreach ($pair as $type)
                            @if ($resume->has($type->value))
                                <x-site.resume-column :type="$type" :entries="$resume[$type->value]" />
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endforeach

    @if ($skills->isNotEmpty())
        <section id="skills" class="skill-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-12 col-lg-12">
                        <x-site.section-title class="mb-60" :label="$page?->section('skills.label')" :heading="$page?->section('skills.heading')" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="skill-items-wrap">
                            <div class="row">
                                @foreach ($skills as $skill)
                                    <div class="col-lg-3 col-sm-6 col-xs-12">
                                        <div class="skill-item wow fadeInUp delay-0-{{ ($loop->index % 4) + 2 }}s">
                                            @if ($skill->icon)
                                                <img src="{{ media_url($skill->icon) }}" alt="{{ $skill->name }}" width="55" height="55" loading="lazy" />
                                            @endif
                                            <h3 class="h5">{{ $skill->name }}</h3>
                                            @if ($skill->proficiency !== null)
                                                <span class="percent">{{ $skill->proficiency }}%</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
