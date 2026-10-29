<x-layouts.app :seo="$seo">
    <article class="single-project-page-design">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center pb-30">
                    <p>
                        <a href="{{ localized_route('works.index') }}" wire:navigate>{{ __('Portfolio') }}</a>
                        @if ($project->categories->isNotEmpty())
                            &ndash; {{ $project->categories->pluck('name')->implode(', ') }}
                        @endif
                    </p>
                    <h1>{{ $project->title }}</h1>
                    @if ($project->excerpt)
                        <p class="lead">{{ $project->excerpt }}</p>
                    @endif
                </div>
            </div>
        </div>
        @if ($project->cover_image)
            <div class="single-project-image">
                <img src="{{ media_url($project->cover_image) }}" alt="{{ $project->title }}" fetchpriority="high">
            </div>
        @endif
        <div class="container pt-30">
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-project-page-left wow fadeInUp delay-0-2s">
                        @if ($project->year)
                            <div class="single-info">
                                <p>{{ __('Year') }}</p>
                                <h2 class="h3">{{ $project->year }}</h2>
                            </div>
                        @endif
                        @if ($project->client_name)
                            <div class="single-info">
                                <p>{{ __('Client') }}</p>
                                <h2 class="h3">{{ $project->client_name }}</h2>
                            </div>
                        @endif
                        @if ($project->role)
                            <div class="single-info">
                                <p>{{ __('Services') }}</p>
                                <h2 class="h3">{{ $project->role }}</h2>
                            </div>
                        @endif
                        @if ($project->project_url || $project->repository_url || $project->video_url)
                            <div class="single-info">
                                <p>{{ __('Links') }}</p>
                                @if ($project->project_url)
                                    <a href="{{ $project->project_url }}" target="_blank" rel="noopener" class="d-block">{{ __('Visit website') }} <i class="ri-external-link-line"></i></a>
                                @endif
                                @if ($project->repository_url)
                                    <a href="{{ $project->repository_url }}" target="_blank" rel="noopener" class="d-block">{{ __('Source code') }} <i class="ri-github-line"></i></a>
                                @endif
                                @if ($project->video_url)
                                    <a href="{{ $project->video_url }}" target="_blank" rel="noopener" class="d-block">{{ __('Watch video') }} <i class="ri-play-circle-line"></i></a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="single-project-page-right rich-content wow fadeInUp delay-0-4s">
                        {{ rich_content($project->body) }}
                    </div>
                </div>
            </div>
            @if (filled($project->gallery))
                <div class="row pt-30">
                    @foreach ($project->gallery as $image)
                        <div class="col-lg-6">
                            <div class="single-image wow fadeInUp delay-0-{{ ($loop->index % 4) * 2 + 2 }}s">
                                <img src="{{ media_url($image) }}" alt="{{ $project->title }} – {{ $loop->iteration }}" loading="lazy">
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </article>
</x-layouts.app>
