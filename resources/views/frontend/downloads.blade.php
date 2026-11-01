@extends('layouts.frontend')

@php
    $isRuleBook = ($mode ?? 'downloads') === 'rule-book';
    $activeCategory = $isRuleBook ? App\Enums\DownloadCategory::RuleBook : App\Enums\DownloadCategory::tryFrom((string) request('category'));
    $downloads ??= (require resource_path('views/frontend/_preview-data.php'))['downloads']
        ->when($activeCategory, fn ($items) => $items->where('category', $activeCategory));
    $title = $isRuleBook ? 'Rule Book' : 'Downloads & Official Notices';
    $currentRuleBook = $isRuleBook ? $downloads->first() : null;
    $listed = $isRuleBook ? $downloads->slice(1) : $downloads;
    $fileUrl = fn ($download) => Storage::url($download->file_path);
@endphp

@section('title', $title)
@section('meta_description', $isRuleBook
    ? 'Official Jumpball rule book published by the Jumpball Federation of India.'
    : 'Circulars, notices, forms and official documents from the Jumpball Federation of India.')

@section('content')
<x-page-banner :crumbs="['Media' => route('frontend.news.index')]" :subtitle="$isRuleBook ? 'The official rules of Jumpball. Matches sanctioned by the federation are played under the current edition.' : 'Circulars, notices, forms and official documents issued by the federation office.'" :title="$title"/>

<section class="page-section">
<div class="hero-container">
@if ($isRuleBook)
@if ($currentRuleBook)
<article class="featured-download mb-5 animate-box animate__animated" data-animate="animate__fadeInUp">
<span aria-hidden="true" class="file-icon">{{ $currentRuleBook->fileExtension() }}</span>
<div>
<span class="jfi-badge jfi-badge-gold">Current edition</span>
<h2>{{ $currentRuleBook->title }}</h2>
<p>{{ $currentRuleBook->description }} @if ($currentRuleBook->published_on) Published {{ $currentRuleBook->published_on->format('j F Y') }}. @endif</p>
<div class="d-flex flex-wrap gap-3">
<a class="jfi-btn jfi-btn-gold" download href="{{ $fileUrl($currentRuleBook) }}"><i aria-hidden="true" class="fa-solid fa-download"></i> Download {{ $currentRuleBook->fileExtension() }}</a>
<a class="jfi-btn jfi-btn-ghost-light" href="{{ $fileUrl($currentRuleBook) }}" rel="noopener" target="_blank">Read Online</a>
</div>
</div>
</article>
@else
<x-empty-state class="mb-5" icon="fa-solid fa-book-open" title="Rule book coming soon">
The federation office will publish the official rule book here.
</x-empty-state>
@endif
@if ($listed->isNotEmpty())
<h2 class="title-plain fs-4 mb-3">Previous Editions</h2>
@endif
@else
<nav aria-label="Filter documents by category">
<ul class="jfi-tabs">
<li><a @if (! $activeCategory) aria-current="page" @endif href="{{ route('frontend.downloads') }}">All</a></li>
@foreach (App\Enums\DownloadCategory::cases() as $category)
<li><a @if ($activeCategory === $category) aria-current="page" @endif href="{{ $category === App\Enums\DownloadCategory::RuleBook ? route('frontend.rule-book') : route('frontend.downloads', ['category' => $category->value]) }}">{{ $category === App\Enums\DownloadCategory::RuleBook ? 'Rule Book' : Str::plural($category->label()) }}</a></li>
@endforeach
</ul>
</nav>
@endif

@if ($listed->isNotEmpty())
<ul class="download-list">
@foreach ($listed as $download)
<li class="download-item">
<span aria-hidden="true" class="file-icon">{{ $download->fileExtension() }}</span>
<div>
<h3 class="download-title">{{ $download->title }}</h3>
@if ($download->description)
<p>{{ $download->description }}</p>
@endif
<div class="meta-inline">
<span class="jfi-badge">{{ $download->category->label() }}</span>
@if ($download->published_on)
<span>Published <time datetime="{{ $download->published_on->toDateString() }}">{{ $download->published_on->format('j M Y') }}</time></span>
@endif
</div>
</div>
<a class="jfi-btn jfi-btn-outline" download href="{{ $fileUrl($download) }}"><i aria-hidden="true" class="fa-solid fa-download"></i> Download<span class="visually-hidden"> {{ $download->title }} ({{ $download->fileExtension() }})</span></a>
</li>
@endforeach
</ul>
@elseif (! $isRuleBook)
<x-empty-state icon="fa-regular fa-file-lines" title="No documents in this category yet">
New circulars and notices are published here as soon as they are issued.
</x-empty-state>
@endif
</div>
</section>
@endsection
