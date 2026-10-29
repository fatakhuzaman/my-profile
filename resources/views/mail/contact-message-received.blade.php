<x-mail::message>
# Pesan baru dari website

**Nama:** {{ $contactMessage->name }}<br>
**Email:** {{ $contactMessage->email }}<br>
@if ($contactMessage->phone)
**Telepon:** {{ $contactMessage->phone }}<br>
@endif
@if ($contactMessage->service)
**Layanan:** {{ $contactMessage->service->getTranslation('title', 'id') }}<br>
@endif
**Bahasa halaman:** {{ strtoupper((string) $contactMessage->locale) }}

<x-mail::panel>
{{ $contactMessage->message }}
</x-mail::panel>

<x-mail::button :url="\App\Filament\Resources\ContactMessages\ContactMessageResource::getUrl('view', ['record' => $contactMessage])">
Buka di CMS
</x-mail::button>

Balas email ini untuk langsung menjawab {{ $contactMessage->name }}.
</x-mail::message>
