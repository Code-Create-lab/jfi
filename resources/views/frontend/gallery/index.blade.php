@extends('layouts.frontend')

@php
    $galleries ??= ((fn () => require resource_path('views/frontend/_preview-data.php'))())['galleries'];
@endphp

@section('title', 'Photo Gallery')
@section('meta_description', 'Photos from Jumpball Federation of India championships and events.')

@section('content')
<x-page-banner :crumbs="['Media' => route('frontend.news.index')]" subtitle="Albums from national championships and federation events." title="Photo Gallery"/>

<section class="page-section">
<div class="hero-container">
@if ($galleries->isEmpty())
<x-empty-state icon="fa-regular fa-images" title="No albums yet">
Photos are added after each championship.
</x-empty-state>
@else
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
@foreach ($galleries as $gallery)
@php
    $firstImage = $gallery->images->first();
    $coverPath = $gallery->cover_image ?? $firstImage?->image;
    $cover = $coverPath
        ? (Str::startsWith($coverPath, 'assets/') ? asset($coverPath) : Storage::url($coverPath))
        : asset('assets/images/jfi/cover-'.(abs(crc32((string) $gallery->slug)) % 6 + 1).'.webp');
@endphp
<div class="col">
<a class="album-card animate-box animate__animated" data-animate="animate__fadeInUp" href="{{ route('frontend.gallery.show', $gallery->slug) }}">
<div class="album-card-media">
<img alt="" height="480" loading="lazy" src="{{ $cover }}" width="640"/>
<span class="album-card-count">{{ $gallery->images->count() }} {{ Str::plural('photo', $gallery->images->count()) }}</span>
</div>
<h2 class="card-title-jfi">{{ $gallery->title }}</h2>
<p class="album-card-meta">{{ $gallery->event ? $gallery->event->title.', '.$gallery->event->start_date->format('M Y') : 'Federation event' }}</p>
</a>
</div>
@endforeach
</div>
@endif
<div class="text-center mt-5">
<a class="jfi-btn jfi-btn-outline" href="{{ route('frontend.videos') }}"><i aria-hidden="true" class="fa-solid fa-play"></i> Video Gallery</a>
</div>
</div>
</section>
@endsection
