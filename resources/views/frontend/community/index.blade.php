@extends('layouts.frontend')

@php
    $categories ??= (require resource_path('views/frontend/_preview-data.php'))['categories'];
@endphp

@section('title', 'Community & Awareness')
@section('meta_description', 'Player safety, respectful conduct and awareness information from the Jumpball Federation of India.')

@section('content')
<x-page-banner subtitle="Information on player safety, respectful conduct and the people to contact if you need help." title="Community & Awareness"/>

<section class="page-section">
<div class="hero-container">
<div class="info-note mb-5">
<i aria-hidden="true" class="fa-solid fa-circle-info"></i>
<p>These pages are for information only. The federation does not accept complaints through this website. Each topic lists the right person or committee to contact directly.</p>
</div>

@if ($categories->isEmpty())
<x-empty-state icon="fa-solid fa-hands-holding-circle" title="Awareness topics coming soon">
The federation office is preparing this information.
</x-empty-state>
@else
<div class="row row-cols-1 row-cols-md-2 g-4">
@foreach ($categories as $category)
<div class="col">
<article class="awareness-card animate-box animate__animated" data-animate="animate__fadeInUp">
@if ($category->image)
<img alt="" class="awareness-image" height="300" loading="lazy" src="{{ Storage::url($category->image) }}" width="640"/>
@endif
<div class="card-body-jfi">
<span aria-hidden="true" class="awareness-icon"><i class="fa-solid fa-shield-halved"></i></span>
<h2 class="card-title-jfi fs-4"><a href="{{ route('frontend.community.show', $category->slug) }}">{{ $category->name }}</a></h2>
@if ($category->short_description)
<p>{{ $category->short_description }}</p>
@endif
<div class="card-footer-jfi d-flex flex-wrap justify-content-between align-items-center gap-2">
<span class="text-slate small">{{ $category->posts->count() }} {{ Str::plural('guide', $category->posts->count()) }}</span>
<a class="jfi-link" href="{{ route('frontend.community.show', $category->slug) }}">Read more<span class="visually-hidden">: {{ $category->name }}</span> <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</div>
</div>
</article>
</div>
@endforeach
</div>
@endif
</div>
</section>
@endsection
