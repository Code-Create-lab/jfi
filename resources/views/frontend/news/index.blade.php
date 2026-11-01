@extends('layouts.frontend')

@php
    $activeType = App\Enums\NewsType::tryFrom((string) request('type'));
    $news ??= (require resource_path('views/frontend/_preview-data.php'))['news']
        ->when($activeType, fn ($items) => $items->where('type', $activeType));
@endphp

@section('title', 'News & Press Releases')
@section('meta_description', 'News, press releases and announcements from the Jumpball Federation of India.')

@section('content')
<x-page-banner :crumbs="['Media' => route('frontend.news.index')]" subtitle="Announcements, press releases and updates from the federation office." title="News & Press Releases"/>

<section class="page-section">
<div class="hero-container">
<nav aria-label="Filter news by type">
<ul class="jfi-tabs">
<li><a @if (! $activeType) aria-current="page" @endif href="{{ route('frontend.news.index') }}">All</a></li>
@foreach (App\Enums\NewsType::cases() as $type)
<li><a @if ($activeType === $type) aria-current="page" @endif href="{{ route('frontend.news.index', ['type' => $type->value]) }}">{{ Str::plural($type->label()) }}</a></li>
@endforeach
</ul>
</nav>

@if ($news->isEmpty())
<x-empty-state icon="fa-regular fa-newspaper" title="Nothing published here yet">
Check back soon, or see all news from the federation.
<x-slot:action>
<a class="jfi-btn jfi-btn-primary" href="{{ route('frontend.news.index') }}">All News</a>
</x-slot:action>
</x-empty-state>
@else
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
@foreach ($news as $item)
<div class="col"><x-news-card :item="$item"/></div>
@endforeach
</div>
<nav aria-label="News pages">
<ul class="jfi-pagination">
<li><span aria-disabled="true">Previous</span></li>
<li><span aria-current="page">1</span></li>
<li><a href="{{ route('frontend.news.index', ['page' => 2]) }}">2</a></li>
<li><a href="{{ route('frontend.news.index', ['page' => 2]) }}">Next</a></li>
</ul>
</nav>
@endif
</div>
</section>
@endsection
