<header>
<div class="navbar-container">
<div class="hero-container">
<nav aria-label="Primary" class="navbar navbar-expand-xl">
<div class="navbar-nav-container">
<!-- Logo Container -->
<div class="logo-container">
<a class="navbar-brand" href="{{ route('home') }}">
<img alt="Jumpball Federation of India" class="img-fluid" height="62" src="{{ asset('assets/images/jfi-logo.png') }}"/>
</a>
</div>
<!-- Nav Link Container -->
<div class="nav-link-container">
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav mx-auto">
<li class="nav-item">
<a @class(['nav-link', 'active' => request()->routeIs('home')]) href="{{ route('home') }}">Home</a>
</li>
<li class="nav-item">
<a @class(['nav-link', 'active' => request()->routeIs('about')]) href="{{ route('about') }}">About JFI</a>
</li>
<li class="nav-item dropdown">
<a aria-expanded="false" @class(['nav-link dropdown-toggle', 'active' => request()->routeIs('event', 'membership', 'booking')]) data-bs-toggle="dropdown" href="#" role="button">
Competitions <i class="fa-solid fa-chevron-down"></i>
</a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="{{ route('event') }}">Championships &amp; Events</a></li>
<li><a class="dropdown-item" href="{{ route('membership') }}">Membership &amp; Affiliation</a></li>
<li><a class="dropdown-item" href="{{ route('booking') }}">Venue Booking</a></li>
</ul>
</li>
<li class="nav-item dropdown">
<a aria-expanded="false" @class(['nav-link dropdown-toggle', 'active' => request()->routeIs('service', 'coaching', 'community')]) data-bs-toggle="dropdown" href="#" role="button">
Development <i class="fa-solid fa-chevron-down"></i>
</a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="{{ route('service') }}">Programmes</a></li>
<li><a class="dropdown-item" href="{{ route('coaching') }}">Coaching &amp; Academy</a></li>
<li><a class="dropdown-item" href="{{ route('community') }}">State Associations</a></li>
</ul>
</li>
<li class="nav-item dropdown">
<a aria-expanded="false" @class(['nav-link dropdown-toggle', 'active' => request()->routeIs('blog', 'single-post', 'faq')]) data-bs-toggle="dropdown" href="#" role="button">
Media <i class="fa-solid fa-chevron-down"></i>
</a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="{{ route('blog') }}">News &amp; Updates</a></li>
<li><a class="dropdown-item" href="{{ route('faq') }}">FAQ</a></li>
</ul>
</li>
<li class="nav-item">
<a @class(['nav-link', 'active' => request()->routeIs('contact')]) href="{{ route('contact') }}">Contact</a>
</li>
</ul>
</div>
</div>
<button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="nav-btn" data-bs-target="#navbarNav" data-bs-toggle="collapse" type="button">
<i class="fa-solid fa-bars"></i>
</button>
<!-- Navbar CTA Container -->
<div class="navbar-cta-container">
<div>
<a class="btn btn-accent" href="{{ route('membership') }}">
<span class="btn-title">Register</span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</div>
</nav>
</div>
</div>
</header>
