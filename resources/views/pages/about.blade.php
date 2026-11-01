@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<!-- Banner Inner Section -->
<div class="section-wrapper pb-0">
<div class="section-banner-inner banner-inner-about">
<div class="hero-container">
<div class="d-flex flex-column gspace-2 text-center justify-content-center">
<h1 class="secondary-accent">About Us</h1>
<nav class="breadcrumb">
<a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
<span class="breadcrumb-icon">/</span>
<span class="breadcrumb-item recent">About Us</span>
</nav>
</div>
</div>
</div>
</div>
<!-- About Welcome Section -->
<div class="section">
<div class="hero-container">
<div class="d-flex flex-column gspace-5 overflow-hidden">
<div class="welcome-about-wrapper">
<div class="d-flex flex-column gspace-2 text-center text-md-start align-items-center align-items-md-start">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">Welcome to JFI</span>
</div>
</div>
<h2>The Home of Jumpball in India</h2>
</div>
<div class="d-flex flex-column justify-content-end h-100">
<h4 class="text-center text-md-start">At Jumpball Federation of India, we are more than an administrative body. We are the athletes, coaches, officials and state units who share responsibility for the sport. Our job is to make sure every one of them plays, coaches and officiates to the same national standard.</h4>
</div>
</div>
<div class="row row-cols-xl-4 row-cols-md-2 row-cols-1 grid-spacer-2 align-items-end">
<div class="col">
<div class="card card-about-misson card-about-mission--courth">
<div class="image-container">
<img alt="" src="{{ asset('assets/images/portrait-of-attractive-woman-padel-tennis-player-i-NJU5BZU.jpg') }}"/>
</div>
<div class="card-content">
<h4>Rules &amp; Competition</h4>
<p>Official rules, match regulations and the national competition calendar.</p>
</div>
</div>
</div>
<div class="col">
<div class="card card-about-misson card-about-mission--academy">
<div class="image-container">
<img alt="" src="{{ asset('assets/images/monitor-teaching-padel-class-RQUY73T.jpg') }}"/>
</div>
<div class="card-content">
<h4>Coaching &amp; Education</h4>
<p>Coach education, referee clinics and a common national syllabus.</p>
</div>
</div>
</div>
<div class="col">
<div class="card card-about-misson card-about-mission--tournament">
<div class="image-container">
<img alt="" src="{{ asset('assets/images/black-athletic-woman-playing-padel-doubles-on-outd-8U5QAM8.jpg') }}"/>
</div>
<div class="card-content">
<h4>State Affiliation</h4>
<p>Recognition and support for state and district associations.</p>
</div>
</div>
</div>
<div class="col">
<div class="card card-about-misson card-about-mission--membership">
<div class="image-container">
<img alt="" src="{{ asset('assets/images/multiracial-group-of-happy-friends-leaving-the-cou-CNDKVTB.jpg') }}"/>
</div>
<div class="card-content">
<h4 class="secondary-accent">
Athlete<br/>Registration</h4>
<p class="secondary-accent">An official JFI ID and eligibility for sanctioned events.</p>
</div>
</div>
</div>
</div>
<div class="partnership-container">
<div class="swiper swiperpartner">
<div class="swiper-wrapper">
<div class="swiper-slide">
<img alt="" class="img-fluid partner-img" src="{{ asset('assets/images/Client-1.png') }}"/>
</div>
<div class="swiper-slide">
<img alt="" class="img-fluid partner-img" src="{{ asset('assets/images/Client-2.png') }}"/>
</div>
<div class="swiper-slide">
<img alt="" class="img-fluid partner-img" src="{{ asset('assets/images/Client-3.png') }}"/>
</div>
<div class="swiper-slide">
<img alt="" class="img-fluid partner-img" src="{{ asset('assets/images/Client-4.png') }}"/>
</div>
<div class="swiper-slide">
<img alt="" class="img-fluid partner-img" src="{{ asset('assets/images/Client-6.png') }}"/>
</div>
<div class="swiper-slide">
<img alt="" class="img-fluid partner-img" src="{{ asset('assets/images/Client-7.png') }}"/>
</div>
<div class="swiper-slide">
<img alt="" class="img-fluid partner-img" src="{{ asset('assets/images/Client-8.png') }}"/>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- About Section -->
<div class="section pt-0">
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
<span class="sub-heading-title">About Us</span>
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
<!-- Membership CTA Section -->
<div class="section pb-0">
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
<!-- Team Section -->
<div class="section pt-0">
<div class="hero-container">
<div class="team-content-wrapper">
<div class="team-card-container">
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="card card-team">
<div class="image-container team-img">
<img alt="Team Image" src="{{ asset('assets/images/ImageGen-7-853x1024.jpg') }}"/>
<div class="card-team-wrapper">
<div class="card-team-content">
<h4 class="secondary-accent">Alex Romeo</h4>
<h6 class="secondary-accent">Head Coach</h6>
<div class="d-flex flex-row align-items-center gspace-1">
<a class="social-icon" href="#">
<i class="fa-brands fa-instagram"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-facebook"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-twitter"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-youtube"></i>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col">
<div class="card card-team">
<div class="image-container team-img">
<img alt="Team Image" src="{{ asset('assets/images/ImageGen-2-853x1024.jpg') }}"/>
<div class="card-team-wrapper">
<div class="card-team-content">
<h4 class="secondary-accent">Sofia Delgado</h4>
<h6 class="secondary-accent">Senior Jumpball Trainer</h6>
<div class="d-flex flex-row align-items-center gspace-1">
<a class="social-icon" href="#">
<i class="fa-brands fa-instagram"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-facebook"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-twitter"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-youtube"></i>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col">
<div class="card card-team">
<div class="image-container team-img">
<img alt="Team Image" src="{{ asset('assets/images/ImageGen-4-853x1024.jpg') }}"/>
<div class="card-team-wrapper">
<div class="card-team-content">
<h4 class="secondary-accent">Isabelle Caron</h4>
<h6 class="secondary-accent">Fitness &amp; Conditioning</h6>
<div class="d-flex flex-row align-items-center gspace-1">
<a class="social-icon" href="#">
<i class="fa-brands fa-instagram"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-facebook"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-twitter"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-youtube"></i>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col">
<div class="card card-team">
<div class="image-container team-img">
<img alt="Team Image" src="{{ asset('assets/images/ImageGen-6-853x1024.jpg') }}"/>
<div class="card-team-wrapper">
<div class="card-team-content">
<h4 class="secondary-accent">Mateo Vargas</h4>
<h6 class="secondary-accent">Tournament Strategy</h6>
<div class="d-flex flex-row align-items-center gspace-1">
<a class="social-icon" href="#">
<i class="fa-brands fa-instagram"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-facebook"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-twitter"></i>
</a>
<a class="social-icon" href="#">
<i class="fa-brands fa-youtube"></i>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="team-title-wrapper">
<div class="team-title-container">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">Our Coaching</span>
</div>
</div>
<h2>Meet Our Coaching Team</h2>
<p>Each member of our team brings world-class expertise, a love for jumpball, and a commitment to helping players of all levels grow and succeed on the court.</p>
<div>
<a class="btn btn-accent animate-box animate__animated animated" data-animate="animate__fadeInRight" href="{{ route('coaching') }}">
<span class="btn-title">Meet Our Coaching</span>
<i class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</i>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
