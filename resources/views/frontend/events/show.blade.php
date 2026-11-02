@extends('layouts.frontend')

@php
    $period = $event->period();
    $cover = $event->cover_image
        ? Storage::url($event->cover_image)
        : asset('assets/images/jfi/cover-'.(abs(crc32((string) $event->slug)) % 6 + 1).'.webp');
@endphp

@section('title', $event->title)
@section('meta_description', $event->summary ?: $event->title.', '.$event->dateRange().'. Jumpball Federation of India.')

@section('content')
<x-page-banner :crumbs="['Events' => route('frontend.events.'.$period)]" :subtitle="$event->summary" :title="$event->title">
<div class="d-flex flex-wrap gap-2 mt-4">
<span @class(['jfi-badge', 'jfi-badge-green' => $period === 'current', 'jfi-badge-gold' => $period === 'upcoming'])>{{ match ($period) { 'current' => 'Happening now', 'upcoming' => 'Upcoming', default => 'Completed' } }}</span>
<span class="jfi-badge"><i aria-hidden="true" class="fa-regular fa-calendar"></i> {{ $event->dateRange() }}</span>
</div>
</x-page-banner>

<section class="page-section">
<div class="hero-container">
<div class="detail-layout">
<div>
<div class="detail-media"><img alt="" src="{{ $cover }}"/></div>
@if ($event->description)
<div class="prose mb-5">{!! $event->description !!}</div>
@endif

@if ($event->results->isNotEmpty())
<section aria-labelledby="results-title" class="mb-5">
<h2 class="mb-4" id="results-title">Results</h2>
@foreach ($event->results->groupBy('category') as $category => $results)
<h3 class="category-heading">{{ $category ?: 'Overall' }}</h3>
<x-results-table :caption="$event->title.' - '.($category ?: 'Overall')" :results="$results" class="mb-4"/>
@endforeach
</section>
@endif

@if ($galleries->isNotEmpty())
<section aria-labelledby="photos-title" class="mb-5">
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
<h2 class="m-0" id="photos-title">Photos</h2>
<a class="jfi-link" href="{{ route('frontend.gallery.show', $galleries->first()->slug) }}">Open album <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</div>
<div class="photo-grid">
@foreach ($galleries->first()->images->take(4) as $image)
<figure>
<a href="{{ route('frontend.gallery.show', $galleries->first()->slug) }}">
<img alt="{{ $image->caption ?? $event->title }}" loading="lazy" src="{{ Str::startsWith($image->image, 'assets/') ? asset($image->image) : Storage::url($image->image) }}"/>
</a>
</figure>
@endforeach
</div>
</section>
@endif

@if ($videos->isNotEmpty())
<section aria-labelledby="videos-title">
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
<h2 class="m-0" id="videos-title">Videos</h2>
<a class="jfi-link" href="{{ route('frontend.videos') }}">Video gallery <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</div>
<ul class="side-nav">
@foreach ($videos as $video)
<li><a href="{{ route('frontend.videos') }}">{{ $video->title }} <i aria-hidden="true" class="fa-solid fa-play"></i></a></li>
@endforeach
</ul>
</section>
@endif
</div>

<aside aria-label="Event details">
<div class="side-card">
<h2 class="side-card-title">Event Details</h2>
<dl class="key-facts">
<div><dt>Dates</dt><dd>{{ $event->dateRange() }}</dd></div>
<div><dt>Venue</dt><dd>{{ $event->venue ?: 'To be announced' }}</dd></div>
<div><dt>Location</dt><dd>{{ collect([$event->city, $event->state])->filter()->join(', ') ?: 'To be announced' }}</dd></div>
<div><dt>Entries</dt><dd>Through affiliated state associations</dd></div>
</dl>
</div>
<div class="side-card">
<h2 class="side-card-title">Related</h2>
<ul class="side-nav">
@if ($period === 'previous')
<li><a href="{{ route('frontend.results.index') }}">All championship results <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a></li>
<li><a href="{{ route('frontend.certificates.index') }}">Find my certificate <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a></li>
@else
<li><a href="{{ route('frontend.downloads', ['category' => 'circular']) }}">Championship circulars <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a></li>
<li><a href="{{ route('frontend.players.register') }}">Register as a player <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a></li>
@endif
<li><a href="{{ route('frontend.rule-book') }}">Official rule book <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a></li>
</ul>
</div>
</aside>
</div>
</div>
</section>
@endsection
