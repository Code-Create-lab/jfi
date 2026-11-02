@extends('layouts.frontend')

@php
    $gallery ??= ((fn () => require resource_path('views/frontend/_preview-data.php'))())['galleries']->firstWhere('slug', $slug)
        ?? ((fn () => require resource_path('views/frontend/_preview-data.php'))())['galleries']->first();
@endphp

@section('title', $gallery->title.' - Photos')
@section('meta_description', 'Photos from '.$gallery->title.', Jumpball Federation of India.')

@section('content')
<x-page-banner :crumbs="['Photo Gallery' => route('frontend.gallery.index')]" :subtitle="$gallery->event ? $gallery->event->title.', '.$gallery->event->dateRange() : null" :title="$gallery->title"/>

<section class="page-section">
<div class="hero-container">
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
<p class="text-slate m-0">{{ $gallery->images->count() }} {{ Str::plural('photo', $gallery->images->count()) }}. Select a photo to open it full size.</p>
@if ($gallery->event)
<a class="jfi-link" href="{{ route('frontend.events.show', $gallery->event->slug) }}">Event page <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
@endif
</div>
<div class="photo-grid">
@foreach ($gallery->images as $image)
@php($src = Str::startsWith($image->image, 'assets/') ? asset($image->image) : Storage::url($image->image))
<figure>
<a href="{{ $src }}" rel="noopener" target="_blank">
<img alt="{{ $image->caption ?? $gallery->title.', photo '.$loop->iteration }}" height="480" loading="lazy" src="{{ $src }}" width="640"/>
</a>
@if ($image->caption)
<figcaption>{{ $image->caption }}</figcaption>
@endif
</figure>
@endforeach
</div>
<div class="mt-5 pt-4 border-top">
<a class="jfi-link" href="{{ route('frontend.gallery.index') }}"><i aria-hidden="true" class="fa-solid fa-arrow-left"></i> All albums</a>
</div>
</div>
</section>
@endsection
