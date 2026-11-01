@extends('layouts.blank')

@section('title', 'Page Not Found')

@section('content')
<div class="section-wrapper">
<section class="page-banner error-banner" aria-labelledby="error-title">
<div class="hero-container">
<a class="error-logo" href="{{ route('frontend.home') }}">
<img alt="Jumpball Federation of India - home" height="72" src="{{ asset('assets/images/jfi-logo.png') }}" width="97"/>
</a>
<p class="error-code" aria-hidden="true">404</p>
<h1 class="page-banner-title" id="error-title">Page Not Found</h1>
<p class="page-banner-lede">The page you are looking for has moved or no longer exists. Try one of the links below or return to the home page.</p>
<div class="d-flex flex-wrap gap-3 mt-4">
<a class="jfi-btn jfi-btn-gold" href="{{ route('frontend.home') }}">Return to Home</a>
<a class="jfi-btn jfi-btn-ghost-light" href="{{ route('frontend.contact') }}">Contact the Federation</a>
</div>
<ul class="error-links">
<li><a href="{{ route('frontend.events.upcoming') }}">Upcoming Events</a></li>
<li><a href="{{ route('frontend.results.index') }}">Championship Results</a></li>
<li><a href="{{ route('frontend.players.index') }}">Player Database</a></li>
<li><a href="{{ route('frontend.downloads') }}">Downloads &amp; Notices</a></li>
</ul>
</div>
</section>
</div>
@endsection
