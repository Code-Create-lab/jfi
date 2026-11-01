@extends('layouts.app')

@section('title', 'Jumpball Federation of India')

@section('content')
<!-- Banner Home Section -->
<div class="section-wrapper pb-0">
<div class="banner-home-container" data-slides="[]" id="banner-slideshow">
<div class="slideshow-container">
</div>
<div class="hero-container">
<div class="banner-content-container">
<div class="banner-home-top">
<div class="banner-home-title animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<div>
<div class="sub-heading sub-heading-banner">
<span class="sub-heading-title">Jumpball Federation of India</span>
</div>
</div>
<h1 class="secondary-accent">Raising the Game <span class="hero-highlight">Across India</span></h1>
<p class="hero-lede">The national body for Jumpball, building a clear pathway from school courts to the national squad through sanctioned competition, certified coaching and strong state associations.</p>
<div class="hero-actions">
<a class="btn btn-accent" href="{{ route('membership') }}">
<span class="btn-title">Register as Athlete</span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
<a class="btn-outline-light-jfi" href="{{ route('event') }}">
View Championships
</a>
</div>
</div>
<div class="banner-home-network animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="hero-panel">
<span class="hero-panel-label">Next on the Calendar</span>
<h4>National Jumpball Championship</h4>
<p>Senior and junior divisions. Teams qualify through their state association trials.</p>
<div class="hero-panel-meta">
<span><i class="fa-regular fa-calendar"></i>Dates announced by official circular</span>
<span><i class="fa-solid fa-location-dot"></i>Host state to be confirmed</span>
<span><i class="fa-solid fa-users"></i>Entries via affiliated units only</span>
</div>
<a class="link-wrapper" href="{{ route('event') }}">
<span>Event details</span>
<i class="fa-solid fa-arrow-right"></i>
</a>
</div>
</div>
</div>
<div class="banner-home-bottom animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInUp">
<div class="hero-facts">
<div class="hero-fact">
<span class="hero-fact-value">U-14 to Senior</span>
<span class="hero-fact-label">Age-group pathways</span>
</div>
<div class="hero-fact">
<span class="hero-fact-value">State &amp; District</span>
<span class="hero-fact-label">Affiliated units</span>
</div>
<div class="hero-fact">
<span class="hero-fact-value">Certified</span>
<span class="hero-fact-label">Coaches and technical officials</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Section Modal Video -->
<div class="section p-0">
<div class="modal-overlay" id="modal-overlay">
<span class="my-close"><i class="fa-solid fa-xmark"></i></span>
<div class="my-modal">
<iframe allowfullscreen="" id="my-video-frame"></iframe>
</div>
</div>
</div>
<!-- About Section -->
<div class="section">
<div class="hero-container">
<div class="about-wrapper">
<div class="about-image-container">
<div class="image-container about-img animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<img alt="About Us Img" src="{{ asset('assets/images/multiracial-group-of-athletes-playing-paddle-tenni-SNHZS26.jpg') }}"/>
<div class="card card-about-detail animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInUp">
<h4>Governing Jumpball in India with fair play, clear rules and opportunity for every athlete.</h4>
<a class="link-wrapper" href="{{ route('about') }}">
<span>Learn More</span>
<i class="fa-solid fa-chevron-circle-right"></i>
</a>
</div>
</div>
</div>
<div class="about-content-description">
<div class="d-flex flex-column gspace-2 animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">About the Federation</span>
</div>
</div>
<h2>One National Standard for Jumpball.</h2>
</div>
<div class="d-flex flex-column gspace-2">
<div class="about-description-container">
<div class="animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<p>The Jumpball Federation of India sets the rules, sanctions competition and builds the structures the sport needs to grow, from school and district level through to the national team.</p>
<p>We work through affiliated state associations to register athletes, certify coaches and officials, and run a national calendar that gives every player a fair route to selection.</p>
</div>
<div class="d-flex flex-column justify-content-center animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<div class="row row-cols-md-3 row-cols-1 grid-spacer-4">
<div class="col">
<div class="about-highlight-box">
<span class="counter counter-year about-highlight-text" data-target="2022"></span>
<h5>Federation Established</h5>
</div>
</div>
<div class="col">
<div class="about-highlight-box">
<span class="counter about-highlight-text" data-target="100"></span>
<h5>Sanctioned Matches</h5>
</div>
</div>
<div class="col">
<div class="about-highlight-box">
<span class="counter about-highlight-text" data-target="25"></span>
<h5>Affiliated Units</h5>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Why Choose Us Section -->
<div class="section-wrapper py-0">
<div class="section section-chooseus">
<div class="hero-container">
<div class="d-flex flex-column flex-xl-row align-items-center gspace-100">
<div class="chooseus-title-container">
<div class="d-flex flex-column gspace-2 animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">What JFI Does</span>
</div>
</div>
<h2>Built Around the Athlete.</h2>
<p class="mb-0">Every programme the federation runs serves one goal: more players, better coached, competing on a fair national stage.</p>
</div>
<div class="image-container whychoose-img animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInLeft">
<img alt="Why Choose Us Image" class="chooseus-img" src="{{ asset('assets/images/multiracial-group-of-athletes-going-for-an-outdoor-ZAZBUZY-1024x683.jpg') }}"/>
<div class="whychooseus-avatar-container">
<div class="d-flex flex-row align-items-center">
<img alt="Reviewer" class="banner-avatar" src="{{ asset('assets/images/young-bearded-man-portrait-outdoors-in-the-mountai-6Z46ZMB.jpg') }}"/>
<img alt="Reviewer" class="banner-avatar" src="{{ asset('assets/images/attractive-happy-woman-in-red-dress-smiling-outdoo-UW49SNL.jpg') }}"/>
<img alt="Reviewer" class="banner-avatar" src="{{ asset('assets/images/close-up-of-young-man-smiling-outdoors-DELEX88.jpg') }}"/>
</div>
<div class="d-flex flex-column">
<div class="d-flex flex-row align-items-center gspace-1">
<h5 class="accent-color-2">Pan-India</h5>
<h6 class="secondary-accent">Athlete Network</h6>
</div>
<span class="chooseus-img-description">Registered through state units</span>
</div>
</div>
</div>
</div>
<div class="chooseus-card-container">
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="card card-chooseus animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="chooseus-icon">
<img alt="Banner Reviewer" class="img-fluid" src="{{ asset('assets/images/Icon-1.png') }}"/>
</div>
<h4>Standardised Rules &amp; Venues</h4>
<a class="chooseus-btn" href="{{ route('service') }}">
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
<div class="col">
<div class="card card-chooseus bg-accent-color animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInRight">
<div class="chooseus-icon">
<img alt="Banner Reviewer" class="img-fluid" src="{{ asset('assets/images/Icon-2.png') }}"/>
</div>
<h4 class="secondary-accent">Certified Coaches &amp; Training</h4>
<a class="chooseus-btn" href="{{ route('coaching') }}">
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
<div class="col">
<div class="card card-chooseus animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="chooseus-icon">
<img alt="Banner Reviewer" class="img-fluid" src="{{ asset('assets/images/Icon-3.png') }}"/>
</div>
<h4>Sanctioned National Competitions</h4>
<a class="chooseus-btn" href="{{ route('event') }}">
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
<div class="col">
<div class="card card-chooseus animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInRight">
<div class="chooseus-icon">
<img alt="Banner Reviewer" class="img-fluid" src="{{ asset('assets/images/Icon-4.png') }}"/>
</div>
<h4>State &amp; District Affiliation</h4>
<a class="chooseus-btn" href="{{ route('community') }}">
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Service Section -->
<div class="section">
<div class="hero-container">
<div class="d-flex flex-column gspace-5">
<div class="service-title-container">
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="d-flex flex-column gspace-2 justify-content-center justify-content-md- text-md-start text-center animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">Programmes</span>
</div>
</div>
<h2>Federation Programmes</h2>
</div>
</div>
<div class="col">
<div class="d-flex flex-column h-100 align-items-center align-items-md-end justify-content-center justify-content-md-end animate-box animate__animated animated" data-animate="animate__fadeInRight">
<a class="btn btn-accent" href="{{ route('service') }}">
<span class="btn-title">

                                            All Programmes

                                        </span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</div>
