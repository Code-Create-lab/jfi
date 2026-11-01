@extends('layouts.app')

@section('title', 'Community')

@section('content')
<!-- Banner Inner Section -->
<div class="section-wrapper pb-0">
<div class="section-banner-inner banner-inner-community">
<div class="hero-container">
<div class="d-flex flex-column gspace-2 text-center justify-content-center">
<h1 class="secondary-accent">Community</h1>
<nav class="breadcrumb">
<a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
<span class="breadcrumb-icon">/</span>
<a class="breadcrumb-item recent">Community</a>
</nav>
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
<span class="sub-heading-title">JFI Community</span>
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
<!-- Membership CTA Section -->
<div class="section">
<div class="hero-container">
<div class="row row-cols-xl-2 row-cols-1 grid-spacer-2">
<div class="col col-xl-5">
<div class="card card-membership-cta cta-content animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<h3>Become a JFI Member Today</h3>
<ul class="check-list alternative-list">
<li>Official JFI Athlete ID</li>
<li>Free Access to Weekly Meetups</li>
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
@endsection
