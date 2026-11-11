@props(['person', 'showAssociation' => false])

@php
    $photoUrl = match (true) {
        ! $person->photo => asset('assets/images/jfi/person-placeholder.svg'),
        Str::startsWith($person->photo, 'assets/') => asset($person->photo),
        default => Storage::url($person->photo),
    };
@endphp

<article class="person-card person-card-navy animate-box animate__animated" data-animate="animate__fadeInUp">
<div class="person-card-photo">
<img alt="{{ $person->photo ? 'Photo of '.$person->name : '' }}" height="480" loading="lazy" src="{{ $photoUrl }}" width="400"/>
</div>
<div class="person-card-body">
<span class="person-card-role">{{ $person->designation }}</span>
<h3 class="person-card-name">{{ $person->name }}</h3>
@if ($person->location)
<p class="person-card-org"><i aria-hidden="true" class="fa-solid fa-location-dot"></i> {{ $person->location }}</p>
@endif
@if ($showAssociation && $person->stateAssociation)
<p class="person-card-org">{{ $person->stateAssociation->name }}</p>
@endif
</div>
</article>