<div class="row row-cols-xl-4 row-cols-md-2 row-cols-1 grid-spacer-2 w-100">
<div class="col">
<div class="card card-service animate-box animate__animated animated-delay-fast" data-animate="animate__fadeInRight">
<div class="image-container">
<div class="service-icon-container">
<div class="service-icon">
<img alt="Service Image" class="img-fluid" src="{{ asset('assets/images/Icon-5.png') }}"/>
</div>
</div>
<img alt="Service Image" class="service-img" src="{{ asset('assets/images/happy-sportswomen-giving-high-five-after-playing-p-D8ZSZV5.jpg') }}"/>
<div class="service-detail-container">
<div class="service-detail">
<h4 class="secondary-accent">Venue Certification</h4>
<div>
<a class="service-btn" href="{{ route('service') }}">
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col">
<div class="card card-service animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="image-container">
<div class="service-icon-container">
<div class="service-icon">
<img alt="Service Image" class="img-fluid" src="{{ asset('assets/images/Icon-6.png') }}"/>
</div>
</div>
<img alt="Service Image" class="service-img" src="{{ asset('assets/images/young-athletic-woman-playing-padel-doubles-on-outd-SKA9CG9.jpg') }}"/>
<div class="service-detail-container">
<div class="service-detail">
<h4 class="secondary-accent">Jumpball Academy &amp; Coaching</h4>
<div>
<a class="service-btn" href="{{ route('service') }}">
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col">
<div class="card card-service animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="image-container">
<div class="service-icon-container">
<div class="service-icon">
<img alt="Service Image" class="img-fluid" src="{{ asset('assets/images/Icon-7.png') }}"/>
</div>
</div>
<img alt="Service Image" class="service-img" src="{{ asset('assets/images/young-athletic-woman-hitting-the-ball-while-playin-J9XJQ27.jpg') }}"/>
<div class="service-detail-container">
<div class="service-detail">
<h4 class="secondary-accent">National Championships</h4>
<div>
<a class="service-btn" href="{{ route('service') }}">
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col">
<div class="card card-service animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInRight">
<div class="image-container">
<div class="service-icon-container">
<div class="service-icon">
<img alt="Service Image" class="img-fluid" src="{{ asset('assets/images/Icon-8.png') }}"/>
</div>
</div>
<img alt="Service Image" class="service-img" src="{{ asset('assets/images/paddle-tennis-player-making-an-effort-to-while-hit-QPJDK5U.jpg') }}"/>
<div class="service-detail-container">
<div class="service-detail">
<h4 class="secondary-accent">Athlete Registration</h4>
<div>
<a class="service-btn" href="{{ route('service') }}">
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Jumpball Booking Section -->
<div class="section pt-0">
<div class="hero-container">
<div class="booking-content-wrapper">
<div class="booking-highlight-container">
<div class="booking-tag-container animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<!-- You can change <span> to <a href="{{ route('service') }}"> if you want tags to be clickable -->
<span class="booking-tag">Official Dimensions</span>
<span class="booking-tag">Match Hosting</span>
<span class="booking-tag bg-accent-color secondary-accent">JFI Certified</span>
<span class="booking-tag">Training Camps</span>
<span class="booking-tag">Selection Trials</span>
<span class="booking-tag">Indoor &amp; Outdoor</span>
<span class="booking-tag">Floodlit Courts</span>
</div>
<div class="overflow-hidden">
<div class="swiper swiperbooking animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInLeft">
<div class="swiper-wrapper">
<div class="swiper-slide">
<div class="image-container">
<img alt="booking Image" class="img-fluid" src="{{ asset('assets/images/happy-athletic-women-having-fun-while-celebrating-E2UZM9M.jpg') }}"/>
</div>
</div>
<div class="swiper-slide">
<div class="image-container">
<img alt="booking Image" class="img-fluid" src="{{ asset('assets/images/happy-paddle-tennis-player-on-an-outdoor-court-loo-MX89ERL.jpg') }}"/>
</div>
</div>
<div class="swiper-slide">
<div class="image-container">
<img alt="booking Image" class="img-fluid" src="{{ asset('assets/images/monitor-teaching-padel-class-QAEF7TM.jpg') }}"/>
</div>
</div>
<div class="swiper-slide">
<div class="image-container">
<img alt="booking Image" class="img-fluid" src="{{ asset('assets/images/young-athletic-woman-playing-paddle-tennis-on-outd-WUP7D6S.jpg') }}"/>
</div>
</div>
<div class="swiper-slide">
<div class="image-container">
<img alt="booking Image" class="img-fluid" src="{{ asset('assets/images/young-paddle-tennis-players-communicating-during-a-VTVTVU6.jpg') }}"/>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="booking-content-container">
<div class="d-flex flex-column justify-content-center justify-content-md-start text-center text-md-start gspace-2 animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">Venue Booking</span>
</div>
</div>
<h2>Book a Certified Venue.</h2>
</div>
<div class="d-flex flex-column flex-md-row align-items-center gspace-5">
<div class="card card-booking-cta animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="booking-cta-icon">
<i class="fa-solid fa-address-book"></i>
</div>
<h4 class="secondary-accent">Hosting a Match or Camp? Reserve a Certified Venue</h4>
<div>
<a class="btn btn-accent" href="{{ route('booking') }}">
<span class="btn-title">

                                            Reserve a Venue

                                        </span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
