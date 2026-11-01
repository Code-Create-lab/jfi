@props([
    'title',
    'label' => null,
    'lede' => null,
    'center' => false,
    'id' => null,
])

<div {{ $attributes->class(['section-heading', 'section-heading-center' => $center, 'animate-box animate__animated'])->merge(['data-animate' => 'animate__fadeInUp']) }}>
@if ($label)
<div><span class="sub-heading"><span class="sub-heading-title">{{ $label }}</span></span></div>
@endif
<h2 @if ($id) id="{{ $id }}" @endif>{{ $title }}</h2>
@if ($lede)
<p class="section-lede">{{ $lede }}</p>
@endif
</div>
