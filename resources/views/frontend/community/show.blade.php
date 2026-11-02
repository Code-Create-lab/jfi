@extends('layouts.frontend')

@php
    $documents = $category->posts->whereNotNull('document_path');
@endphp

@section('title', $category->name)
@section('meta_description', $category->short_description ?: $category->name.' - Jumpball Federation of India.')

@section('content')
<x-page-banner :crumbs="['Awareness' => route('frontend.community.index')]" :subtitle="$category->short_description" :title="$category->name"/>

<section class="page-section">
<div class="hero-container">
<div class="detail-layout">
<div>
@if ($category->description)
<div class="prose mb-5">{!! $category->description !!}</div>
@endif

@if ($category->posts->isNotEmpty())
<h2 class="mb-4">Guidance</h2>
<div class="accordion accordion-jfi" id="guidance">
@foreach ($category->posts as $post)
<div class="accordion-item">
<h3 class="accordion-header m-0" id="guide-heading-{{ $loop->index }}">
<button aria-controls="guide-{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" @class(['accordion-button', 'collapsed' => ! $loop->first]) data-bs-target="#guide-{{ $loop->index }}" data-bs-toggle="collapse" type="button">{{ $post->title }}</button>
</h3>
<div aria-labelledby="guide-heading-{{ $loop->index }}" @class(['accordion-collapse collapse', 'show' => $loop->first]) id="guide-{{ $loop->index }}">
<div class="accordion-body">
<div class="prose">{!! $post->content !!}</div>
@if ($post->document_path)
<a class="jfi-btn jfi-btn-outline mt-2" download href="{{ Storage::url($post->document_path) }}"><i aria-hidden="true" class="fa-solid fa-download"></i> Download document</a>
@endif
</div>
</div>
</div>
@endforeach
</div>
@endif
</div>

<aside aria-label="Support contact">
<div class="support-box">
<h2>Need Help?</h2>
<p>Contact the people below directly. Conversations are handled by the federation, not through this website.</p>
@if ($category->support_contact)
<p class="mb-0 pre-line">{{ $category->support_contact }}</p>
@else
<p class="mb-0">Contact the <a href="{{ route('frontend.contact') }}">federation office</a>.</p>
@endif
</div>
@if ($documents->isNotEmpty())
<div class="side-card mt-4">
<h2 class="side-card-title">Documents</h2>
<ul class="side-nav">
@foreach ($documents as $document)
<li><a download href="{{ Storage::url($document->document_path) }}">{{ $document->title }} <i aria-hidden="true" class="fa-solid fa-download"></i></a></li>
@endforeach
</ul>
</div>
@endif
<div class="side-card mt-4">
<h2 class="side-card-title">Other Topics</h2>
<ul class="side-nav">
@foreach ($categories->reject(fn ($item) => $item->slug === $category->slug) as $other)
<li><a href="{{ route('frontend.community.show', $other->slug) }}">{{ $other->name }} <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a></li>
@endforeach
</ul>
</div>
</aside>
</div>
</div>
</section>
@endsection
