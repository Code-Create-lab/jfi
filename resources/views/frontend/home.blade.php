@extends('layouts.frontend')

@section('title', 'Jumpball Federation of India')
@section('meta_description', 'Official website of the Jumpball Federation of India: championships, results, player registration and Player ID, certificate verification and state associations.')

@php
    $highlightGallery = $galleries->first();
    // Banners from /admin/banners are often designed artwork with their own
    // text, so the hero shows them whole, beside the headline, never under it.
    $heroSlides = $banners->map(fn ($banner): array => [
        'src' => Str::startsWith($banner->image, 'assets/') ? asset($banner->image) : Storage::url($banner->image),
        'alt' => $banner->title,
        'url' => $banner->button_url,
        'button' => $banner->button_text,
    ])->values();
    $img = fn (string $file): string => asset('assets/images/'.$file);

    $quickLinks = [
        ['title' => 'Player Registration', 'route' => 'frontend.players.register', 'icon' => 'Icon-10.png', 'photo' => 'young-athletic-woman-playing-padel-doubles-on-outd-SKA9CG9.jpg'],
        ['title' => 'State Associations', 'route' => 'frontend.associations.index', 'icon' => 'Icon-5.png', 'photo' => 'multiracial-group-of-happy-friends-leaving-the-cou-CNDKVTB.jpg'],
        ['title' => 'Championship Results', 'route' => 'frontend.results.index', 'icon' => 'Icon-6.png', 'photo' => 'happy-athletic-women-having-fun-while-celebrating-E2UZM9M.jpg'],
        ['title' => 'Certificates & Verification', 'route' => 'frontend.certificates.index', 'icon' => 'Icon-3.png', 'photo' => 'young-athletic-woman-hitting-the-ball-while-playin-J9XJQ27.jpg'],
    ];

    $pillars = [
        ['title' => 'One Official Rule Book', 'route' => 'frontend.rule-book', 'icon' => 'Icon-9.png'],
        ['title' => 'Fair Selection Through State Trials', 'route' => 'frontend.events.upcoming', 'icon' => 'Icon-7.png'],
        ['title' => 'Verified Player Records', 'route' => 'frontend.players.index', 'icon' => 'Icon-11.png'],
        ['title' => 'Safe & Respectful Sport', 'route' => 'frontend.community.index', 'icon' => 'Icon-1.png'],
    ];

    $network = [
        ['title' => 'Recognized Associations', 'route' => 'frontend.associations.index', 'icon' => 'Icon-5.png', 'text' => 'One recognized association in each state runs trials and enters teams in national championships.'],
        ['title' => 'Apply for Recognition', 'route' => 'frontend.associations.register', 'icon' => 'Icon-3.png', 'text' => 'Associations apply online with their registration documents. The federation office reviews every application.'],
        ['title' => 'State Office Bearers', 'route' => 'frontend.office-bearers.state', 'icon' => 'Icon-1.png', 'text' => 'Find the officials who manage Jumpball in your state and the association they represent.'],
    ];
@endphp

