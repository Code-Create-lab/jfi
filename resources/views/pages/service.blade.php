@extends('layouts.app')

@section('title', 'Our Services')

@section('content')
<!-- Banner Inner Section -->
<div class="section-wrapper pb-0">
<div class="section-banner-inner banner-inner-service">
<div class="hero-container">
<div class="d-flex flex-column gspace-2 text-center justify-content-center">
<h1 class="secondary-accent">Our Services</h1>
<nav class="breadcrumb">
<a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
<span class="breadcrumb-icon">/</span>
<span class="breadcrumb-item recent">Services</span>
</nav>
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
<span class="sub-heading-title">Our Service</span>
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
<img alt="" class="img-fluid" src="{{ asset('assets/images/Icon-5.png') }}"/>
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
<img alt="" class="img-fluid" src="{{ asset('assets/images/Icon-6.png') }}"/>
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
<img alt="" class="img-fluid" src="{{ asset('assets/images/Icon-7.png') }}"/>
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
<img alt="" class="img-fluid" src="{{ asset('assets/images/Icon-8.png') }}"/>
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
<div class="col">
<div class="card card-service animate-box animate__animated animated-delay-fast" data-animate="animate__fadeInRight">
<div class="image-container">
<div class="service-icon-container">
<div class="service-icon">
<img alt="" class="img-fluid" src="{{ asset('assets/images/Icon-1.png') }}"/>
</div>
</div>
<img alt="Service Image" class="service-img" src="{{ asset('assets/images/man-playing-padel-4E8WZX7.jpg') }}"/>
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
<div class="col">
<div class="card card-service animate-box animate__animated animated" data-animate="animate__fadeInRight">
<div class="image-container">
<div class="service-icon-container">
<div class="service-icon">
<img alt="" class="img-fluid" src="{{ asset('assets/images/Icon-2.png') }}"/>
</div>
</div>
<img alt="Service Image" class="service-img" src="{{ asset('assets/images/portrait-of-two-smiling-sportsmans-posing-on-padel-V3NLU7F.jpg') }}"/>
<div class="service-detail-container">
<div class="service-detail">
<h4 class="secondary-accent">Community &amp; Social Events</h4>
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
<img alt="" class="img-fluid" src="{{ asset('assets/images/Icon-3.png') }}"/>
</div>
</div>
<img alt="Service Image" class="service-img" src="{{ asset('assets/images/man-trying-to-reach-the-ball-playing-pickleball-9W7DN8G.jpg') }}"/>
<div class="service-detail-container">
<div class="service-detail">
<h4 class="secondary-accent">Kids &amp; Youth Programs</h4>
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
<img alt="" class="img-fluid" src="{{ asset('assets/images/Icon-4.png') }}"/>
</div>
</div>
<img alt="Service Image" class="service-img" src="{{ asset('assets/images/happy-women-having-fun-while-playing-paddle-tennis-FXTHC9A.jpg') }}"/>
<div class="service-detail-container">
<div class="service-detail">
<h4 class="secondary-accent">Equipment Rental</h4>
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
<!-- Membership CTA Section -->
<div class="section pt-0">
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
<!-- Pricing Section -->
<div class="section-wrapper">
<div class="section section-pricing">
<div class="hero-container">
<div class="d-flex flex-column gspace-5">
<div class="heading-section-container pricing-heading">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">Membership Package</span>
</div>
</div>
<h2 class="secondary-accent">Choose the Membership that Fits your Goals</h2>
</div>
<div class="row row-cols-xl-3 row-cols-1 grid-spacer-2">
<div class="col">
<div class="card card-pricing">
<div class="d-flex flex-row align-items-center justify-content-between">
<h4 class="secondary-accent">Basic</h4>
<d-flex class="price-container">
<h5 class="price-currency">$</h5>
<h3 class="price">29</h3>
<h6 class="pricing-details">/ Month</h6>
</d-flex>
</div>
<p class="secondary-accent">Perfect for casual players who want to enjoy the court without commitment.</p>
<div class="underline-pricing"></div>
<ul class="pricing-benefit-list">
<li>4 Court Hours / Month</li>
<li>1 Group Training Session</li>
<li>Access to Community Events</li>
<li>Club Newsletter Subscription</li>
<li>Standard Booking Access</li>
<li>Member ID &amp; Digital Pass</li>
</ul>
<div class="underline-pricing"></div>
<a class="btn btn-accent d-flex justify-content-between align-items-center w-100" href="#">
<span class="btn-title mx-auto text-center flex-grow-1">

                                            Join Now

                                        </span>
<span class="icon-circle ms-auto">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
<div class="col">
<div class="card card-pricing">
<div class="d-flex flex-row align-items-center justify-content-between">
<h4 class="secondary-accent">Standart</h4>
<d-flex class="price-container">
<h5 class="price-currency">$</h5>
<h3 class="price">49</h3>
<h6 class="pricing-details">/ Month</h6>
</d-flex>
</div>
<p class="secondary-accent">Ideal for regular players seeking balance between play and progress.</p>
<div class="underline-pricing"></div>
<ul class="pricing-benefit-list">
<li>8 Court Hours / Month</li>
<li>2 Group Training Session</li>
<li>Official JFI Athlete ID</li>
<li>Access to Member Only Tournaments</li>
<li>Community Forum Access</li>
<li>10% Off Coaching Packages</li>
</ul>
<div class="underline-pricing"></div>
<a class="btn btn-accent d-flex justify-content-between align-items-center w-100" href="#">
<span class="btn-title mx-auto text-center flex-grow-1">

                                            Join Now

                                        </span>
<span class="icon-circle ms-auto">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
<div class="col">
<div class="card card-pricing">
<div class="d-flex flex-row align-items-center justify-content-between">
<h4 class="secondary-accent">Elite</h4>
<d-flex class="price-container">
<h5 class="price-currency">$</h5>
<h3 class="price">89</h3>
<h6 class="pricing-details">/ Month</h6>
</d-flex>
</div>
<p class="secondary-accent">For passionate jumpball players who want the full experience with exclusive benefits.</p>
<div class="underline-pricing"></div>
<ul class="pricing-benefit-list">
<li>Unlimited Court Access</li>
<li>4 Group Training Session</li>
<li>VIP Booking Priority</li>
<li>Exclusive Tournament Invitations</li>
<li>Access to Members Lounge</li>
<li>15% Off Merchandise &amp; Coaching</li>
</ul>
<div class="underline-pricing"></div>
<a class="btn btn-accent d-flex justify-content-between align-items-center w-100" href="#">
<span class="btn-title mx-auto text-center flex-grow-1">

                                            Join Now

                                        </span>
<span class="icon-circle ms-auto">
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
<!-- Contact CTA Section -->
<div class="section pt-0">
<div class="hero-container">
<div class="card card-contact-cta">
<div class="contact-cta-content">
<h2 class="primary-accent">Ready to Train with the Best?</h2>
<p class="primary-accent">Whether you're picking up a racquet for the first time or aiming for pro tournaments, our coaches are here to support your journey.</p>
<div>
<a class="btn btn-accent bg-accent-color-6" href="{{ route('membership') }}">
<span class="btn-title">Book a Tiral Session</span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
<div class="contact-cta-image">
<div class="image-wrapper">
<img alt="Contact CTA Image" src="{{ asset('assets/images/2AH2LFJ-1.png') }}"/>
</div>
</div>
</div>
</div>
</div>
@endsection
