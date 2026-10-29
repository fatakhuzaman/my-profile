@props(['seo'])

@php
    /** @var \App\Support\SeoMeta $seo */
    $shareImage = $seo->shareImage();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seo->title }}</title>
    @if ($seo->description)
        <meta name="description" content="{{ $seo->description }}">
    @endif
    <meta name="robots" content="{{ $seo->indexable ? 'index, follow' : 'noindex, follow' }}">
    <link rel="canonical" href="{{ $seo->canonical() }}">
    @foreach ($seo->alternates as $locale => $url)
        <link rel="alternate" hreflang="{{ $locale }}" href="{{ $url }}">
    @endforeach
    @isset($seo->alternates[\App\Support\Localization::defaultLocale()])
        <link rel="alternate" hreflang="x-default" href="{{ $seo->alternates[\App\Support\Localization::defaultLocale()] }}">
    @endisset

    <meta property="og:type" content="{{ $seo->type }}">
    <meta property="og:site_name" content="{{ \App\Support\SeoMeta::siteName() }}">
    <meta property="og:title" content="{{ $seo->title }}">
    @if ($seo->description)
        <meta property="og:description" content="{{ $seo->description }}">
    @endif
    <meta property="og:url" content="{{ $seo->canonical() }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'id' ? 'id_ID' : 'en_US' }}">
    @if ($shareImage)
        <meta property="og:image" content="{{ $shareImage }}">
        <meta name="twitter:card" content="summary_large_image">
    @endif

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    {{ $head ?? '' }}
</head>

<body>
    <x-site.header :alternates="$seo->alternates" />

    <main id="main-content">
        {{ $slot }}
    </main>

    <x-site.footer />

    @livewireScripts
</body>

</html>