@section('content')
<div class="section-wrapper pb-0">
<section aria-labelledby="hero-title" class="banner-home-container hero-home">
<div class="hero-container">
<div class="hero-grid">
<div class="hero-copy animate-box animate__animated" data-animate="animate__fadeInUp">
<div class="sub-heading sub-heading-banner">
<span class="sub-heading-title">Jumpball Federation of India</span>
</div>
<h1 class="secondary-accent" id="hero-title">Raising the Game <span class="hero-highlight">Across India</span></h1>
<p class="hero-lede">The national body for Jumpball. Register players, recognize state associations, run national championships and publish official results and certificates.</p>
<div class="hero-actions">
<a class="btn btn-accent" href="{{ route('frontend.players.register') }}">
<span class="btn-title">Register as a Player</span>
<span aria-hidden="true" class="icon-circle"><i class="fa-solid fa-arrow-right"></i></span>
</a>
<a class="btn-outline-light-jfi" href="{{ route('frontend.certificates.index') }}">Verify a Certificate</a>
</div>
</div>
<div class="hero-media">
@if ($heroSlides->isNotEmpty())
<div aria-label="Featured banners" aria-roledescription="carousel" class="hero-slider" data-hero-slider role="region">
<div class="hero-slider-frame">
@foreach ($heroSlides as $slide)
<div @class(['hero-slide', 'is-active' => $loop->first]) aria-hidden="{{ $loop->first ? 'false' : 'true' }}" aria-label="{{ $loop->iteration }} of {{ $loop->count }}" aria-roledescription="slide" role="group">
@if ($slide['url'])
<a href="{{ $slide['url'] }}" @if (! $loop->first) tabindex="-1" @endif>
@endif
<img alt="{{ $slide['alt'] }}" decoding="async" @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif src="{{ $slide['src'] }}"/>
@if ($slide['url'])
@if ($slide['button'])
<span class="visually-hidden">{{ $slide['button'] }}</span>
@endif
</a>
@endif
</div>
@endforeach
</div>
@if ($heroSlides->count() > 1)
<div class="hero-slider-controls">
<div class="hero-slider-dots">
@foreach ($heroSlides as $slide)
<button @if ($loop->first) aria-current="true" @endif aria-label="Show banner {{ $loop->iteration }} of {{ $loop->count }}" class="hero-slider-dot" data-hero-dot="{{ $loop->index }}" type="button"></button>
@endforeach
</div>
<div class="hero-slider-arrows">
<button aria-label="Previous banner" class="hero-slider-arrow" data-hero-prev type="button"><i aria-hidden="true" class="fa-solid fa-arrow-left"></i></button>
<button aria-label="Next banner" class="hero-slider-arrow" data-hero-next type="button"><i aria-hidden="true" class="fa-solid fa-arrow-right"></i></button>
</div>
</div>
@endif
</div>
@else
<div aria-hidden="true" class="hero-media-plate">
<img alt="" height="68" src="{{ asset('assets/images/jfi-logo.png') }}" width="91"/>
</div>
@endif
</div>
</div>
<div @class(['hero-facts animate-box animate__animated animated-delay-slow', 'has-event' => $nextEvent]) data-animate="animate__fadeInUp">
@if ($nextEvent)
<a class="hero-fact hero-fact-event" href="{{ route('frontend.events.show', $nextEvent->slug) }}">
<span class="hero-fact-kicker">Next on the calendar</span>
<span class="hero-fact-title">{{ $nextEvent->title }}</span>
<span class="hero-fact-meta">{{ $nextEvent->dateRange() }} &middot; {{ collect([$nextEvent->city, $nextEvent->state])->filter()->join(', ') ?: 'Venue to be announced' }}</span>
</a>
@endif
<div class="hero-fact">
<span class="hero-fact-value">Player ID</span>
<span class="hero-fact-label">Official registration for every athlete</span>
</div>
<div class="hero-fact">
<span class="hero-fact-value">QR Verified</span>
<span class="hero-fact-label">Digital championship certificates</span>
</div>
<div class="hero-fact">
<span class="hero-fact-value">State-wise</span>
<span class="hero-fact-label">Recognized associations across India</span>
</div>
</div>
</div>
</section>
</div>

@if ($announcements->isNotEmpty())
<div class="section-wrapper pb-0">
<div class="hero-container">
<section aria-label="Latest notices" class="notice-strip animate-box animate__animated" data-animate="animate__fadeInUp">
<span class="notice-strip-label"><i aria-hidden="true" class="fa-solid fa-bullhorn"></i>Notices</span>
<ul class="notice-list">
@foreach ($announcements as $notice)
<li>
<time datetime="{{ $notice->published_on->toDateString() }}">{{ $notice->published_on->format('j M') }}</time>
<a href="{{ route('frontend.news.show', $notice->slug) }}">{{ $notice->title }}</a>
</li>
@endforeach
</ul>
<a class="jfi-link" href="{{ route('frontend.news.index', ['type' => 'announcement']) }}">All notices <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</section>
</div>
</div>
@endif

