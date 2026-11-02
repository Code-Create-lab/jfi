@extends('layouts.frontend')

@section('title', 'Recognized State Associations')
@section('meta_description', 'State associations recognized by the Jumpball Federation of India to organise Jumpball in their state.')

@section('content')
<x-page-banner :crumbs="['Associations' => route('frontend.associations.index')]" subtitle="Associations recognized by the federation to organise Jumpball, run state trials and enter teams in national championships." title="Recognized State Associations"/>

<section class="page-section">
<div class="hero-container">
<form action="{{ route('frontend.associations.index') }}" class="search-bar" method="get" role="search">
<div class="form-field">
<label class="form-label" for="association-search">Search by name</label>
<input class="form-control-jfi" id="association-search" name="q" placeholder="e.g. Maharashtra" type="search" value="{{ request('q') }}"/>
</div>
<div class="form-field">
<label class="form-label" for="association-state">State or union territory</label>
<select class="form-control-jfi" id="association-state" name="state">
<option value="">All states</option>
@foreach (config('jumpball.states') as $state)
<option @selected(request('state') === $state) value="{{ $state }}">{{ $state }}</option>
@endforeach
</select>
</div>
<button class="jfi-btn jfi-btn-primary" type="submit"><i aria-hidden="true" class="fa-solid fa-magnifying-glass"></i> Search</button>
</form>

<p class="text-slate mb-4" role="status">{{ $associations->count() }} {{ Str::plural('association', $associations->count()) }} listed</p>

@if ($associations->isEmpty())
<x-empty-state icon="fa-solid fa-landmark" title="No associations found">
Try a different name or state, or check back after the next approvals.
</x-empty-state>
@else
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
@foreach ($associations as $association)
@php($initials = Str::upper(collect(explode(' ', $association->state))->map(fn ($word) => $word[0])->join('')))
<div class="col">
<article class="association-card animate-box animate__animated" data-animate="animate__fadeInUp">
<div aria-hidden="true" class="association-logo">
@if ($association->logo)
<img alt="" src="{{ Storage::url($association->logo) }}"/>
@else
{{ strlen($initials) > 1 ? $initials : Str::upper(Str::substr($association->state, 0, 2)) }}
@endif
</div>
<div class="flex-grow-1">
<span class="jfi-badge jfi-badge-green mb-2"><i aria-hidden="true" class="fa-solid fa-circle-check"></i> Recognized</span>
<h2 class="card-title-jfi">{{ $association->name }}</h2>
<dl>
<dt>State</dt><dd>{{ $association->state }}</dd>
@if ($association->city)<dt>City</dt><dd>{{ $association->city }}</dd>@endif
@if ($association->president_name)<dt>President</dt><dd>{{ $association->president_name }}</dd>@endif
@if ($association->secretary_name)<dt>Secretary</dt><dd>{{ $association->secretary_name }}</dd>@endif
</dl>
</div>
</article>
</div>
@endforeach
</div>
@endif

<div class="info-note mt-5">
<i aria-hidden="true" class="fa-solid fa-circle-info"></i>
<p>Is your state not listed? Associations can apply for recognition online. <a href="{{ route('frontend.associations.register') }}">Register an association</a>.</p>
</div>
</div>
</section>
@endsection
