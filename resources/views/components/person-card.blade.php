@props(['person', 'showAssociation' => false])

<article class="person-card animate-box animate__animated" data-animate="animate__fadeInUp">
<div class="person-card-photo">
<img alt="{{ $person->photo ? 'Photo of '.$person->name : '' }}" height="480" loading="lazy" src="{{ $person->photo ? Storage::url($person->photo) : asset('assets/images/jfi/person-placeholder.svg') }}" width="400"/>
</div>
<div class="person-card-body">
<span class="person-card-role">{{ $person->designation }}</span>
<h3 class="person-card-name">{{ $person->name }}</h3>
@if ($showAssociation && $person->stateAssociation)
<p class="person-card-org">{{ $person->stateAssociation->name }}</p>
@endif
</div>
</article>
