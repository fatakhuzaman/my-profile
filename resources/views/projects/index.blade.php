<x-layouts.app :seo="$seo">
    <section id="works" class="projects-area innerpage-single-area">
        <div class="container">
            <div class="container-inner">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <x-site.section-title level="h1" :heading="$page?->section('header.heading')" :text="$page?->section('header.body')" />
                    </div>
                </div>
                @if ($projects->isEmpty())
                    <p class="text-center">{{ __('New projects will be published here soon.') }}</p>
                @else
                    @if ($categories->isNotEmpty())
                        <ul class="project-filter filter-btns-one justify-content-left pb-15 wow fadeInUp delay-0-2s">
                            <li data-filter="*" class="current" role="button" tabindex="0" aria-pressed="true">{{ $page?->section('header.show_all') ?: __('Show All') }}</li>
                            @foreach ($categories as $category)
                                <li data-filter="{{ $category->slug }}" role="button" tabindex="0" aria-pressed="false">{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="row project-masonry-active">
                        @foreach ($projects as $project)
                            <x-site.project-card :project="$project" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
