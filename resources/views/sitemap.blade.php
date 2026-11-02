{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach ($entries as $entry)
@foreach ($entry['alternates'] as $url)
    <url>
        <loc>{{ $url }}</loc>
@if ($entry['lastmod'])
        <lastmod>{{ $entry['lastmod']->toAtomString() }}</lastmod>
@endif
@if (count($entry['alternates']) > 1)
@foreach ($entry['alternates'] as $locale => $alternate)
        <xhtml:link rel="alternate" hreflang="{{ $locale }}" href="{{ $alternate }}" />
@endforeach
@isset($entry['alternates'][\App\Support\Localization::defaultLocale()])
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $entry['alternates'][\App\Support\Localization::defaultLocale()] }}" />
@endisset
@endif
    </url>
@endforeach
@endforeach
</urlset>
