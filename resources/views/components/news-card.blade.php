@props(['item'])

@php
    $url = route('frontend.news.show', $item->slug);
    $image = $item->image
        ? Storage::url($item->image)
        : asset('assets/images/jfi/cover-'.(abs(crc32((string) $item->slug)) % 6 + 1).'.webp');
@endphp

<article class="news-card animate-box animate__animated" data-animate="animate__fadeInUp">
<a aria-hidden="true" class="card-media" href="{{ $url }}" tabindex="-1">
<img alt="" height="400" loading="lazy" src="{{ $image }}" width="640"/>
</a>
<div class="card-body-jfi">
<div class="meta-inline">
<span @class(['jfi-badge', 'jfi-badge-gold' => $item->type === App\Enums\NewsType::Announcement, 'jfi-badge-navy' => $item->type === App\Enums\NewsType::PressRelease])>{{ $item->type->label() }}</span>
<time datetime="{{ $item->published_on->toDateString() }}">{{ $item->published_on->format('j M Y') }}</time>
</div>
<h3 class="card-title-jfi"><a href="{{ $url }}">{{ $item->title }}</a></h3>
@if ($item->excerpt)
<p>{{ $item->excerpt }}</p>
@endif
<div class="card-footer-jfi">
<a class="jfi-link" href="{{ $url }}">Read more<span class="visually-hidden">: {{ $item->title }}</span> <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</div>
</div>
</article>
