@php
    use App\Models\Setting;

    $email = Setting::get('contact.email');
    $phone = Setting::get('contact.phone');
    $whatsapp = Setting::get('contact.whatsapp');
    $address = Setting::localized('contact.address');
    $mapUrl = Setting::get('contact.map_url');
@endphp

<x-layouts.app :seo="$seo">
    <section id="contact" class="contact-area innerpage-single-area">
        <div class="container">
            <div class="container-inner">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <x-site.section-title level="h1" :label="$page?->section('header.label')" :heading="$page?->section('header.heading')" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="status">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-content-part wow fadeInUp delay-0-2s">
                            @if ($address)
                                <div class="single-contact">
                                    <div class="contact-icon"><i class="ri-map-pin-line"></i></div>
                                    <h2>{{ __('Location') }}:</h2>
                                    @if ($mapUrl)
                                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener"><p>{{ $address }}</p></a>
                                    @else
                                        <p>{{ $address }}</p>
                                    @endif
                                </div>
                            @endif
                            @if ($phone)
                                <div class="single-contact">
                                    <div class="contact-icon"><i class="ri-whatsapp-line"></i></div>
                                    <h2>{{ __('Phone / WhatsApp') }}:</h2>
                                    <a href="{{ $whatsapp ? 'https://wa.me/'.$whatsapp : 'tel:'.$phone }}" target="_blank" rel="noopener"><p>{{ $phone }}</p></a>
                                </div>
                            @endif
                            @if ($email)
                                <div class="single-contact">
                                    <div class="contact-icon"><i class="ri-mail-line"></i></div>
                                    <h2>{{ __('Email') }}:</h2>
                                    <a href="mailto:{{ $email }}"><p class="text-break">{{ $email }}</p></a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="contact-form contact-form-area wow fadeInUp delay-0-4s">
                            <form action="{{ localized_route('contact.store') }}" method="post" novalidate>
                                @csrf
                                <div class="hp-field" aria-hidden="true">
                                    <label for="website">Website</label>
                                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ $page?->section('form.name') }}</label>
                                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autocomplete="name" />
                                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{ $page?->section('form.email') }}</label>
                                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="email" />
                                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">{{ __('Phone / WhatsApp') }} <small>({{ __('optional') }})</small></label>
                                            <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" autocomplete="tel" />
                                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="service_id">{{ __('Service you need') }} <small>({{ __('optional') }})</small></label>
                                            <select id="service_id" name="service_id" class="form-control">
                                                <option value="">-</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" @selected((int) old('service_id', request('service')) === $service->id)>{{ $service->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('service_id') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message">{{ $page?->section('form.message') }}</label>
                                            <textarea name="message" id="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                                            @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-0">
                                            <button type="submit" class="theme-btn">
                                                {{ $page?->section('form.submit') }} <i class="ri-mail-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
