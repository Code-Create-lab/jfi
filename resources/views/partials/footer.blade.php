<footer>
<div class="section pb-0 bg-accent-color">
<div class="hero-container">
<div class="footer-content-container">
<div class="row row-cols-xl-4 row-cols-md-2 row-cols-1 grid-spacer-2">
<div class="col">
<div class="d-flex flex-column gspace-2">
<div class="footer-logo-container">
<img alt="Jumpball Federation of India" class="img-fluid" src="{{ asset('assets/images/jfi-logo.png') }}"/>
</div>
<p class="secondary-accent mb-0">The national governing body for Jumpball in India, responsible for competitions, athlete pathways, coaching standards and state affiliation.</p>
<div class="footer-social-icon">
<a aria-label="Facebook" class="social-icon" href="#">
<i class="fa-brands fa-facebook-f"></i>
</a>
<a aria-label="X" class="social-icon" href="#">
<i class="fa-brands fa-x-twitter"></i>
</a>
<a aria-label="Instagram" class="social-icon" href="#">
<i class="fa-brands fa-instagram"></i>
</a>
<a aria-label="YouTube" class="social-icon" href="#">
<i class="fa-brands fa-youtube"></i>
</a>
<a aria-label="LinkedIn" class="social-icon" href="#">
<i class="fa-brands fa-linkedin-in"></i>
</a>
</div>
</div>
</div>
<div class="col">
<div class="d-flex flex-column gspace-2">
<h4 class="secondary-accent">The Federation</h4>
<div class="underline-primary-accent"></div>
<ul class="chevron-list">
<li><a href="{{ route('about') }}">About JFI</a></li>
<li><a href="{{ route('event') }}">Championships &amp; Events</a></li>
<li><a href="{{ route('membership') }}">Membership &amp; Affiliation</a></li>
<li><a href="{{ route('coaching') }}">Coaching &amp; Academy</a></li>
<li><a href="{{ route('community') }}">State Associations</a></li>
<li><a href="{{ route('blog') }}">News &amp; Updates</a></li>
<li><a href="{{ route('contact') }}">Contact</a></li>
</ul>
</div>
</div>
<div class="col">
<div class="d-flex flex-column gspace-2">
<h4 class="secondary-accent">National Office</h4>
<div class="underline-primary-accent"></div>
<div class="d-flex flex-column gspace-2">
<div class="d-flex flex-row gspace-2 align-items-start">
<div>
<div class="contact-icon footer-icon">
<i class="fa-solid fa-phone"></i>
</div>
</div>
<div class="d-flex flex-column">
<h6 class="contact-info-heading">Phone</h6>
<h5 class="secondary-accent">+91 00000 00000</h5>
</div>
</div>
<div class="d-flex flex-row gspace-2 align-items-start">
<div>
<div class="contact-icon footer-icon">
<i class="fa-solid fa-envelope"></i>
</div>
</div>
<div class="d-flex flex-column">
<h6 class="contact-info-heading">Email</h6>
<h5 class="secondary-accent">info@jfi.org.in</h5>
</div>
</div>
<div class="d-flex flex-row gspace-2 align-items-start">
<div>
<div class="contact-icon footer-icon">
<i class="fa-solid fa-location-dot"></i>
</div>
</div>
<div class="d-flex flex-column">
<h6 class="contact-info-heading">Address</h6>
<h5 class="secondary-accent">JFI National Office, New Delhi, India</h5>
</div>
</div>
</div>
</div>
</div>
<div class="col">
<div class="d-flex flex-column gspace-2">
<h4 class="secondary-accent">Federation Bulletin</h4>
<div class="underline-primary-accent"></div>
<p class="secondary-accent">Championship calendars, selection notices and circulars, delivered to your inbox.</p>
<div class="alert success hidden" id="newsletter-success">
<span class="check-icon"><i class="fa-solid fa-2xl fa-check"></i></span>
<p class="text-center">Thank you. You are subscribed to the JFI bulletin.</p>
</div>
<div class="alert error hidden" id="newsletter-error">
<span class="cross-icon"><i class="fa-solid fa-2xl fa-xmark"></i></span>
<p class="text-center">Subscription failed. Please try again.</p>
</div>
<form action="#" class="form" id="newsletter-form" method="post">
<label class="visually-hidden" for="newsletter">Email address</label>
<input autocomplete="email" id="newsletter" name="newsletter" placeholder="Your email address" type="email"/>
<button class="btn btn-accent" type="submit">
<span class="btn-title">Subscribe</span>
<span class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</button>
</form>
</div>
</div>
</div>
<div class="footer-copyright-container">
<div class="footer-legalink-container">
<a class="legalink" href="#">Privacy Policy</a>
<div class="divider"></div>
<a class="legalink" href="#">Terms of Use</a>
<div class="divider"></div>
<a class="legalink" href="#">RTI &amp; Disclosures</a>
</div>
<h6 class="secondary-accent mb-0">&copy; {{ date('Y') }} Jumpball Federation of India. All rights reserved.</h6>
</div>
</div>
</div>
</div>
</footer>
