@props(['post'])

@php
    /** @var \App\Models\Post $post */
    $url = localized_route('blog.show', ['slug' => $post->slug]);
@endphp

<article class="row blog-post-box align-items-center">
    <div class="col-lg-6">
        <div class="blog-post-img">
            <a href="{{ $url }}" wire:navigate>
                @if ($post->cover_image)
                    <img src="{{ media_url($post->cover_image) }}" alt="{{ $post->title }}" loading="lazy">
                @endif
            </a>
            @if ($post->category)
                <div class="blog-post-category">
                    <span>{{ $post->category->name }}</span>
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="blog-post-caption">
            <h3><time datetime="{{ $post->published_at->toAtomString() }}">{{ $post->published_at->translatedFormat('d F Y') }}</time></h3>
            <h2><a class="link-decoration" href="{{ $url }}" wire:navigate>{{ $post->title }}</a></h2>
            @if ($post->excerpt)
                <p>{{ $post->excerpt }}</p>
            @endif
            <a class="theme-btn theme-btn-two" href="{{ $url }}" wire:navigate>{{ __('Read more') }} <i class="ri-arrow-right-line"></i></a>
        </div>
    </div>
</article>
