@props(['label' => null, 'heading', 'level' => 'h2', 'text' => null])

<div {{ $attributes->class(['section-title text-center wow fadeInUp delay-0-2s']) }}>
    @if ($label)
        <p>{{ $label }}</p>
    @endif
    <{{ $level }}>{{ $heading }}</{{ $level }}>
    @if ($text)
        <p>{{ $text }}</p>
    @endif
</div>
