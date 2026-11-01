@extends('layouts.app')

@section('title', 'Blog / News')

@section('content')
<!-- Banner Inner Section -->
<div class="section-wrapper pb-0">
<div class="section-banner-inner banner-inner-blog">
<div class="hero-container">
<div class="d-flex flex-column gspace-2 text-center justify-content-center">
<h1 class="secondary-accent">News &amp; Articles</h1>
<nav class="breadcrumb">
<a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
<span class="breadcrumb-icon">/</span>
<span class="breadcrumb-item recent">Blog</span>
</nav>
</div>
</div>
</div>
</div>
<!-- Blog Page Section -->
<div class="section">
<div class="hero-container">
<div class="post-content-wrapper">
<div class="post-main-content">
<div class="d-flex flex-column gspace-2">
<div class="card card-blog card-blog-post">
<div class="image-container">
<img alt="Blog Image" src="{{ asset('assets/images/monitor-teaching-padel-class-RQUY73T.jpg') }}"/>
</div>
<div class="blog-post-body">
<div class="d-flex flex-row align-items-center gspace-2">
<div class="d-flex flex-row align-items-center gspace-1">
<i class="fa-solid fa-calendar"></i>
<span class="post-meta-data">June 16, 2025</span>
</div>
<div class="d-flex flex-row align-items-center gspace-1">
<i class="fa-solid fa-folder"></i>
<span class="post-meta-data">Jumpball Lifestyle</span>
</div>
</div>
<a class="blog-title" href="{{ route('single-post') }}">Inside JFI: Our Latest Club Facilities</a>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sed sapien a massa fringilla malesuada. Donec mauris libero, sollicitudin eget elit in, interdum egestas dui. Maecenas facilisis fermentum lorem vitae pretium. Donec ac nunc vehicula, vulputate felis a, eleifend quam.…</p>
</div>
</div>
<div class="card card-blog card-blog-post">
<div class="image-container">
<img alt="Blog Image" src="{{ asset('assets/images/mixed-adult-couple-palying-padel-on-outdoor-court-TT64K26.jpg') }}"/>
</div>
<div class="blog-post-body">
<div class="d-flex flex-row align-items-center gspace-2">
<div class="d-flex flex-row align-items-center gspace-1">
<i class="fa-solid fa-calendar"></i>
<span class="post-meta-data">June 16, 2025</span>
</div>
<div class="d-flex flex-row align-items-center gspace-1">
<i class="fa-solid fa-folder"></i>
<span class="post-meta-data">Training &amp; Technique</span>
</div>
</div>
<a class="blog-title" href="{{ route('single-post') }}">Top 5 Warm-up Exercises Before Hitting the Court</a>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sed sapien a massa fringilla malesuada. Donec mauris libero, sollicitudin eget elit in, interdum egestas dui. Maecenas facilisis fermentum lorem vitae pretium. Donec ac nunc vehicula, vulputate felis a, eleifend quam.…</p>
</div>
</div>
<div class="card card-blog card-blog-post">
<div class="image-container">
<img alt="Blog Image" src="{{ asset('assets/images/black-athletic-woman-playing-padel-doubles-on-outd-8U5QAM8.jpg') }}"/>
</div>
<div class="blog-post-body">
<div class="d-flex flex-row align-items-center gspace-2">
<div class="d-flex flex-row align-items-center gspace-1">
<i class="fa-solid fa-calendar"></i>
<span class="post-meta-data">June 16, 2025</span>
</div>
<div class="d-flex flex-row align-items-center gspace-1">
<i class="fa-solid fa-folder"></i>
<span class="post-meta-data">Jumpball Lifestyle</span>
</div>
</div>
<a class="blog-title" href="#">How to Choose the Right Jumpball Racket</a>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sed sapien a massa fringilla malesuada. Donec mauris libero, sollicitudin eget elit in, interdum egestas dui. Maecenas facilisis fermentum lorem vitae pretium. Donec ac nunc vehicula, vulputate felis a, eleifend quam.…</p>
</div>
</div>
<div class="card card-blog card-blog-post">
<div class="image-container">
<img alt="Blog Image" src="{{ asset('assets/images/balls-near-the-net-of-a-blue-padel-tennis-court-MWN78HZ.jpg') }}"/>
</div>
<div class="blog-post-body">
<div class="d-flex flex-row align-items-center gspace-2">
<div class="d-flex flex-row align-items-center gspace-1">
<i class="fa-solid fa-calendar"></i>
<span class="post-meta-data">June 16, 2025</span>
</div>
<div class="d-flex flex-row align-items-center gspace-1">
<i class="fa-solid fa-folder"></i>
<span class="post-meta-data">Training &amp; Technique</span>
</div>
</div>
<a class="blog-title" href="{{ route('single-post') }}">Mastering the Basics: Jumpball Tips for Beginners</a>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sed sapien a massa fringilla malesuada. Donec mauris libero, sollicitudin eget elit in, interdum egestas dui. Maecenas facilisis fermentum lorem vitae pretium. Donec ac nunc vehicula, vulputate felis a, eleifend quam.…</p>
</div>
</div>
</div>
</div>
<!-- Blog Sidebar -->
<div class="post-sidebar-wrapper">
<div class="card card-blog-category">
<h3 class="secondary-accent">Category</h3>
<div class="underline-primary-accent"></div>
<ul class="chevron-circle-list">
<li><a href="#">Jumpball Lifestyle</a></li>
<li><a href="#">Training &amp; Technique</a></li>
<li><a href="#">Event &amp; News</a></li>
</ul>
</div>
<div class="card card-blog-recent">
<h3 class="secondary-accent">Recent Post</h3>
<div class="underline-primary-accent"></div>
<div class="recent-post-list">
<div class="recent-post-item">
<div class="recent-post-thumb">
<div class="image-container recent-post-image">
<img alt="Recent Post" class="img-fluid" src="{{ asset('assets/images/tailored-indoor-padel-coaching-for-skill-enhanceme-JV5Z29N.jpg') }}"/>
</div>
</div>
<div class="recent-post-body">
<div class="recent-post-meta">
<i class="fa-solid fa-calendar accent-color-2"></i>
<span class="meta-data">16 Jun 2025</span>
</div>
<a class="recent-post-title" href="{{ route('single-post') }}">Why Joining a Jumpball Community Matters</a>
</div>
</div>
<div class="recent-post-item">
<div class="recent-post-thumb">
<div class="image-container recent-post-image">
<img alt="Recent Post" class="img-fluid" src="{{ asset('assets/images/portrait-of-attractive-woman-padel-tennis-player-i-NJU5BZU.jpg') }}"/>
</div>
</div>
<div class="recent-post-body">
<div class="recent-post-meta">
<i class="fa-solid fa-calendar accent-color-2"></i>
<span class="meta-data">16 Jun 2025</span>
</div>
<a class="recent-post-title" href="{{ route('single-post') }}">Venue Bookings Online: Quick &amp; Easy Guide</a>
</div>
</div>
<div class="recent-post-item">
<div class="recent-post-thumb">
<div class="image-container recent-post-image">
<img alt="Recent Post" class="img-fluid" src="{{ asset('assets/images/paddle-tennis-racket-and-ball-3SXRR2Z.jpg') }}"/>
</div>
</div>
<div class="recent-post-body">
<div class="recent-post-meta">
<i class="fa-solid fa-calendar accent-color-2"></i>
<span class="meta-data">16 Jun 2025</span>
</div>
<a class="recent-post-title" href="{{ route('single-post') }}">Recap: JFI Spring Tournament 2025</a>
</div>
</div>
<div class="recent-post-item">
<div class="recent-post-thumb">
<div class="image-container recent-post-image">
<img alt="Recent Post" class="img-fluid" src="{{ asset('assets/images/one-women-playing-paddle-tennis-PVGGBJL.jpg') }}"/>
</div>
</div>
<div class="recent-post-body">
<div class="recent-post-meta">
<i class="fa-solid fa-calendar accent-color-2"></i>
<span class="meta-data">16 Jun 2025</span>
</div>
<a class="recent-post-title" href="{{ route('single-post') }}">Improve Your Jumpball Like a Pro</a>
</div>
</div>
</div>
</div>
<div class="card card-blog-tag">
<h3 class="secondary-accent">Tags</h3>
<div class="underline-primary-accent"></div>
<div class="blog-tag-container animate-box animate__animated animated" data-animate="animate__fadeInLeft">
<!-- You can change <span> to <a href="{{ route('service') }}"> if you want tags to be clickable -->
<span class="blog-tag">Jumpball Tips</span>
<span class="blog-tag">Registration</span>
<span class="blog-tag">Fitness Goals</span>
<span class="blog-tag">Game Strategy</span>
<span class="blog-tag">Club News</span>
<span class="blog-tag">Jumpball Events</span>
<span class="blog-tag">Beginner Guide</span>
<span class="blog-tag">Team Play</span>
<span class="blog-tag">Community Life</span>
</div>
</div>
<div class="card card-contact-cta cta-small-banner">
<h3 class="primary-accent">Want More Tips &amp; Updates?</h3>
<p class="primary-accent">Join our newsletter and stay updated with the latest jumpball articles, exclusive offers, and club events.</p>
<a class="cta-link" href="{{ route('contact') }}">
<span>Subscribe Now</span>
<i class="fa-solid fa-chevron-circle-right"></i>
</a>
<div class="cta-image">
<div class="cta-image-container">
<img alt="Contact CTA" src="{{ asset('assets/images/2AH2LFJ-1.png') }}"/>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
