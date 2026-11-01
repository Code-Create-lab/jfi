@extends('layouts.app')

@section('title', 'Venue Booking')

@section('content')
<!-- Banner Inner Section -->
<div class="section-wrapper pb-0">
<div class="section-banner-inner banner-inner-booking">
<div class="hero-container">
<div class="d-flex flex-column gspace-2 text-center justify-content-center">
<h1 class="secondary-accent">Venue Booking</h1>
<nav class="breadcrumb">
<a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
<span class="breadcrumb-icon">/</span>
<span class="breadcrumb-item recent">Venue Booking</span>
</nav>
</div>
</div>
</div>
</div>
<!-- Booking Process Section -->
<div class="section">
<div class="hero-container">
<div class="d-flex flex-column gspace-5">
<div class="booking-process-heading">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">How to Book</span>
</div>
</div>
<h2>Reserve Your Court in Seconds Play Your Game</h2>
</div>
<div class="row row-cols-xl-4 row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="card card-process">
<div class="icon">
<h4 class="accent-color mb-0">01</h4>
</div>
<div>
<h4>Select your court</h4>
<p>Indoor or outdoor courts available</p>
</div>
</div>
</div>
<div class="col">
<div class="card card-process">
<div class="icon">
<h4 class="accent-color mb-0">02</h4>
</div>
<div>
<h4>Pick a date &amp; time</h4>
<p>Real-time availability for flexible scheduling</p>
</div>
</div>
</div>
<div class="col">
<div class="card card-process">
<div class="icon">
<h4 class="accent-color mb-0">03</h4>
</div>
<div>
<h4>Add extras</h4>
<p>Choose equipment rental or request a coach (optional)</p>
</div>
</div>
</div>
<div class="col">
<div class="card card-process">
<div class="icon">
<h4 class="accent-color mb-0">04</h4>
</div>
<div>
<h4>Confirm &amp; pay</h4>
<p>Instant booking confirmation via email</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Booking Section -->
<div class="section">
<div class="hero-container">
<div class="booking-form-wrapper">
<div class="card card-booking-form">
<h3 class="secondary-accent">Book Your Court Now</h3>
<p class="accent-color-8">Fill in the form to schedule your jumpball session. Fast, secure, and convenient.</p>
<div class="underline-primary-accent"></div>
<div class="alert success hidden" id="success-message">
<span class="check-icon"><i class="fa-solid fa-2xl fa-check"></i></span>
<p>Thank you! Form submitted successfully.</p>
</div>
<div class="alert error hidden" id="error-message">
<span class="cross-icon"><i class="fa-solid fa-2xl fa-xmark"></i></span>
<p>Oops! Form submission failed. Please try again.</p>
</div>
<form action="#" class="form" id="booking-form" method="post">
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="d-flex flex-column gspace-1">
<label for="name">Full Name</label>
<input id="name" name="name" placeholder="Enter your full name" type="text"/>
</div>
</div>
<div class="col">
<div class="d-flex flex-column gspace-1">
<label for="email">Email Address</label>
<input id="email" name="email" placeholder="Enter your email address" type="email"/>
</div>
</div>
</div>
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="d-flex flex-column gspace-1">
<label for="phone">Phone Number</label>
<input id="phone" name="phone" placeholder="Your Number" type="tel"/>
</div>
</div>
<div class="col">
<div class="d-flex flex-column gspace-1">
<label for="date">Select Date</label>
<input id="date" name="date" placeholder="Choose you play date" readonly="" type="text"/>
</div>
</div>
</div>
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="d-flex flex-column gspace-1">
<label>Select Time Slot</label>
<div class="dropdown-container">
<div class="dropdown-select">
<div class="d-flex flex-row align-items-center gap-3">
<span class="selected-text">08:00 - 09:00 AM</span>
</div>
<i class="fa-solid fa-caret-down"></i>
</div>
<div class="dropdown-list">
<div class="dropdown-option" data-value="male">08:00 - 09:00 AM</div>
<div class="dropdown-option" data-value="female">09:00 - 10:00 AM</div>
<div class="dropdown-option" data-value="female">04:00 - 05:00 AM</div>
</div>
<input class="dropdown-value" id="time" name="time" type="hidden"/>
</div>
</div>
</div>
<div class="col">
<div class="d-flex flex-column gspace-1">
<label>Court Type</label>
<div class="dropdown-container">
<div class="dropdown-select">
<div class="d-flex flex-row align-items-center gap-3">
<span class="selected-text">Court Type</span>
</div>
<i class="fa-solid fa-caret-down"></i>
</div>
<div class="dropdown-list">
<div class="dropdown-option" data-value="male">Indoor Court</div>
<div class="dropdown-option" data-value="female">Outdoor Court</div>
</div>
<input class="dropdown-value" id="court" name="court" type="hidden"/>
</div>
</div>
</div>
</div>
<div class="d-flex flex-column gspace-1">
<label for="message">Additional Notes</label>
<textarea id="message" name="message" placeholder="Share any prefrencesor details..." rows="4"></textarea>
</div>
<div>
<button class="btn btn-accent" type="submit">
<span class="btn-title">Confirm Booking</span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</button>
</div>
</form>
</div>
<div class="booking-form-detail">
<div class="d-flex flex-column gspace-2">
<h3>Why Book with JFI?</h3>
<div class="underline-accent-5"></div>
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<ul class="check-list">
<li>Professional-grade courts (indoor &amp; outdoor)</li>
<li>Friendly on-site staff</li>
<li>Clean, well-maintained facilities</li>
</ul>
</div>
<div class="col">
<ul class="check-list">
<li>Flexible cancellation options</li>
<li>Easy online booking system</li>
<li>LED lighting for evening games</li>
</ul>
</div>
</div>
</div>
<div class="d-flex flex-column gspace-2">
<h3>Opening Hours</h3>
<div class="underline-accent-5"></div>
<div class="d-flex flex-column">
<h5>Monday - Friday: 08:00 AM - 10:00 PM</h5>
<h5>Saturday - Sunday: 09:00 AM - 11:00 PM</h5>
</div>
</div>
<div class="d-flex flex-column gspace-2">
<h3>Booking Rates</h3>
<div class="underline-accent-5"></div>
<div class="d-flex flex-column">
<h5>Weekday Rates: Starting from $25/hour</h5>
<h5>Weekend Rates: Starting from $35/hour</h5>
<h5>Coaching Add-on: +$20/hour</h5>
<h5>Equipment Rental: +$5/session</h5>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Contact CTA Section -->
<div class="section py-0">
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
<img alt="Contact CTA Image" class="img-fluid" src="{{ asset('assets/images/2AH2LFJ-1.png') }}"/>
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
@endsection
