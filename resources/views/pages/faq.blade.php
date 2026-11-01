@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<!-- Banner Inner Section -->
<div class="section-wrapper pb-0">
<div class="section-banner-inner banner-inner-faq">
<div class="hero-container">
<div class="d-flex flex-column gspace-2 text-center justify-content-center">
<h1 class="secondary-accent">FAQ</h1>
<nav class="breadcrumb">
<a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
<span class="breadcrumb-icon">/</span>
<span class="breadcrumb-item recent">FAQ</span>
</nav>
</div>
</div>
</div>
</div>
<!-- FAQ Section -->
<div class="section">
<div class="hero-container overflow-visible">
<div class="row row-cols-xl-2 row-cols-1 grid-spacer-2">
<div class="col col-xl-4">
<div class="faq-title-container">
<div class="d-flex flex-column gspace-2 text-center text-md-start">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">Get Answer</span>
</div>
</div>
<h2>Frequently Asked Question</h2>
</div>
</div>
</div>
<div class="col col-xl-8">
<div class="faq-wrapper">
<div class="accordion" id="faqAccordion">
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button" data-bs-target="#faq1" data-bs-toggle="collapse" type="button">

                                            What are the benefits of becoming a member at Jumpball Federation of India?

                                        </button>
</h2>
<div class="accordion-collapse collapse show" data-bs-parent="#faqAccordion" id="faq1">
<div class="accordion-body">As a member, you gain exclusive court access, professional coaching sessions, priority in events and tournaments, special discounts, and become part of a vibrant and supportive jumpball community.</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" data-bs-target="#faq2" data-bs-toggle="collapse" type="button">

                                            Can I upgrade my membership plan at any time?

                                        </button>
</h2>
<div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq2">
<div class="accordion-body">Yes, you can upgrade your membership at any time. Any remaining balance from your current plan will be applied to your new package.</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" data-bs-target="#faq3" data-bs-toggle="collapse" type="button">

                                            Is there a long-term contract required?

                                        </button>
</h2>
<div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq3">
<div class="accordion-body">No. Our membership plans are flexible, with no long-term commitments. You can cancel or renew at your convenience.</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" data-bs-target="#faq4" data-bs-toggle="collapse" type="button">

                                            What's the difference between Group Training and Private Coaching?

                                        </button>
</h2>
<div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq4">
<div class="accordion-body">Group Training sessions are held with multiple players and focus on skill-building and teamwork. Private Coaching offers personalized 1-on-1 training tailored to your individual goals.</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" data-bs-target="#faq5" data-bs-toggle="collapse" type="button">

                                            How do I book a court with my membership?

                                        </button>
</h2>
<div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq5">
<div class="accordion-body">Simply log in to your member account, select your preferred time and court, and complete the booking through our online reservation system.</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" data-bs-target="#faq6" data-bs-toggle="collapse" type="button">

                                            Does membership include access to tournaments or events?

                                        </button>
</h2>
<div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq6">
<div class="accordion-body">Yes, Standard and Elite members receive free or priority access to exclusive tournaments, leagues, and club events.</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" data-bs-target="#faq7" data-bs-toggle="collapse" type="button">

                                            Can I freeze my membership temporarily?

                                        </button>
</h2>
<div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq7">
<div class="accordion-body">Yes, you can pause your membership for up to 30 days per year. Just contact our support team to request a temporary hold.</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" data-bs-target="#faq8" data-bs-toggle="collapse" type="button">

                                            Are gym and lounge facilities included in the membership?

                                        </button>
</h2>
<div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq8">
<div class="accordion-body">These facilities are included with the Elite Membership. Other members can add them as optional extras.</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" data-bs-target="#faq9" data-bs-toggle="collapse" type="button">

                                            Do you offer memberships for kids or students?

                                        </button>
</h2>
<div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq9">
<div class="accordion-body">Yes, we offer discounted plans for students and juniors, including access to our training academy. Contact us for more details.</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" data-bs-target="#faq10" data-bs-toggle="collapse" type="button">

                                            How do I cancel my membership?

                                        </button>
</h2>
<div class="accordion-collapse collapse" data-bs-parent="#faqAccordion" id="faq10">
<div class="accordion-body">You can cancel your membership anytime through your account dashboard or by contacting our customer support team directly.</div>
</div>
</div>
</div>
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
<span class="sub-heading-title">Blog &amp; Tips</span>
</div>
</div>
<h2>Latest from the Federation</h2>
</div>
</div>
<div class="col">
<div class="d-flex flex-column h-100 align-items-center justify-content-center align-items-md-end justify-content-md-end animate-box animate__animated animated" data-animate="animate__fadeInRight">
<a class="btn btn-accent" href="{{ route('blog') }}">
<span class="btn-title">
<span>Read More</span>
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
