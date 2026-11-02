@extends('layouts.frontend')

@section('title', 'Video Gallery')
@section('meta_description', 'Videos from Jumpball Federation of India championships and events.')

@section('content')
<x-page-banner :crumbs="['Media' => route('frontend.news.index')]" subtitle="Match highlights and messages from the federation." title="Video Gallery"/>

<section class="page-section">
<div class="hero-container">
@if ($videos->isEmpty())
<x-empty-state icon="fa-solid fa-film" title="No videos yet">
Videos are added after each championship.
</x-empty-state>
@else
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
@foreach ($videos as $video)
@php($thumbnail = $video->thumbnail_url ?? asset('assets/images/jfi/cover-'.(abs(crc32((string) $video->title)) % 6 + 1).'.webp'))
<div class="col">
<article class="animate-box animate__animated" data-animate="animate__fadeInUp">
@if ($video->embed_url)
<button class="video-thumb" data-video-embed="{{ $video->embed_url }}" data-video-title="{{ $video->title }}" type="button">
<img alt="" height="360" loading="lazy" src="{{ $thumbnail }}" width="640"/>
<span aria-hidden="true" class="video-play"><i class="fa-solid fa-play"></i></span>
<span class="visually-hidden">Play video: {{ $video->title }}</span>
</button>
@else
<a class="video-thumb" href="{{ $video->url }}" rel="noopener" target="_blank">
<img alt="" height="360" loading="lazy" src="{{ $thumbnail }}" width="640"/>
<span aria-hidden="true" class="video-play"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
<span class="visually-hidden">Watch {{ $video->title }} (opens in a new tab)</span>
</a>
@endif
<h2 class="card-title-jfi mt-3">{{ $video->title }}</h2>
@if ($video->event)
<p class="album-card-meta">{{ $video->event->title }}</p>
@endif
</article>
</div>
@endforeach
</div>
{{ $videos->links() }}
@endif
<div class="text-center mt-5">
<a class="jfi-btn jfi-btn-outline" href="{{ route('frontend.gallery.index') }}"><i aria-hidden="true" class="fa-regular fa-images"></i> Photo Gallery</a>
</div>
</div>
</section>

<dialog aria-label="Video player" class="video-dialog" id="video-dialog">
<button aria-label="Close video" class="video-dialog-close" type="button"><i aria-hidden="true" class="fa-solid fa-xmark"></i></button>
<div class="video-dialog-frame"></div>
</dialog>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/jfi-video.js') }}"></script>
@endpush
