@php
    use App\Models\Setting;

    $socials = array_filter([
        'ri-instagram-line' => ['Instagram', Setting::get('social.instagram')],
        'ri-whatsapp-line' => ['WhatsApp', Setting::get('contact.whatsapp') ? 'https://wa.me/'.Setting::get('contact.whatsapp') : null],
        'ri-linkedin-fill' => ['LinkedIn', Setting::get('social.linkedin')],
        'ri-github-line' => ['GitHub', Setting::get('social.github')],
    ], fn (array $social): bool => filled($social[1]));
    $photo = media_url(Setting::get('person.photo'));
@endphp

<div class="about-image-part wow fadeInUp delay-0-3s">
    @if ($photo)
        <div class="about-image-part2">
            <img src="{{ $photo }}" alt="{{ Setting::get('person.full_name') }}" width="1024" height="1024" fetchpriority="high" />
        </div>
    @endif
    <h2>{{ Setting::get('site.name') }}</h2>
    <p>{{ Setting::localized('person.headline') }}</p>
    @if ($socials !== [])
        <div class="about-social text-center">
            <ul>
                @foreach ($socials as $icon => [$label, $url])
                    <li><a href="{{ $url }}" target="_blank" rel="noopener me" aria-label="{{ $label }}"><i class="{{ $icon }}"></i></a></li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
