@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<!-- Banner Inner Section -->
<div class="section-wrapper pb-0">
<div class="section-banner-inner banner-inner-contact">
<div class="hero-container">
<div class="d-flex flex-column gspace-2 text-center justify-content-center">
<h1 class="secondary-accent">Get in Touch</h1>
<nav class="breadcrumb">
<a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
<span class="breadcrumb-icon">/</span>
<span class="breadcrumb-item recent">Contact Us</span>
</nav>
</div>
</div>
</div>
</div>
<!-- Contact Section -->
<div class="section">
<div class="hero-container overflow-hidden">
<div class="row row-cols-xl-2 row-cols-1 grid-spacer-5 grid-spacer-xl-100">
<div class="col">
<div class="d-flex flex-column gspace-5">
<div class="d-flex flex-column gspace-2">
<div>
<div class="sub-heading">
<i class="fa-solid fa-circle accent-color-2"></i>
<span class="sub-heading-title">We're Here to Help!</span>
</div>
</div>
<h2>Get in Touch with Jumpball Federation of India</h2>
<p>Whether you're ready to book a court, join our club, or simply have a question, our team is always available to assist you. Connect with us today and be part of the growing jumpball community.</p>
</div>
<div class="d-flex flex-column gspace-2">
<div class="d-flex flex-row gspace-2 align-items-start">
<div>
<div class="contact-icon">
<i class="fa-solid fa-phone-volume"></i>
</div>
</div>
<div class="d-flex flex-column">
<h6 class="contact-info-heading">Phone Number</h6>
<h4>+91 00000 00000</h4>
</div>
</div>
<div class="d-flex flex-row gspace-1 align-items-start">
<div>
<div class="contact-icon">
<i class="fa-solid fa-envelope"></i>
</div>
</div>
<div class="d-flex flex-column">
<h6 class="contact-info-heading">Email Address</h6>
<h4>info@jfi.org.in</h4>
</div>
</div>
<div class="d-flex flex-row gspace-1 align-items-start">
<div>
<div class="contact-icon">
<i class="fa-solid fa-clock"></i>
</div>
</div>
<div class="d-flex flex-column">
<h6 class="contact-info-heading">Opening Hours</h6>
<h4>Mon - Fri: 08:00 AM - 10:00 PM</h4>
<h4>Sat - Sun: 09:00 AM - 11:00 PM</h4>
</div>
</div>
</div>
</div>
</div>
<div class="col">
<div class="card card-contact-form">
<h3 class="secondary-accent">Send Us a Message</h3>
<p class="accent-color-8">Have questions, booking inquiries, or feedback? Fill out the form below and our team will respond within 24 hours.</p>
<div class="alert success hidden" id="success-message">
<span class="check-icon"><i class="fa-solid fa-2xl fa-check"></i></span>
<p>Thank you! Form submitted successfully.</p>
</div>
<div class="alert error hidden" id="error-message">
<span class="cross-icon"><i class="fa-solid fa-2xl fa-xmark"></i></span>
<p>Oops! Form submission failed. Please try again.</p>
</div>
<form action="#" class="form" id="contact-form" method="post">
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="d-flex flex-column gspace-1">
<label for="name">Full Name</label>
<input id="name" name="name" placeholder="Your Name" type="text"/>
</div>
</div>
<div class="col">
<div class="d-flex flex-column gspace-1">
<label for="email">Email Address</label>
<input id="email" name="email" placeholder="Your Email" type="email"/>
</div>
</div>
</div>
<div class="row row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="d-flex flex-column gspace-1">
<label for="phone">Phone Number</label>
<input id="phone" name="phone" placeholder="Your Phone" type="tel"/>
</div>
</div>
<div class="col">
<div class="d-flex flex-column gspace-1">
<label for="subject">Your Subject</label>
<input id="subject" name="subject" placeholder="Your Subject" type="text"/>
</div>
</div>
</div>
<div class="d-flex flex-column gspace-2">
<label for="message">Messages</label>
<textarea id="message" name="message" placeholder="Your Message" rows="4"></textarea>
</div>
<div>
<button class="btn btn-accent" type="submit">
<span class="btn-title">Send Messages</span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<!-- Maps Section -->
<div class="section py-0">
<div class="hero-container">
<iframe aria-label="London Eye, London, United Kingdom" class="maps" loading="lazy" src="https://maps.google.com/maps?q=London%20Eye%2C%20London%2C%20United%20Kingdom&amp;t=m&amp;z=14&amp;output=embed&amp;iwloc=near" title="London Eye, London, United Kingdom">
</iframe>
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
@endsection
