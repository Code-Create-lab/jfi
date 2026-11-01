@props(['event'])

@php
    $url = route('frontend.events.show', $event->slug);
    $cover = $event->cover_image
        ? Storage::url($event->cover_image)
        : asset('assets/images/jfi/cover-'.(abs(crc32((string) $event->slug)) % 6 + 1).'.webp');
@endphp

<article class="event-card animate-box animate__animated" data-animate="animate__fadeInUp">
<a aria-hidden="true" class="card-media" href="{{ $url }}" tabindex="-1">
<img alt="" height="400" loading="lazy" src="{{ $cover }}" width="640"/>
<span class="date-chip">
<span class="date-chip-day">{{ $event->start_date->format('j') }}</span>
<span class="date-chip-month">{{ $event->start_date->format('M') }}</span>
</span>
</a>
<div class="card-body-jfi">
<div class="d-flex flex-wrap align-items-center gap-2">
@if ($event->period() === 'current')
<span class="jfi-badge jfi-badge-green">Happening now</span>
@elseif ($event->period() === 'upcoming')
<span class="jfi-badge">Upcoming</span>
@else
<span class="jfi-badge jfi-badge-navy">Completed</span>
@endif
</div>
<h3 class="card-title-jfi"><a href="{{ $url }}">{{ $event->title }}</a></h3>
@if ($event->summary)
<p>{{ $event->summary }}</p>
@endif
<ul class="meta-list">
<li><i aria-hidden="true" class="fa-regular fa-calendar"></i><span><span class="visually-hidden">Dates: </span>{{ $event->dateRange() }}</span></li>
<li><i aria-hidden="true" class="fa-solid fa-location-dot"></i><span><span class="visually-hidden">Venue: </span>{{ collect([$event->venue, $event->city, $event->state])->filter()->join(', ') ?: 'Venue to be announced' }}</span></li>
</ul>
<div class="card-footer-jfi">
<a class="jfi-link" href="{{ $url }}">Event details<span class="visually-hidden">: {{ $event->title }}</span> <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</div>
</div>
</article>