<div class="booking-benefit-container animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInRight">
<h3 class="text-center text-md-start">The Benefits</h3>
<div class="underline-accent-5"></div>
<ul class="check-list">
<li>Courts inspected to JFI specifications</li>
<li>Suitable for sanctioned matches and trials</li>
<li>Floodlit options for evening fixtures</li>
<li>Open to affiliated units, schools and clubs</li>
<li>Confirmation issued by the JFI office</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Academy Section -->
<div class="section-wrapper py-0">
<div class="section section-academy">
<div class="hero-container">
<div class="d-flex flex-column gspace-5">
<div class="academy-title-container">
<div class="academy-heading-container animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">Athlete Development</span>
</div>
</div>
<h2 class="secondary-accent">Coaching Pathway &amp; Academy</h2>
</div>
<div class="academy-title-image animate-box animate__animated animated" data-animate="animate__fadeInUp">
<div class="image-container overflow-visible">
<img alt="Academy" class="img-fluid" src="{{ asset('assets/images/K2MEUKX.png') }}"/>
</div>
</div>
<div class="academy-title-cta animate-box animate__animated animated" data-animate="animate__fadeInRight">
<p class="secondary-accent">

                                    A structured pathway from school and district squads to national camps, delivered by JFI-certified coaches against a common national syllabus.

                                </p>
