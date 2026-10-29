<x-layouts.app :seo="$seo">
    <section id="blog" class="blog-area innerpage-single-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <x-site.section-title level="h1" :heading="$page?->section('header.heading') ?: 'Blog'" />
                </div>
            </div>

            @forelse ($posts as $post)
                <x-site.post-card :post="$post" />
            @empty
                <p class="text-center">{{ $page?->section('header.empty') }}</p>
            @endforelse

            @if ($posts->hasPages())
                <div class="pt-30">
                    {{ $posts->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
