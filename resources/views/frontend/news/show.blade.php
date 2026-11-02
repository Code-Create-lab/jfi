@extends('layouts.frontend')

@php
    $image = $item->image
        ? Storage::url($item->image)
        : asset('assets/images/jfi/cover-'.(abs(crc32((string) $item->slug)) % 6 + 1).'.webp');
@endphp

@section('title', $item->title)
@section('meta_description', $item->excerpt ?: $item->title.' - Jumpball Federation of India.')

@section('content')
<x-page-banner :crumbs="['News' => route('frontend.news.index')]" :title="$item->title">
<div class="d-flex flex-wrap align-items-center gap-3 mt-4">
<span @class(['jfi-badge', 'jfi-badge-gold' => $item->type === App\Enums\NewsType::Announcement])>{{ $item->type->label() }}</span>
<time class="text-white-50" datetime="{{ $item->published_on->toDateString() }}">{{ $item->published_on->format('j F Y') }}</time>
</div>
</x-page-banner>

<section class="page-section">
<div class="hero-container">
<div class="detail-layout">
<article>
<div class="detail-media"><img alt="" src="{{ $image }}"/></div>
@if ($item->excerpt)
<p class="section-lede mb-4">{{ $item->excerpt }}</p>
@endif
<div class="prose">{!! $item->content !!}</div>
<div class="mt-5 pt-4 border-top">
<a class="jfi-link" href="{{ route('frontend.news.index') }}"><i aria-hidden="true" class="fa-solid fa-arrow-left"></i> Back to all news</a>
</div>
</article>
<aside aria-label="More from the federation">
<div class="side-card">
<h2 class="side-card-title">Recent Updates</h2>
<ul class="side-nav">
@foreach ($recentNews as $news)
<li><a href="{{ route('frontend.news.show', $news->slug) }}"><span>{{ $news->title }}<br/><small class="text-slate fw-normal">{{ $news->published_on->format('j M Y') }}</small></span></a></li>
@endforeach
</ul>
</div>
<div class="side-card">
<h2 class="side-card-title">Official Documents</h2>
<p class="mb-3">Circulars, notices and forms referred to in announcements.</p>
<a class="jfi-btn jfi-btn-outline jfi-btn-block" href="{{ route('frontend.downloads') }}">Downloads &amp; Notices</a>
</div>
</aside>
</div>
</div>
</section>
@endsection