<div>
<a class="btn btn-accent" href="{{ route('service') }}">
<span class="btn-title">

                                            Explore the Pathway

                                        </span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
<div class="academy-counter-container">
<div class="row row-cols-xl-3 row-cols-1 grid-spacer-2">
<div class="col">
<div class="d-flex flex-column gspace-1 animate-box animate__animated animated-delay-fast" data-animate="animate__fadeInRight">
<div class="d-flex flex-column flex-md-row gspace-1 gspace-md-2 align-items-center text-center text-md-start">
<span class="counter academy-stat" data-target="150"></span>
<h5 class="secondary-accent">Athletes in National Camps</h5>
</div>
<p class="academy-stat-description">Players selected through state trials into national coaching camps.</p>
</div>
</div>
<div class="col">
<div class="d-flex flex-column gspace-1 animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="d-flex flex-column flex-md-row gspace-1 gspace-md-2 align-items-center text-center text-md-start">
<span class="counter academy-stat" data-target="30"></span>
<h5 class="secondary-accent">Certified Coaches</h5>
</div>
<p class="academy-stat-description">Coaches who have completed the JFI coach education course.</p>
</div>
</div>
<div class="col">
<div class="d-flex flex-column gspace-1 animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInRight">
<div class="d-flex flex-column flex-md-row gspace-1 gspace-md-2 align-items-center text-center text-md-start">
<span class="counter academy-stat" data-target="85"></span>
<h5 class="secondary-accent">Accredited Officials</h5>
</div>
<p class="academy-stat-description">Referees and table officials cleared to officiate sanctioned matches.</p>
</div>
</div>
</div>
</div>
<div class="academy-video-section">
<div class="academy-video-container">
<div class="academy-video-wrapper">
<iframe allow="autoplay; encrypted-media" allowfullscreen="" src="https://www.youtube.com/embed/sh5uMmHmvos?autoplay=1&amp;mute=1&amp;loop=1&amp;playlist=sh5uMmHmvos&amp;controls=0&amp;modestbranding=1&amp;rel=0&amp;showinfo=0" title="Academy Introduction Video"></iframe>
<div class="video-overlay"></div>
</div>
</div>
</div>
<div class="row row-cols-md-2 row-cols-1 grid-spacer-md-100 grid-spacer-2">
<div class="col">
<div class="d-flex flex-column gspace-2 animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<ul class="circle-check-list">
<li>Grassroots School Programme</li>
<li>Junior Development Squads</li>
<li>Talent Identification Camps</li>
</ul>
</div>
</div>
<div class="col">
<ul class="circle-check-list">
<li>Coach Education Courses</li>
<li>Referee &amp; Official Clinics</li>
<li>Athlete Welfare &amp; Anti-Doping Awareness</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Tournament Section -->
<div class="section">
<div class="hero-container">
<div class="d-flex flex-column gspace-5">
<div class="heading-section-container animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">Competition Calendar</span>
</div>
</div>
<h2>Upcoming Championships</h2>
</div>
<div class="tournament-grid">
<div class="tournament-main-envent animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="card card-tournament main-event">
<div class="tournament-tag-container">
<!-- You can change <span> to <a href="{{ route('service') }}"> if you want tags to be clickable -->
<span class="tournament-tag">National Level</span>
<span class="tournament-tag">Competitive</span>
<span class="tournament-tag">Age-Group Divisions</span>
<span class="tournament-tag">Annual</span>
<span class="tournament-tag">Via State Unit</span>
</div>
<div class="card-tournament-content">
<h4>National Jumpball Championship</h4>
<p class="secondary-accent">The flagship event of the national calendar, open to teams cleared through state trials.</p>
<div class="d-flex flex-row justify-content-between align-items-end gspace-2">
<div class="d-flex flex-column gspace-1">
<div class="d-flex flex-row align-items-center gspace-1">
<i class="fa-solid fa-calendar accent-color-2"></i>
<span class="tournament-schedule">Dates as per JFI circular</span>
</div>
<div class="d-flex flex-row align-items-center gspace-1">
<i class="fa-solid fa-list accent-color-2"></i>
<span class="tournament-schedule">Men's &amp; Women's Divisions</span>
</div>
<div class="d-flex flex-row align-items-center gspace-1">
<i class="fa-solid fa-list accent-color-2"></i>
<span class="tournament-schedule">Medals &amp; National Ranking Points</span>
</div>
</div>
<div>
<a class="tournament-btn" href="{{ route('community') }}">
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</div>
</div>
<div class="tournament-event-list">
<div class="card card-tournament tournament-cta animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="tournament-cta-title">
<h3 class="secondary-accent">Ready to Compete?</h3>
<p class="secondary-accent">Register now or explore all upcoming events. Whether you're a beginner or a seasoned athlete, JFI welcomes your competitive spirit.</p>
<div>
<a class="btn btn-accent" href="{{ route('booking') }}">
<span class="btn-title">

                                                Enter Your Team

                                            </span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
