@extends('layouts.app')

@section('title', 'Membership & Affiliation')

@section('content')
<!-- Banner Inner Section -->
<div class="section-wrapper pb-0">
<div class="section-banner-inner banner-inner-membership">
<div class="hero-container">
<div class="d-flex flex-column gspace-2 text-center justify-content-center">
<h1 class="secondary-accent">Join Our Club</h1>
<nav class="breadcrumb">
<a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
<span class="breadcrumb-icon">/</span>
<span class="breadcrumb-item recent">Membership</span>
</nav>
</div>
</div>
</div>
</div>
<!-- Membership Benefit Section -->
<div class="section">
<div class="hero-container overflow-hidden">
<div class="row row-cols-xl-2 row-cols-1 grid-spacer-5 grid-spacer-xl-100">
<div class="col order-2 order-xl-1">
<div class="d-flex flex-column gspace-2">
<div class="card card-benefit">
<div>
<div class="benefit-number">
<h4>01</h4>
</div>
</div>
<div class="d-flex flex-column gspcace-2 text-center text-md-start">
<h4>Priority Court Access</h4>
<p>Book your favorite court slots in advance in venenatis diam euismod et donec ipsum velit semper eu magna.</p>
</div>
</div>
<div class="card card-benefit">
<div>
<div class="benefit-number">
<h4>02</h4>
</div>
</div>
<div class="d-flex flex-column gspcace-2 text-center text-md-start">
<h4>Free Group Access</h4>
<p>Join weekly training sessions and sharpen your skills in venenatis diam euismod et donec ipsum.</p>
</div>
</div>
<div class="card card-benefit">
<div>
<div class="benefit-number">
<h4>03</h4>
</div>
</div>
<div class="d-flex flex-column gspcace-2 text-center text-md-start">
<h4>Members Only Tournaments</h4>
<p>Compete in exclusive club competitions in venenatis diam euismod et donec ipsum velit semper eu magna.</p>
</div>
</div>
<div class="card card-benefit">
<div>
<div class="benefit-number">
<h4>04</h4>
</div>
</div>
<div class="d-flex flex-column gspcace-2 text-center text-md-start">
<h4>Club Lounge Access</h4>
<p>Relax, connect, and network with other members in venenatis diam euismod et donec ipsum.</p>
</div>
</div>
<div class="card card-benefit">
<div>
<div class="benefit-number">
<h4>05</h4>
</div>
</div>
<div class="d-flex flex-column gspcace-2 text-center text-md-start">
<h4>Special Discounts</h4>
<p>Enjoy offers on coaching packages and merchandise in venenatis diam euismod et donec ipsum.</p>
</div>
</div>
</div>
</div>
<div class="col order-1 order-xl-2">
<div class="d-flex flex-column gspace-2 text-center text-md-start">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">Why Join JFI</span>
</div>
</div>
<h2>Be Part of an Exclusive Jumpball Community.</h2>
<p>

                                Whether you're a beginner or a seasoned player, Jumpball Federation of India offers a premium membership experience designed to elevate your game. Gain full access to world-class facilities, professional coaching, exclusive tournaments, and a vibrant community of jumpball enthusiasts.

                            </p>
<div class="image-container animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<img alt="Why Choose Us" class="benefit-img" src="{{ asset('assets/images/multiracial-group-of-athletes-going-for-an-outdoor-ZAZBUZY-1024x683.jpg') }}"/>
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
</div>
</div>
</div>
</div>
<!-- Pricing Section -->
<div class="section-wrapper py-0">
<div class="section section-pricing">
<div class="hero-container overflow-hidden">
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
@endsection
