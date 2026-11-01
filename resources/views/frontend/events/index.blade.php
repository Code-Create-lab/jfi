@extends('layouts.frontend')

@php
    $events ??= (require resource_path('views/frontend/_preview-data.php'))[$period];
    $pageCopy = [
        'current' => ['Current Events', 'Championships and federation events taking place today.'],
        'upcoming' => ['Upcoming Events', 'Dates, venues and entry details for the national calendar.'],
        'previous' => ['Previous Events', 'Completed championships with results, photos and videos.'],
    ];
    [$title, $lede] = $pageCopy[$period];
@endphp

@section('title', $title)
@section('meta_description', $lede.' Jumpball Federation of India.')

@section('content')
<x-page-banner :crumbs="['Events' => route('frontend.events.upcoming')]" :subtitle="$lede" :title="$title"/>

<section class="page-section">
<div class="hero-container">
<div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
<nav aria-label="Event periods" class="flex-grow-1">
<ul class="jfi-tabs">
@foreach (['current' => 'Current', 'upcoming' => 'Upcoming', 'previous' => 'Previous'] as $key => $label)
<li><a @if ($period === $key) aria-current="page" @endif href="{{ route('frontend.events.'.$key) }}">{{ $label }}</a></li>
@endforeach
</ul>
</nav>
<a class="jfi-btn jfi-btn-outline mb-4" href="{{ route('frontend.results.index') }}"><i aria-hidden="true" class="fa-solid fa-trophy"></i> Championship Results</a>
</div>

@if ($events->isEmpty())
<x-empty-state icon="fa-regular fa-calendar" :title="match ($period) { 'current' => 'No events are running today', 'upcoming' => 'No upcoming events published yet', default => 'No completed events yet' }">
@if ($period === 'current')
See what is coming up next on the national calendar.
@else
Dates are published here and in the official circulars as soon as they are confirmed.
@endif
<x-slot:action>
<a class="jfi-btn jfi-btn-primary" href="{{ route($period === 'upcoming' ? 'frontend.downloads' : 'frontend.events.upcoming') }}">{{ $period === 'upcoming' ? 'View Circulars' : 'Upcoming Events' }}</a>
</x-slot:action>
</x-empty-state>
@else
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
@foreach ($events as $event)
<div class="col"><x-event-card :event="$event"/></div>
@endforeach
</div>
@endif
</div>
</section>

<x-register-cta/>
@endsection