<div class="image-container">
<img alt="Tournament Image" class="tournament-cta-image" src="{{ asset('assets/images/european-man-holding-padel-racquet-in-hand-and-rea-MWHPVEP.jpg') }}"/>
</div>
</div>
<div class="other-tournament-container">
<div class="card card-tournament junior-padel-championship animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="tournament-tag-container">
<!-- You can change <span> to <a href="{{ route('service') }}"> if you want tags to be clickable -->
<span class="tournament-tag">Open for All</span>
<span class="tournament-tag">Competitive</span>
<span class="tournament-tag">Age-Group Divisions</span>
</div>
<div class="card-tournament-content">
<div class="d-flex flex-row justify-content-between align-items-center gspace-2">
<h4>Junior National Championship</h4>
<div>
<a class="tournament-btn" href="{{ route('community') }}">
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</div>
<div class="card card-tournament comunity-padel-night animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInRight">
<div class="tournament-tag-container">
<!-- You can change <span> to <a href="{{ route('service') }}"> if you want tags to be clickable -->
<span class="tournament-tag">Open for All</span>
<span class="tournament-tag">Competitive</span>
<span class="tournament-tag">Age-Group Divisions</span>
</div>
<div class="highlight-image">
<img alt="" class="img-fluid" src="{{ asset('assets/images/2AH2LFJ-1.png') }}"/>
</div>
<div class="card-tournament-content">
<div class="d-flex flex-row justify-content-between align-items-center gspace-2">
<h4>Inter-State Exhibition Series</h4>
<div>
<a class="tournament-btn" href="{{ route('community') }}">
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Community Section -->
<div class="section-wrapper py-0">
<div class="section section-community">
<div class="hero-container">
<div class="community-grid">
<div class="image-container animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<div class="community-cta animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInDown">
<h4 class="accent-color">Be Part of Something Bigger Than the Game</h4>
<div class="d-flex flex-row align-items-center gspace-1">
<a class="primary-accent" href="{{ route('contact') }}">Find Your State Association</a>
<i class="fa-solid fa-circle-chevron-right"></i>
</div>
</div>
<img alt="Community image" class="community-images" src="{{ asset('assets/images/AD9QPHP.jpg') }}"/>
</div>
<div class="d-flex flex-column gspace-5">
<div class="d-flex flex-column gspace-2 animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">State Associations</span>
</div>
</div>
<h2>A National Network of Associations</h2>
</div>
<div class="d-flex flex-column gspace-2 w-100">
<div class="d-flex flex-column flex-md-row gspace-2 gspace-md-5 justify-content-start justify-content-xl-between align-items-center align-items-md-start text-center text-md-start animate-box animate__animated animated-delay-fast" data-animate="animate__fadeInRight">
<div>
<div class="community-icon">
<img alt="" class="img-fluid" src="{{ asset('assets/images/Icon-11.png') }}"/>
</div>
</div>
<div class="d-flex flex-column">
<h4>District Leagues</h4>
<p>Regular league play at district level keeps athletes competing all season, not just at trials.</p>
</div>
</div>
<div class="d-flex flex-column flex-md-row gspace-2 gspace-md-5 justify-content-start justify-content-xl-between align-items-center align-items-md-start text-center text-md-start animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div>
<div class="community-icon">
<img alt="" class="img-fluid" src="{{ asset('assets/images/Icon-9.png') }}"/>
</div>
</div>
<div class="d-flex flex-column">
<h4>Age-Group Categories</h4>
<p>Sub-junior, junior and senior divisions so every athlete competes against the right peers.</p>
</div>
</div>
<div class="d-flex flex-column flex-md-row gspace-2 gspace-md-5 justify-content-start justify-content-xl-between align-items-center align-items-md-start text-center text-md-start animate-box animate__animated animated-delay-slow" data-animate="animate__fadeInRight">
<div>
<div class="community-icon">
<img alt="" class="img-fluid" src="{{ asset('assets/images/Icon-10.png') }}"/>
</div>
</div>
<div class="d-flex flex-column">
<h4>Officials Development</h4>
<p>Accredited clinics for referees, scorers and technical officials across every state.</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Testimonial Section -->
<div class="section testimonial-banner">
<div class="hero-container">
<div class="d-flex flex-column gspace-5">
<div class="heading-section-container animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">Testimonials</span>
</div>
</div>
<h2>Voices from the Court</h2>
</div>
<div class="testimonial-content-container animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="testimonial-side testimonial-side--left">
<img alt="Testimonial Avatar Side" class="testimonial-avatar testimonial-avatar--lg align-self-end" src="{{ asset('assets/images/young-bearded-man-portrait-outdoors-in-the-mountai-6Z46ZMB.jpg') }}"/>
<img alt="Testimonial Avatar Side" class="testimonial-avatar testimonial-avatar--sm align-self-center" src="{{ asset('assets/images/attractive-happy-woman-in-red-dress-smiling-outdoo-UW49SNL.jpg') }}"/>
<img alt="Testimonial Avatar Side" class="testimonial-avatar testimonial-avatar--md align-self-end" src="{{ asset('assets/images/the-smile-that-city-living-gave-portrait-of-a-conf-JTBTDGD.jpg') }}"/>
</div>
<div class="card card-testimonial">
<div class="testimonial-btn-container">
<button class="testimonial-btn" id="prev" type="button">
<i class="fa-solid fa-circle-arrow-left"></i>
</button>
<button class="testimonial-btn" id="next" type="button">
<i class="fa-solid fa-circle-arrow-right"></i>
</button>
</div>
<div class="testimonial-slider">
<div class="testimonial-slider-wrapper" id="testimonial-slider">
<div class="testimonial-slide" data-index="0">
<p class="testimonial-quote">

                                            "This is by far the best federation I've ever joined. Great atmosphere, well-maintained courts, and a real sense of community. Highly recommended!"

                                        </p>
