@props(['type', 'entries'])

@php
    /** @var \App\Enums\ResumeEntryType $type */
    $icon = match ($type) {
        \App\Enums\ResumeEntryType::Work => 'ri-book-marked-line',
        \App\Enums\ResumeEntryType::Internship => 'ri-book-line',
        \App\Enums\ResumeEntryType::Education => 'ri-school-line',
        \App\Enums\ResumeEntryType::Achievement => 'ri-award-fill',
    };
@endphp

<div class="col-xl-6 col-md-12">
    <div class="experience-list">
        <div class="single-resume">
            <h2>{{ $type->label() }}</h2>
            @foreach ($entries as $entry)
                <div class="resume-item wow fadeInUp delay-0-3s">
                    <div class="icon">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <div class="content">
                        <span class="years">{{ $entry->period() }}</span>
                        @if ($type === \App\Enums\ResumeEntryType::Education || $type === \App\Enums\ResumeEntryType::Achievement)
                            <h3 class="h4">{{ $entry->title }}</h3>
                            <span class="company">{{ $entry->organization }}</span>
                        @else
                            <h3 class="h4">{{ $entry->organization }}</h3>
                            <span class="company">{{ $entry->title }}</span>
                        @endif
                        @if ($entry->description)
                            <p>{{ $entry->description }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
