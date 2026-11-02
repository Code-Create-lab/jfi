@extends('layouts.frontend')

@php
    $views = [
        0 => ['All Results', 'frontend.results.index', 'Championship Results', 'Official results and standings from national championships, entered by the federation office.'],
        1 => ['Winners', 'frontend.results.winners', 'Winners', 'First-place finishers in every category of every national championship.'],
        2 => ['Runners-up', 'frontend.results.runners-up', 'Runners-up', 'Second-place finishers in every category of every national championship.'],
        3 => ['Third Place', 'frontend.results.third-place', 'Third Place', 'Third-place finishers in every category of every national championship.'],
    ];
    [, , $title, $lede] = $views[$position];
    $placements = $position > 0
        ? $events->flatMap(fn ($event) => $event->results->where('position', $position)->map(fn ($result) => ['event' => $event, 'result' => $result]))
        : collect();
@endphp

@section('title', $title)
@section('meta_description', $lede)

@section('content')
<x-page-banner :crumbs="$position > 0 ? ['Events' => route('frontend.events.upcoming'), 'Results' => route('frontend.results.index')] : ['Events' => route('frontend.events.upcoming')]" :subtitle="$lede" :title="$title"/>

<section class="page-section">
<div class="hero-container">
<nav aria-label="Result views">
<ul class="jfi-tabs">
@foreach ($views as $key => [$label, $routeName])
<li><a @if ($position === $key) aria-current="page" @endif href="{{ route($routeName) }}">{{ $label }}</a></li>
@endforeach
</ul>
</nav>

@if ($position === 0)
@forelse ($events as $event)
<article aria-labelledby="results-event-{{ $loop->index }}" class="results-block animate-box animate__animated" data-animate="animate__fadeInUp">
<header class="results-block-head">
<div>
<h2 class="title-plain" id="results-event-{{ $loop->index }}"><a href="{{ route('frontend.events.show', $event->slug) }}">{{ $event->title }}</a></h2>
<div class="meta-inline">
<span><i aria-hidden="true" class="fa-regular fa-calendar"></i> {{ $event->dateRange() }}</span>
<span><i aria-hidden="true" class="fa-solid fa-location-dot"></i> {{ collect([$event->city, $event->state])->filter()->join(', ') }}</span>
</div>
</div>
<a class="jfi-link" href="{{ route('frontend.events.show', $event->slug) }}">Event page <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</header>
@foreach ($event->results->groupBy('category') as $category => $results)
<div class="results-category">
<h3>{{ $category ?: 'Overall' }}</h3>
<x-results-table :caption="$event->title.' - '.($category ?: 'Overall')" :results="$results"/>
</div>
@endforeach
</article>
@empty
<x-empty-state icon="fa-solid fa-trophy" title="No results published yet">
Results appear here once the federation office enters them after each championship.
</x-empty-state>
@endforelse
{{ $events->links() }}
@else
@if ($placements->isEmpty())
<x-empty-state icon="fa-solid fa-trophy" title="No results published yet">
Results appear here once the federation office enters them after each championship.
</x-empty-state>
@else
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
@foreach ($placements as $placement)
<div class="col">
<article @class(['podium-card animate-box animate__animated', 'podium-card-'.$position => $position > 1]) data-animate="animate__fadeInUp">
<span class="podium-card-category">{{ $placement['result']->category ?: 'Overall' }}</span>
<h2 class="podium-card-name">{{ $placement['result']->participant_name }}</h2>
@if ($placement['result']->stateAssociation)
<p class="podium-card-event">{{ $placement['result']->stateAssociation->name }}</p>
@endif
<p class="podium-card-event"><a href="{{ route('frontend.events.show', $placement['event']->slug) }}">{{ $placement['event']->title }}</a><br/>{{ $placement['event']->dateRange() }}</p>
@if ($placement['result']->score)
<span class="jfi-badge align-self-start">Score {{ $placement['result']->score }}</span>
@endif
</article>
</div>
@endforeach
</div>
{{ $events->links() }}
@endif
@endif
</div>
</section>
@endsection