<img alt="Testimonial Avatar" class="testimonial-avatar" src="{{ asset('assets/images/young-bearded-man-portrait-outdoors-in-the-mountai-6Z46ZMB.jpg') }}"/>
<div class="d-flex flex-column align-items-center">
<span class="testimonial-name">James Miller</span>
<span class="testimonial-designation">Fitness Enthusiasts</span>
</div>
</div>
<div class="testimonial-slide" data-index="1">
<p class="testimonial-quote">

                                            "From the first visit, I felt welcomed. Booking a court is easy, and the coaching programs are top-notch. It's a great place to improve."

                                        </p>
<img alt="Testimonial Avatar" class="testimonial-avatar" src="{{ asset('assets/images/attractive-happy-woman-in-red-dress-smiling-outdoo-UW49SNL.jpg') }}"/>
<div class="d-flex flex-column align-items-center">
<span class="testimonial-name">Elena Gomez</span>
<span class="testimonial-designation">Business Consultant</span>
</div>
</div>
<div class="testimonial-slide" data-index="2">
<p class="testimonial-quote">

                                            "From the first visit, I felt welcomed. Booking a court is easy, and the coaching programs are top-notch. It's a great place to improve."

                                        </p>
<img alt="Testimonial Avatar" class="testimonial-avatar" src="{{ asset('assets/images/the-smile-that-city-living-gave-portrait-of-a-conf-JTBTDGD.jpg') }}"/>
<div class="d-flex flex-column align-items-center">
<span class="testimonial-name">Daniel Carter</span>
<span class="testimonial-designation">University Student</span>
</div>
</div>
<div class="testimonial-slide" data-index="3">
<p class="testimonial-quote">

                                            "A fantastic place to train, play, and socialize. The academy helped boost my skills, and the community is both diverse and inspiring."

                                        </p>