{{-- The founder --}}
<section aria-labelledby="founder-title" class="section founder-section">
<div class="hero-container">
<div class="founder-grid">
<figure class="founder-photo animate-box animate__animated" data-animate="animate__fadeInLeft">
<img alt="Mr. Ram Pravesh Kumar, Founder of the International Jumpball Federation and Secretary General of the Jumpball Federation of India" height="1521" loading="lazy" src="{{ asset('assets/images/jfi/founder-ram-pravesh-kumar.jpg') }}" width="1034"/>
<figcaption>
<span class="founder-photo-name">Mr. Ram Pravesh Kumar</span>
<span class="founder-photo-role">Founder, International Jumpball Federation</span>
<span class="founder-photo-role">Secretary General, Jumpball Federation of India</span>
</figcaption>
</figure>
<div class="founder-body">
<x-section-heading id="founder-title" label="The Founder" title="Mr. Ram Pravesh Kumar"/>
<div class="animate-box animate__animated" data-animate="animate__fadeInUp">
<p class="founder-role">Founder, International Jumpball Federation &middot; Secretary General, Jumpball Federation of India</p>
<p class="founder-lead">Mr. Ram Pravesh Kumar (R. P. Kumar) is the Founder of the International Jumpball Federation, Secretary General of the Jumpball Federation of India and the Concept Developer of Jumpball. He conceptualized and developed Jumpball as a fast-paced, skill-based, non-body-contact passing game.</p>
<p>Jumpball is fundamentally a passing game, where the primary focus is on quick and accurate passing, teamwork, coordination, movement, ball control and creating opportunities to score. Dribbling is not permitted, and the ball cannot be bounced even once. Traveling is permitted according to the rules of the game.</p>
</div>
<blockquote class="founder-rule animate-box animate__animated" data-animate="animate__fadeInUp">
<span class="founder-rule-label">The rule that defines the game</span>
<p>The most distinctive and mandatory feature of Jumpball is the &ldquo;Jump to Score&rdquo; rule. A goal is valid only when a player jumps and strikes the ball toward the goalpost while in the air, and the ball enters the goal. Points depend on the take-off area: Attack Zone 1 point, Danger Zone 2 points, behind the Centre Line 3 points. If a player throws the ball while standing or moving without jumping, or strikes the ball before leaving the ground, the goal is invalid and no point is awarded.</p>
</blockquote>
<div class="animate-box animate__animated" data-animate="animate__fadeInUp">
<p>Jumpball is a non-body-contact sport: pushing, holding, hitting, pulling or charging is prohibited, though screening from the front without contact is permitted. Passing is the fundamental element of Jumpball, while jumping is mandatory for scoring, and the 1-, 2- and 3-point system lets players choose their scoring area to suit the play. The sport emphasizes passing accuracy, teamwork, timing, movement, jumping ability, balance, coordination, ball control, distance judgment and speed.</p>
<p>Mr. Ram Pravesh Kumar&rsquo;s contribution to the conception, structure, fundamental rules, technical framework, point-scoring system and development of Jumpball forms an important foundation in the establishment and growth of the sport.</p>
</div>
<ul class="founder-chips animate-box animate__animated" data-animate="animate__fadeInUp">
<li><i aria-hidden="true" class="fa-solid fa-lightbulb"></i>Concept Developer</li>
<li><i aria-hidden="true" class="fa-solid fa-book"></i>Fundamental Rules</li>
<li><i aria-hidden="true" class="fa-solid fa-person-running"></i>Technical Framework</li>
</ul>
</div>
</div>
</div>
</section>

{{-- National office bearers --}}
@if ($nationalBearers->isNotEmpty())
<section aria-labelledby="bearers-title" class="section pt-0">
<div class="hero-container">
<div class="section-heading-row">
<x-section-heading id="bearers-title" label="Office Bearers" lede="The national office bearers accountable for the rule book, the championship calendar and the player registry." title="Who Runs the Federation"/>
<a class="jfi-link" href="{{ route('frontend.office-bearers.national') }}">All office bearers <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</div>
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
@foreach ($nationalBearers->take(4) as $bearer)
<div class="col"><x-person-card :person="$bearer"/></div>
@endforeach
</div>
</div>
</section>
@endif

