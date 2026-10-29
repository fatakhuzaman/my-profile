@props(['project'])

@php
    /** @var \App\Models\Project $project */
    $url = localized_route('works.show', ['slug' => $project->slug]);
@endphp

<div {{ $attributes->class(['col-lg-4 col-md-6 item']) }} data-categories="{{ $project->categories->map(fn ($category) => $category->getTranslation('slug', app()->getLocale()))->filter()->implode(' ') }}">
    <div class="project-item style-two wow fadeInUp delay-0-3s">
        <div class="project-image">
            @if ($project->cover_image)
                <img src="{{ media_url($project->cover_image) }}" alt="{{ $project->title }}" loading="lazy">
            @endif
            <a href="{{ $url }}" class="details-btn" wire:navigate aria-label="{{ $project->title }}"><i class="ri-arrow-right-up-line"></i></a>
        </div>
        <div class="project-content">
            @if ($project->categories->isNotEmpty())
                <span class="sub-title">{{ $project->categories->pluck('name')->implode(', ') }}</span>
            @endif
            <h3><a href="{{ $url }}" wire:navigate>{{ $project->title }}</a></h3>
        </div>
    </div>
</div>
