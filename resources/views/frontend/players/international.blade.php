@extends('layouts.frontend')

@php
    $internationalPlayers ??= ((fn () => require resource_path('views/frontend/_preview-data.php'))())['internationalPlayers'];
@endphp

@section('title', 'International Players')
@section('meta_description', 'International Jumpball players listed by the Jumpball Federation of India, grouped by country.')

@section('content')
<x-page-banner :crumbs="['Players' => route('frontend.players.index')]" subtitle="Players from other countries associated with Jumpball events in India, listed by country." title="International Players"/>

<section class="page-section">
<div class="hero-container">
@forelse ($internationalPlayers->groupBy('country') as $country => $group)
<section @class(['mb-5' => ! $loop->last]) aria-labelledby="country-{{ $loop->index }}">
<div class="d-flex flex-wrap align-items-center gap-3 mb-4">
<h2 class="title-plain fs-3 m-0" id="country-{{ $loop->index }}">{{ $country }}</h2>
<span class="jfi-badge">{{ $group->count() }} {{ Str::plural('player', $group->count()) }}</span>
</div>
<div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-4">
@foreach ($group as $player)
<div class="col">
<article class="person-card">
<div class="person-card-photo">
<img alt="{{ $player->photo ? 'Photo of '.$player->name : '' }}" height="480" loading="lazy" src="{{ $player->photo ? Storage::url($player->photo) : asset('assets/images/jfi/person-placeholder.svg') }}" width="400"/>
</div>
<div class="person-card-body">
<span class="person-card-role">{{ $player->country }}</span>
<h3 class="person-card-name">{{ $player->name }}</h3>
@if ($player->details)
<p class="person-card-org">{{ $player->details }}</p>
@endif
</div>
</article>
</div>
@endforeach
</div>
</section>
@empty
<x-empty-state icon="fa-solid fa-earth-asia" title="No international players listed yet">
The federation office will publish this list when details are confirmed.
</x-empty-state>
@endforelse
</div>
</section>
@endsection