{{-- About the federation, with counters --}}
<section aria-labelledby="about-title" class="section">
<div class="hero-container">
<div class="about-wrapper">
<div class="about-image-container">
<div class="image-container about-img animate-box animate__animated" data-animate="animate__fadeInLeft">
<img alt="" loading="lazy" src="{{ $img('multiracial-group-of-athletes-playing-paddle-tenni-SNHZS26.jpg') }}"/>
<div class="card card-about-detail animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInUp">
<p class="about-detail-title">Governing Jumpball in India with fair rules and a clear pathway for every athlete.</p>
<a class="link-wrapper" href="{{ route('frontend.about.federation') }}">
<span>Learn more<span class="visually-hidden"> about the federation</span></span>
<i aria-hidden="true" class="fa-solid fa-chevron-circle-right"></i>
</a>
</div>
</div>
</div>
<div class="about-content-description">
<x-section-heading id="about-title" label="About the Federation" title="One National Standard for Jumpball."/>
<div class="d-flex flex-column gspace-2">
<div class="about-description-container animate-box animate__animated" data-animate="animate__fadeInUp">
<p>The Jumpball Federation of India sets the rules, sanctions competition and builds the structures the sport needs to grow, from district courts to the national team.</p>
<p>We work through recognized state associations to register players, run the national championship calendar and issue certificates that anyone can verify.</p>
</div>
<div class="row row-cols-md-3 row-cols-1 grid-spacer-4 animate-box animate__animated" data-animate="animate__fadeInUp">
@foreach (['associations' => 'State Associations', 'players' => 'Registered Players', 'championships' => 'Championships Held'] as $key => $label)
<div class="col">
<div class="about-highlight-box">
<span aria-hidden="true" class="counter about-highlight-text" data-target="{{ $stats[$key] }}"></span>
<span class="visually-hidden">{{ number_format($stats[$key]) }}+</span>
<span class="about-highlight-label">{{ $label }}</span>
</div>
</div>
@endforeach
</div>
<div class="d-flex flex-wrap gap-3 animate-box animate__animated" data-animate="animate__fadeInUp">
<a class="btn btn-accent" href="{{ route('frontend.about.federation') }}">
<span class="btn-title">About the Federation</span>
<span aria-hidden="true" class="icon-circle"><i class="fa-solid fa-arrow-right"></i></span>
</a>
<a class="jfi-btn jfi-btn-outline" href="{{ route('frontend.about.president') }}">President's Message</a>
</div>
</div>
</div>
</div>
</div>
</section>

{{-- Quick links --}}
<section aria-labelledby="paths-title" class="section pt-0">
<div class="hero-container">
<div class="section-heading-row">
<x-section-heading id="paths-title" label="Quick Links" lede="Go straight to the forms, records and documents you use most." title="Find What You Need"/>
<a class="jfi-btn jfi-btn-outline animate-box animate__animated" data-animate="animate__fadeInRight" href="{{ route('frontend.downloads') }}">Downloads &amp; Notices <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</div>
<div class="row row-cols-xl-4 row-cols-md-2 row-cols-1 grid-spacer-2">
@foreach ($quickLinks as $link)
<div class="col">
<div class="card card-service animate-box animate__animated" data-animate="animate__fadeInUp">
<div class="image-container">
<div class="service-icon-container">
<div class="service-icon">
<img alt="" class="img-fluid" src="{{ $img($link['icon']) }}"/>
</div>
</div>
<img alt="" class="service-img" loading="lazy" src="{{ $img($link['photo']) }}"/>
<div class="service-detail-container">
<div class="service-detail">
<h3 class="service-title secondary-accent"><a class="stretched-link" href="{{ route($link['route']) }}">{{ $link['title'] }}</a></h3>
<div>
<span aria-hidden="true" class="service-btn">
<span class="icon-circle"><i class="fa-solid fa-arrow-right"></i></span>
</span>
</div>
</div>
</div>
</div>
</div>
</div>
@endforeach
</div>
</div>
</section>

{{-- Championship calendar --}}
<div class="section-wrapper py-0">
<section aria-labelledby="calendar-title" class="page-band">
<div class="hero-container">
<div class="section-heading-row">
<x-section-heading id="calendar-title" label="Events" lede="National championships and federation events. Teams enter through their affiliated state association." title="Championship Calendar"/>
<a class="jfi-btn jfi-btn-outline animate-box animate__animated" data-animate="animate__fadeInRight" href="{{ route('frontend.events.upcoming') }}">All Upcoming Events <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</div>
@if ($upcomingEvents->isEmpty())
<x-empty-state icon="fa-regular fa-calendar" title="No upcoming events yet">
The next championship dates will be published here and in the official circulars.
</x-empty-state>
@else
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
@foreach ($upcomingEvents->take(3) as $event)
<div class="col"><x-event-card :event="$event"/></div>
@endforeach
</div>
@endif
</div>
</section>
</div>

