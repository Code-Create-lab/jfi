<aside>
<div>
<div class="sidebar-overlay"></div>
<div class="sidebar">
<div class="sidebar-header">
<div class="logo">
<img alt="Jumpball Federation of India" class="logo" src="{{ asset('assets/images/jfi-logo.png') }}"/>
</div>
<button aria-label="Close menu" class="close-btn"><i class="fa-solid fa-xmark"></i></button>
</div>
<ul class="menu">
<li><a href="{{ route('home') }}">Home</a></li>
<li><a href="{{ route('about') }}">About JFI</a></li>
<li class="sidebar-dropdown">
<div class="dropdown-header">
<a href="#">Competitions</a>
<button aria-label="Toggle Competitions" class="sidebar-dropdown-btn"><i class="fa-solid fa-angle-down"></i></button>
</div>
<ul class="sidebar-dropdown-menu">
<li><a href="{{ route('event') }}">Championships &amp; Events</a></li>
<li><a href="{{ route('membership') }}">Membership &amp; Affiliation</a></li>
<li><a href="{{ route('booking') }}">Venue Booking</a></li>
</ul>
</li>
<li class="sidebar-dropdown">
<div class="dropdown-header">
<a href="#">Development</a>
<button aria-label="Toggle Development" class="sidebar-dropdown-btn"><i class="fa-solid fa-angle-down"></i></button>
</div>
<ul class="sidebar-dropdown-menu">
<li><a href="{{ route('service') }}">Programmes</a></li>
<li><a href="{{ route('coaching') }}">Coaching &amp; Academy</a></li>
<li><a href="{{ route('community') }}">State Associations</a></li>
</ul>
</li>
<li class="sidebar-dropdown">
<div class="dropdown-header">
<a href="#">Media</a>
<button aria-label="Toggle Media" class="sidebar-dropdown-btn"><i class="fa-solid fa-angle-down"></i></button>
</div>
<ul class="sidebar-dropdown-menu">
<li><a href="{{ route('blog') }}">News &amp; Updates</a></li>
<li><a href="{{ route('faq') }}">FAQ</a></li>
</ul>
</li>
<li class="below-dropdown"><a href="{{ route('contact') }}">Contact</a></li>
</ul>
</div>
</div>
</aside>