<img alt="Testimonial Avatar" class="testimonial-avatar" src="{{ asset('assets/images/young-asian-teenager-woman-vlog-at-home-female-usi-XHTT2JT.jpg') }}"/>
<div class="d-flex flex-column align-items-center">
<span class="testimonial-name">Sophia Bennet</span>
<span class="testimonial-designation">Marketing Executive</span>
</div>
</div>
<div class="testimonial-slide" data-index="4">
<p class="testimonial-quote">

                                            "What I love most is the flexibility and the quality of the courts. Whether you're a beginner or a pro, there's something here for everyone."

                                        </p>
<img alt="Testimonial Avatar" class="testimonial-avatar" src="{{ asset('assets/images/close-up-of-young-man-smiling-outdoors-DELEX88.jpg') }}"/>
<div class="d-flex flex-column align-items-center">
<span class="testimonial-name">Mark Tunner</span>
<span class="testimonial-designation">Software Developer</span>
</div>
</div>
<div class="testimonial-slide" data-index="5">
<p class="testimonial-quote">

                                            "JFI runs events properly, and you feel it as a player. I've attended several tournaments and always walk away with great experiences."

                                        </p>
<img alt="Testimonial Avatar" class="testimonial-avatar" src="{{ asset('assets/images/black-carefree-woman-laughing-QY76GB7.jpg') }}"/>
<div class="d-flex flex-column align-items-center">
<span class="testimonial-name">Isabella Collins</span>
<span class="testimonial-designation">Creative Director</span>
</div>
</div>
</div>
</div>
<div class="testimonial-nav-container">
<button class="testimonial-nav-btn active"></button>
<button class="testimonial-nav-btn"></button>
<button class="testimonial-nav-btn"></button>
<button class="testimonial-nav-btn"></button>
<button class="testimonial-nav-btn"></button>
<button class="testimonial-nav-btn"></button>
</div>
</div>
<div class="testimonial-side testimonial-side--right">
<img alt="Testimonial Avatar Side" class="testimonial-avatar testimonial-avatar--md align-self-start" src="{{ asset('assets/images/young-asian-teenager-woman-vlog-at-home-female-usi-XHTT2JT.jpg') }}"/>
<img alt="Testimonial Avatar Side" class="testimonial-avatar testimonial-avatar--lg align-self-center" src="{{ asset('assets/images/close-up-of-young-man-smiling-outdoors-DELEX88.jpg') }}"/>
<img alt="Testimonial Avatar Side" class="testimonial-avatar testimonial-avatar--sm align-self-start" src="{{ asset('assets/images/black-carefree-woman-laughing-QY76GB7.jpg') }}"/>
</div>
</div>
</div>
</div>
</div>
<!-- Membership CTA Section -->
<div class="section py-0">
<div class="hero-container">
<div class="row row-cols-xl-2 row-cols-1 grid-spacer-2">
<div class="col col-xl-5">
<div class="card card-membership-cta cta-content animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<h3>Register with JFI</h3>
<ul class="check-list alternative-list">
<li>Official JFI Athlete ID</li>
<li>Eligibility for State &amp; National Trials</li>
<li>Verified Competition Record</li>
<li>Access to Certified Coaching Camps</li>
</ul>
<div class="align-self-center align-self-md-start">
<a class="btn btn-accent bg-accent-color-6" href="{{ route('membership') }}">
<span class="btn-title">

                                        Start Registration

                                    </span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