{{-- What the federation does --}}
<section aria-labelledby="pillars-title" class="section">
<div class="section-wrapper py-0">
<div class="section section-chooseus">
<div class="hero-container">
<div class="d-flex flex-column flex-xl-row align-items-center gspace-100">
<div class="chooseus-title-container">
<x-section-heading id="pillars-title" label="What JFI Does" lede="Every programme the federation runs serves one goal: more players, competing on a fair national stage." title="Built Around the Athlete."/>
<div class="image-container whychoose-img animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInLeft">
<img alt="" class="chooseus-img" loading="lazy" src="{{ $img('multiracial-group-of-athletes-going-for-an-outdoor-ZAZBUZY-1024x683.jpg') }}"/>
<div class="whychooseus-avatar-container">
<div class="whychooseus-badge">
<span class="whychooseus-badge-value">Pan-India</span>
<span class="chooseus-img-description">Players registered through their state association</span>
</div>
</div>
</div>
</div>
<div class="chooseus-card-container">
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
@foreach ($pillars as $pillar)
<div class="col">
<div @class(['card card-chooseus animate-box animate__animated', 'bg-accent-color' => $loop->index === 1]) data-animate="animate__fadeInRight">
<div class="chooseus-icon">
<img alt="" class="img-fluid" src="{{ $img($pillar['icon']) }}"/>
</div>
<h3 @class(['chooseus-title', 'secondary-accent' => $loop->index === 1])><a class="stretched-link" href="{{ route($pillar['route']) }}">{{ $pillar['title'] }}</a></h3>
<span aria-hidden="true" class="chooseus-btn">
<span class="icon-circle"><i class="fa-solid fa-arrow-right"></i></span>
</span>
</div>
</div>
@endforeach
</div>
</div>
</div>
</div>
</div>
</div>
</section>

{{-- State associations network --}}
<section aria-labelledby="network-title" class="section pt-0">
<div class="section-wrapper py-0">
<div class="section section-community">
<div class="hero-container">
<div class="community-grid">
<div class="image-container animate-box animate__animated" data-animate="animate__fadeInLeft">
<div class="community-cta animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInDown">
<p class="community-cta-title accent-color">Be Part of Something Bigger Than the Game</p>
<div class="d-flex flex-row align-items-center gspace-1">
<a class="primary-accent" href="{{ route('frontend.associations.index') }}">Find Your State Association</a>
<i aria-hidden="true" class="fa-solid fa-circle-chevron-right"></i>
</div>
</div>
<img alt="" class="community-images" loading="lazy" src="{{ $img('happy-sportswomen-giving-high-five-after-playing-p-D8ZSZV5.jpg') }}"/>
</div>
<div class="d-flex flex-column gspace-5">
<x-section-heading id="network-title" label="State Associations" title="A National Network of Associations"/>
<div class="d-flex flex-column gspace-2 w-100">
@foreach ($network as $item)
<div class="d-flex flex-column flex-md-row gspace-2 gspace-md-5 justify-content-start align-items-center align-items-md-start text-center text-md-start animate-box animate__animated" data-animate="animate__fadeInRight">
<div>
<div class="community-icon">
<img alt="" class="img-fluid" src="{{ $img($item['icon']) }}"/>
</div>
</div>
<div class="d-flex flex-column">
<h3 class="network-title"><a href="{{ route($item['route']) }}">{{ $item['title'] }}</a></h3>
<p class="mb-0">{{ $item['text'] }}</p>
</div>
</div>
@endforeach
</div>
</div>
</div>
</div>
</div>
</div>
</section>

{{-- International players --}}
@if ($internationalPlayers->isNotEmpty())
<section aria-labelledby="international-title" class="section international-banner">
<div class="hero-container">
<div class="d-flex flex-column gspace-5">
<x-section-heading center id="international-title" label="International Players" lede="Players from other countries who have taken part in federation events." title="Jumpball Beyond Our Borders"/>
<div class="testimonial-content-container justify-content-center animate-box animate__animated" data-animate="animate__fadeInUp">
<div class="card card-testimonial">
<div class="testimonial-btn-container">
<button aria-controls="testimonial-slider" aria-label="Previous player" class="testimonial-btn" id="prev" type="button">
<i aria-hidden="true" class="fa-solid fa-circle-arrow-left"></i>
</button>
<button aria-controls="testimonial-slider" aria-label="Next player" class="testimonial-btn" id="next" type="button">
<i aria-hidden="true" class="fa-solid fa-circle-arrow-right"></i>
</button>
</div>
<div class="testimonial-slider">
<div aria-live="polite" class="testimonial-slider-wrapper" id="testimonial-slider">
@foreach ($internationalPlayers as $player)
<div class="testimonial-slide" data-index="{{ $loop->index }}">
<p class="testimonial-quote">{{ $player->details ?: $player->country }}</p>
<img alt="" class="testimonial-avatar" loading="lazy" src="{{ $player->photo ? Storage::url($player->photo) : asset('assets/images/jfi/person-placeholder.svg') }}"/>
<div class="d-flex flex-column align-items-center">
<span class="testimonial-name">{{ $player->name }}</span>
<span class="testimonial-designation">{{ $player->country }}</span>
</div>
</div>
@endforeach
</div>
</div>
<div class="testimonial-nav-container">
@foreach ($internationalPlayers as $player)
<button @class(['testimonial-nav-btn', 'active' => $loop->first]) aria-label="Show {{ $player->name }}" type="button"></button>
@endforeach
</div>
</div>
</div>
<div class="text-center">
<a class="jfi-btn jfi-btn-outline" href="{{ route('frontend.players.international') }}">All International Players <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</div>
</div>
</div>
</section>
@endif

