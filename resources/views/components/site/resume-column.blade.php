@props(['type', 'entries'])

@php
    /** @var \App\Enums\ResumeEntryType $type */
@endphp

<div class="col-xl-6 col-md-12">
    <div class="experience-list">
        <div class="single-resume">
            <h2>{{ $type->label() }}</h2>
            @foreach ($entries as $entry)
                <div class="resume-item wow fadeInUp delay-0-3s">
                    <div class="icon">
                        <i class="{{ $type->icon() }}"></i>
                    </div>
                    <div class="content">
                        <span class="years">{{ $entry->period() }}</span>
                        @if ($type->leadsWithTitle())
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
