@extends('layouts.frontend')

@php
    $isState = $level === 'state';
    $title = $isState ? 'State Office Bearers' : 'National Office Bearers';
@endphp

@section('title', $title)
@section('meta_description', $isState
    ? 'Office bearers of the state associations recognized by the Jumpball Federation of India.'
    : 'National office bearers of the Jumpball Federation of India.')

@section('content')
<x-page-banner :crumbs="['About' => route('frontend.about.federation')]" :subtitle="$isState ? 'Office bearers of each recognized state association.' : 'The elected office bearers who lead the federation.'" :title="$title"/>

<section class="page-section">
<div class="hero-container">
<nav aria-label="Office bearer level">
<ul class="jfi-tabs">
<li><a @if (! $isState) aria-current="page" @endif href="{{ route('frontend.office-bearers.national') }}">National</a></li>
<li><a @if ($isState) aria-current="page" @endif href="{{ route('frontend.office-bearers.state') }}">State Associations</a></li>
</ul>
</nav>

@if ($bearers->isEmpty())
<x-empty-state icon="fa-solid fa-users" title="Office bearers will be listed soon">
The federation office is updating this list.
</x-empty-state>
@elseif ($isState)
@foreach ($bearers->groupBy(fn ($bearer) => $bearer->stateAssociation?->name ?? 'State association') as $associationName => $group)
<section @class(['mb-5' => ! $loop->last]) aria-labelledby="association-{{ $loop->index }}">
<div class="d-flex flex-wrap align-items-center gap-3 mb-4">
<h2 class="title-plain fs-3 m-0" id="association-{{ $loop->index }}">{{ $associationName }}</h2>
@if ($group->first()->stateAssociation?->state)
<span class="jfi-badge">{{ $group->first()->stateAssociation->state }}</span>
@endif
</div>
<div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-4">
@foreach ($group as $bearer)
<div class="col"><x-person-card :person="$bearer"/></div>
@endforeach
</div>
</section>
@endforeach
@else
<div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4">
@foreach ($bearers as $bearer)
<div class="col"><x-person-card :person="$bearer"/></div>
@endforeach
</div>
@endif
</div>
</section>
@endsection
