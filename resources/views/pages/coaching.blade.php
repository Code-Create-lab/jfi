@extends('layouts.app')

@section('title', 'Coaching / Academy')

@section('content')
<!-- Banner Inner Section -->
<div class="section-wrapper pb-0">
<div class="section-banner-inner banner-inner-coaching">
<div class="hero-container">
<div class="d-flex flex-column gspace-2 text-center justify-content-center">
<h1 class="secondary-accent">Coaching</h1>
<nav class="breadcrumb">
<a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
<span class="breadcrumb-icon">/</span>
<span class="breadcrumb-item recent">Coaching</span>
</nav>
</div>
</div>
</div>
</div>
<!-- Team Page Section -->
<div class="section">
<div class="hero-container">
<div class="d-flex flex-column gspace-5">
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="d-flex flex-column gspace-2 justify-content-center justify-content-md- text-md-start text-center animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">Our Coaching</span>
</div>
</div>
<h2>Meet Our Coaching Team</h2>
</div>
</div>
<div class="col">
<div class="d-flex flex-column h-100 align-items-center align-items-md-end justify-content-center justify-content-md-end animate-box animate__animated animated" data-animate="animate__fadeInRight">
<a class="btn btn-accent" href="#">
<span class="btn-title">

                                        Explore Academy Programs

                                    </span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
<div class="row row-cols-xl-4 row-cols-md-2 row-cols-1 grid-spacer-2">
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
<img alt="Team Image" src="{{ asset('assets/images/ImageGen-5-853x1024.jpg') }}"/>
<div class="card-team-wrapper">
<div class="card-team-content">
<h4 class="secondary-accent">Javier Costa</h4>
<h6 class="secondary-accent">Junior Development</h6>
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
<img alt="Team Image" src="{{ asset('assets/images/ImageGen-3-853x1024.jpg') }}"/>
<div class="card-team-wrapper">
<div class="card-team-content">
<h4 class="secondary-accent">Chloe Bennett</h4>
<h6 class="secondary-accent">Technique &amp; Skills</h6>
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
<img alt="Team Image" src="{{ asset('assets/images/ImageGen-1-853x1024.jpg') }}"/>
<div class="card-team-wrapper">
<div class="card-team-content">
<h4 class="secondary-accent">Lucas Nguyen</h4>
<h6 class="secondary-accent">Recreational Program</h6>
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
<img alt="Team Image" src="{{ asset('assets/images/ImageGen-8-853x1024.jpg') }}"/>
<div class="card-team-wrapper">
<div class="card-team-content">
<h4 class="secondary-accent">Maya Fernández</h4>
<h6 class="secondary-accent">Women's Training</h6>
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
<img alt="Contact CTA Image" src="{{ asset('assets/images/2AH2LFJ-1.png') }}"/>
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
