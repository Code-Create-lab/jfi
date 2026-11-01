@extends('layouts.app')

@section('title', 'Single Post')

@section('content')
<!-- Banner Inner Section -->
<div class="section-wrapper pb-0">
<div class="section-banner-inner banner-inner-single-post">
<div class="hero-container">
<div class="d-flex flex-column gspace-2 text-center justify-content-center">
<h1 class="secondary-accent">Single Post</h1>
<nav class="breadcrumb">
<a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
<span class="breadcrumb-icon">/</span>
<span class="breadcrumb-item recent">Single Post</span>
</nav>
</div>
</div>
</div>
</div>
<!-- Main Post Section -->
<div class="section">
<div class="hero-container">
<div class="post-content-wrapper">
<div class="post-main-content">
<div class="image-container">
<img alt="Post Image" src="{{ asset('assets/images/tailored-indoor-padel-coaching-for-skill-enhanceme-JV5Z29N.jpg') }}"/>
</div>
<h3>Why Joining a Jumpball Community Matters</h3>
<div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla mauris nunc, pharetra quis sagittis ac, mollis vel libero. Nam vel mi felis. Phasellus vel ex ultricies, aliquam mauris at, sagittis eros. Donec ultricies enim eget nisl fermentum pulvinar. Pellentesque porta eros at urna vehicula, at molestie turpis tristique. In viverra eget nisl et laoreet. Morbi metus turpis, malesuada ut elit id, tristique dictum velit.</p>
<p>Donec posuere diam sit amet lacus mollis lacinia. Integer posuere diam vitae dignissim maximus. Aliquam quam nisi, volutpat rhoncus volutpat ac, tempor in tortor. Quisque finibus scelerisque egestas. Curabitur nec est commodo, fermentum magna id, volutpat nunc. Donec sit amet eros convallis, posuere ligula in, fermentum nibh. Suspendisse sagittis quis nisl ac bibendum. Nullam eros ex, varius at odio quis, maximus lacinia nibh. Etiam tellus nibh, laoreet ut molestie a, laoreet nec tortor. Suspendisse potenti. Vestibulum ac placerat est, sit amet consectetur justo.</p>
<p>Cras pretium mauris non ligula tempor, nec pulvinar ligula hendrerit. Donec velit elit, elementum et velit et, fringilla pharetra enim. Integer vitae diam felis. Morbi accumsan tristique sapien at interdum. Phasellus ullamcorper, turpis iaculis cursus porttitor, felis massa accumsan orci, sed iaculis nunc enim id libero. Duis vitae hendrerit felis. Duis massa sapien, tristique vitae purus posuere, blandit tempus augue. Quisque sollicitudin ligula sed lacus placerat egestas.</p>
<p>Pellentesque feugiat nunc odio, eget malesuada est finibus id. Etiam nunc eros, aliquet posuere hendrerit in, porta eget metus. Donec tortor ligula, pellentesque a quam convallis, lobortis tincidunt eros. In volutpat, odio a molestie semper, est arcu sagittis orci, eget accumsan magna nunc ut lorem. Donec feugiat, ligula id euismod aliquam, arcu augue scelerisque neque, ut ultricies massa nunc eget erat. Suspendisse at bibendum enim, ac feugiat lacus. Donec facilisis et mauris vitae ullamcorper. Cras tellus tortor, convallis sed tortor id, aliquam venenatis sem. Nunc a volutpat magna. Aenean in eleifend elit. In a lorem magna. Phasellus et tellus eget turpis accumsan lacinia vitae non risus. Integer nec turpis in ipsum pretium tristique id at orci. Vestibulum tincidunt, elit mollis maximus pellentesque, metus enim eleifend elit, quis condimentum neque diam a tortor.</p>
<p>Aliquam quis feugiat magna. Aliquam mattis non velit eu dictum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ultricies et turpis vitae accumsan. Fusce in pretium magna. Mauris consequat cursus ligula. Morbi placerat dolor et risus auctor faucibus. Fusce ornare, tortor sit amet tincidunt aliquet, purus odio congue tellus, at dapibus massa urna eget dui.</p>
</div>
</div>
<!-- Post Sidebar -->
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
</div>
</div>
</div>
</div>
<!-- Blog Section -->
<div class="section pt-0">
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
