<x-layouts.app :seo="$seo">
    <article class="single-project-page-design">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center pb-30">
                    <p>
                        <a href="{{ localized_route('blog.index') }}" wire:navigate>Blog</a>
                        @if ($post->category)
                            &ndash; {{ $post->category->name }}
                        @endif
                    </p>
                    <h1>{{ $post->title }}</h1>
                    <div class="blog-post-meta justify-content-center pt-10">
                        <time datetime="{{ $post->published_at->toAtomString() }}">{{ $post->published_at->translatedFormat('d F Y') }}</time>
                        @if ($post->author)
                            <span>{{ $post->author->name }}</span>
                        @endif
                        <span>{{ trans_choice(':count min read|:count min read', $post->readingTime(), ['count' => $post->readingTime()]) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @if ($post->cover_image)
            <div class="single-project-image">
                <img src="{{ media_url($post->cover_image) }}" alt="{{ $post->title }}" fetchpriority="high">
            </div>
        @endif
        <div class="container pt-30">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="single-project-page-right rich-content">
                        {{ rich_content($post->body) }}
                    </div>
                    @if ($post->tags->isNotEmpty())
                        <p class="pt-30">
                            <strong>{{ __('Tags') }}:</strong>
                            {{ $post->tags->pluck('name')->implode(', ') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </article>

    @if ($relatedPosts->isNotEmpty())
        <section class="blog-area pt-50">
            <div class="container">
                <x-site.section-title :heading="__('Related Articles')" />
                @foreach ($relatedPosts as $related)
                    <x-site.post-card :post="$related" />
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.app>