{{-- Registration call to action --}}
<section aria-labelledby="register-title" class="section pt-0">
<div class="hero-container">
<div class="row row-cols-xl-2 row-cols-1 grid-spacer-2">
<div class="col col-xl-5">
<div class="card card-membership-cta cta-content animate-box animate__animated" data-animate="animate__fadeInLeft">
<h2 class="cta-content-title" id="register-title">Register with JFI</h2>
<ul class="check-list alternative-list">
<li>Official JFI Player ID</li>
<li>Eligibility for sanctioned championships</li>
<li>Results and certificates on your record</li>
<li>Sign in to view your registration</li>
</ul>
<div class="d-flex flex-wrap align-items-center gap-4">
<a class="btn btn-accent bg-accent-color-6" href="{{ route('frontend.players.register') }}">
<span class="btn-title">Start Registration</span>
<span aria-hidden="true" class="icon-circle"><i class="fa-solid fa-arrow-right"></i></span>
</a>
<a class="cta-content-link" href="{{ route('frontend.associations.register') }}">Register an Association</a>
</div>
</div>
</div>
<div class="col col-xl-7">
<div class="card card-membership-cta cta-benefit animate-box animate__animated" data-animate="animate__fadeInRight">
<p class="membership-cta-description">Registration gives every player an official JFI identity and a verified competition record. State associations apply for recognition the same way, online, with their documents.</p>
<div class="position-relative overflow-hidden">
<div class="cta-tag-container">
<span class="cta-tag">Players</span>
<span class="cta-tag">State Associations</span>
</div>
<img alt="" class="cta-benefit-img" loading="lazy" src="{{ $img('man-trying-to-reach-the-ball-playing-pickleball-9W7DN8G.jpg') }}"/>
<div class="cta-benefit-title">
<p class="cta-benefit-text secondary-accent">Players | State Associations | Officials</p>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

{{-- News --}}
<section aria-labelledby="news-title" class="page-section pt-0">
<div class="hero-container">
<div class="section-heading-row">
<x-section-heading id="news-title" label="News & Updates" title="Latest from the Federation"/>
<a class="jfi-btn jfi-btn-outline animate-box animate__animated" data-animate="animate__fadeInRight" href="{{ route('frontend.news.index') }}">All News <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a>
</div>
@if ($latestNews->isEmpty())
<x-empty-state icon="fa-regular fa-newspaper" title="No news yet">
Announcements and press releases from the federation office will appear here.
</x-empty-state>
@else
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
@foreach ($latestNews as $item)
<div class="col"><x-news-card :item="$item"/></div>
@endforeach
</div>
@endif
</div>
</section>

{{-- Gallery highlights --}}
@if ($highlightGallery)
<div class="section-wrapper pt-0">
<section aria-labelledby="gallery-title" class="page-band">
<div class="hero-container">
<div class="section-heading-row">
<x-section-heading id="gallery-title" label="Gallery" title="From the Championships"/>
<div class="d-flex flex-wrap gap-3 animate-box animate__animated" data-animate="animate__fadeInRight">
<a class="jfi-btn jfi-btn-outline" href="{{ route('frontend.gallery.index') }}">Photo Gallery</a>
<a class="jfi-btn jfi-btn-outline" href="{{ route('frontend.videos') }}">Video Gallery</a>
</div>
</div>
<div class="gallery-mosaic animate-box animate__animated" data-animate="animate__fadeInUp">
@foreach ($highlightGallery->images->take(5) as $image)
<a href="{{ route('frontend.gallery.show', $highlightGallery->slug) }}">
<img alt="{{ $image->caption ?? $highlightGallery->title }}" loading="lazy" src="{{ Str::startsWith($image->image, 'assets/') ? asset($image->image) : Storage::url($image->image) }}"/>
@if ($loop->first)
<span>{{ $highlightGallery->title }}</span>
@endif
</a>
@endforeach
</div>
</div>
</section>
</div>
@endif
@endsection

@push('scripts')
<script src="{{ asset('assets/js/banner.js') }}"></script>
@endpush
