@extends('layouts.frontend')

@php
    $page ??= (require resource_path('views/frontend/_preview-data.php'))['pages'][$slug];
    $isLegal = in_array($page->slug, ['privacy-policy', 'terms-and-conditions'], true);
    $sectionLinks = $isLegal
        ? ['Privacy Policy' => 'frontend.legal.privacy', 'Terms & Conditions' => 'frontend.legal.terms']
        : [
            'About the Federation' => 'frontend.about.federation',
            'About Jumpball' => 'frontend.about.jumpball',
            "President's Message" => 'frontend.about.president',
            'National Office Bearers' => 'frontend.office-bearers.national',
            'State Office Bearers' => 'frontend.office-bearers.state',
        ];
@endphp

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: ($page->subtitle ?: $page->title.' - Jumpball Federation of India.'))

@section('content')
<x-page-banner :crumbs="$isLegal ? [] : ['About' => route('frontend.about.federation')]" :subtitle="$page->subtitle" :title="$page->title"/>

<section class="page-section">
<div class="hero-container">
<div class="detail-layout">
<div>
@if ($page->slug === 'president-message')
<figure class="d-flex align-items-center gap-4 mb-5">
<img alt="{{ $page->image ? 'Photo of the President' : '' }}" class="president-photo" height="168" src="{{ $page->image ? Storage::url($page->image) : asset('assets/images/jfi/person-placeholder.svg') }}" width="140"/>
<figcaption class="signature mt-0 pt-0 border-0">
<strong>President</strong>
<span>Jumpball Federation of India</span>
</figcaption>
</figure>
@elseif ($page->image)
<div class="detail-media"><img alt="" src="{{ Storage::url($page->image) }}"/></div>
@endif
<div class="prose">
{!! $page->content !!}
</div>
@if ($isLegal)
<p class="text-slate mt-5 mb-0">Last updated {{ $page->updated_at?->format('j M Y') ?? 'when published' }}.</p>
@endif
</div>
<aside aria-label="{{ $isLegal ? 'Legal pages' : 'About the federation' }}">
<div class="side-card">
<h2 class="side-card-title">{{ $isLegal ? 'Legal' : 'About' }}</h2>
<ul class="side-nav">
@foreach ($sectionLinks as $label => $routeName)
<li><a @if (request()->routeIs($routeName)) aria-current="page" @endif href="{{ route($routeName) }}">{{ $label }} <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a></li>
@endforeach
</ul>
</div>
<div class="side-card">
<h2 class="side-card-title">Questions?</h2>
<p class="mb-3">Write to the federation office and the right team will respond.</p>
<a class="jfi-btn jfi-btn-primary jfi-btn-block" href="{{ route('frontend.contact') }}">Contact the Federation</a>
</div>
</aside>
</div>
</div>
</section>
@endsection