<div class="col col-xl-7">
<div class="card card-membership-cta cta-benefit animate-box animate__animated animated" data-animate="animate__fadeInRight">
<p class="membership-cta-description">Registration gives every athlete an official JFI identity, a verified competition record and eligibility for sanctioned events at district, state and national level.</p>
<div class="position-relative overflow-hidden">
<div class="cta-tag-container">
<!-- You can change <span> to <a href="{{ route('service') }}"> if you want tags to be clickable -->
<span class="cta-tag">Athletes</span>
<span class="cta-tag">Coaches</span>
<span class="cta-tag">Officials</span>
</div>
<img alt="Call to Action" class="cta-benefit-img" src="{{ asset('assets/images/man-playing-padel-9KR4F3U-e1750063137155.jpg') }}"/>
<div class="cta-benefit-title">
<h4 class="secondary-accent">Athletes | Coaches | Technical Officials | State Units</h4>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Blog Section -->
<div class="section">
<div class="hero-container">
<div class="d-flex flex-column gspace-5">
<div class="blog-title-container">
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="d-flex flex-column gspace-2 justify-content-center justify-content-md-start text-center text-md-start animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">News &amp; Updates</span>
</div>
</div>
<h2>Latest from the Federation</h2>
</div>
</div>
<div class="col">
<div class="d-flex flex-column h-100 align-items-center justify-content-center align-items-md-end justify-content-md-end animate-box animate__animated animated" data-animate="animate__fadeInRight">
<a class="btn btn-accent" href="{{ route('blog') }}">
<span class="btn-title">
<span>All News</span>
</span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</div>
<div class="row row-cols-xl-3 row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="card card-blog animate-box animate__animated animated" data-animate="animate__fadeInUp">
<a href="{{ route('single-post') }}">
<div class="image-container blog-image">
<img alt="Blog Image" src="{{ asset('assets/images/tailored-indoor-padel-coaching-for-skill-enhanceme-JV5Z29N.jpg') }}"/>
<div class="blog-content">
<div class="d-flex flex-row align-items-center justify-content-start gspace-2">
<div class="meta-data">
<i class="fa-solid fa-calendar"></i>
<span>16 Jun 2025</span>
</div>
<div class="meta-data">
<i class="fa-solid fa-folder"></i>
<span>Jumpball Lifestyle</span>
</div>
</div>
<h4 class="secondary-accent">Why Joining a Jumpball Community Matters</h4>
</div>
</div>
</a>
</div>
</div>
<div class="col">
<div class="card card-blog animate-box animate__animated animated" data-animate="animate__fadeInUp">
<a href="{{ route('single-post') }}">
<div class="image-container blog-image">
<img alt="Blog Image" src="{{ asset('assets/images/portrait-of-attractive-woman-padel-tennis-player-i-NJU5BZU.jpg') }}"/>
<div class="blog-content">
<div class="d-flex flex-row align-items-center justify-content-start gspace-2">
<div class="meta-data">
<i class="fa-solid fa-calendar"></i>
<span>16 Jun 2025</span>
</div>
<div class="meta-data">
<i class="fa-solid fa-folder"></i>
<span>Events &amp; News</span>
</div>
</div>
<h4 class="secondary-accent">Venue Bookings Online: Quick &amp; Easy Guide</h4>
</div>
</div>
</a>
</div>
</div>
<div class="col">
<div class="card card-blog animate-box animate__animated animated" data-animate="animate__fadeInUp">
<a href="{{ route('single-post') }}">
<div class="image-container blog-image">
<img alt="Blog Image" src="{{ asset('assets/images/paddle-tennis-player-making-an-effort-to-while-hit-QPJDK5U.jpg') }}"/>
<div class="blog-content">
<div class="d-flex flex-row align-items-center justify-content-start gspace-2">
<div class="meta-data">
<i class="fa-solid fa-calendar"></i>
<span>16 Jun 2025</span>
</div>
<div class="meta-data">
<i class="fa-solid fa-folder"></i>
<span>Events &amp; News</span>
</div>
</div>
<h4 class="secondary-accent">Recap: JFI Spring Tournament 2025</h4>
</div>
</div>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/banner.js') }}"></script>
<script src="{{ asset('assets/js/video_embedded.js') }}"></script>
@endpush
