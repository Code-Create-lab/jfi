@props([
    'title',
    'subtitle' => null,
    'crumbs' => [],
])

@php
    $photo = collect(config('jumpball.page_banners'))->first(fn (string $path, string $pattern): bool => request()->routeIs($pattern));
@endphp

{{-- Inner page header. $crumbs lists parent pages as label => url; the current page is appended automatically.
     The background photo comes from config('jumpball.page_banners'), matched on the route name. --}}
<div class="section-wrapper pb-0">
<section @class(['page-banner', 'has-photo' => $photo]) aria-labelledby="page-title" @if ($photo) style="--banner-photo: url('{{ asset($photo) }}')" @endif>
<div class="hero-container animate-box animate__animated" data-animate="animate__fadeInUp">
<nav aria-label="Breadcrumb">
<ol class="page-breadcrumb">
<li><a href="{{ route('frontend.home') }}">Home</a></li>
@foreach ($crumbs as $label => $url)
<li><a href="{{ $url }}">{{ $label }}</a></li>
@endforeach
<li><span aria-current="page">{{ $title }}</span></li>
</ol>
</nav>
<h1 class="page-banner-title" id="page-title">{{ $title }}</h1>
@if ($subtitle)
<p class="page-banner-lede">{{ $subtitle }}</p>
@endif
{{ $slot }}
</div>
</section>
</div>
