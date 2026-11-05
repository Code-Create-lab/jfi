{{--
    Shared error page in the site style. Uses the blank layout (no database
    or settings), so it also works for 500 and 503.
    Variables: $code, $title, $message, $links (bool, default true).
--}}
@extends('layouts.blank')

@section('title', $title)

@section('content')
<div class="section-wrapper">
<section class="page-banner error-banner" aria-labelledby="error-title">
<div class="hero-container">
<a class="error-logo" href="{{ url('/') }}">
<img alt="Jumpball Federation of India - home" height="72" src="{{ asset('assets/images/jfi-logo.png') }}" width="97"/>
</a>
<p class="error-code" aria-hidden="true">{{ $code }}</p>
<h1 class="page-banner-title" id="error-title">{{ $title }}</h1>
<p class="page-banner-lede">{{ $message }}</p>
<div class="d-flex flex-wrap gap-3 mt-4">
<a class="jfi-btn jfi-btn-gold" href="{{ url('/') }}">Return to Home</a>
@if ($links ?? true)
<a class="jfi-btn jfi-btn-ghost-light" href="{{ route('frontend.contact') }}">Contact the Federation</a>
@endif
</div>
@if ($links ?? true)
<ul class="error-links">
<li><a href="{{ route('frontend.events.upcoming') }}">Upcoming Events</a></li>
<li><a href="{{ route('frontend.results.index') }}">Championship Results</a></li>
<li><a href="{{ route('frontend.players.index') }}">Player Database</a></li>
<li><a href="{{ route('frontend.downloads') }}">Downloads &amp; Notices</a></li>
</ul>
@endif
</div>
</section>
</div>
@endsection
