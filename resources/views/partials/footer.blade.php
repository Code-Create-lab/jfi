<footer>
<div class="section pb-0 bg-accent-color">
<div class="hero-container">
<div class="footer-content-container">
<div class="row gx-4 gy-5">
<div class="col-lg-4">
<div class="footer-logo-container">
<img alt="Jumpball Federation of India" class="img-fluid" src="{{ asset('assets/images/jfi-logo.png') }}"/>
</div>
<p class="secondary-accent mt-4 mb-0">The national governing body for Jumpball in India, responsible for competitions, player registration, certificates and the recognition of state associations.</p>
<ul class="footer-contact">
@if ($contact['address'])
<li><i aria-hidden="true" class="fa-solid fa-location-dot"></i><span class="pre-line">{{ $contact['address'] }}</span></li>
@endif
@if ($contact['phone'])
<li><i aria-hidden="true" class="fa-solid fa-phone"></i><a href="tel:{{ preg_replace('/[^0-9+]/', '', $contact['phone']) }}">{{ $contact['phone'] }}</a></li>
@endif
@if ($contact['email'])
<li><i aria-hidden="true" class="fa-solid fa-envelope"></i><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></li>
@endif
</ul>
@if ($social)
<ul class="social-links mt-4">
@foreach ($social as $label => $link)
<li><a aria-label="{{ $site['name'] }} on {{ $label }}" href="{{ $link['url'] }}" rel="noopener" target="_blank"><i aria-hidden="true" class="{{ $link['icon'] }}"></i></a></li>
@endforeach
</ul>
@endif
</div>
<div class="col-6 col-md-4 col-lg-2 offset-lg-1">
<h2 class="footer-heading">Federation</h2>
<ul class="footer-links">
<li><a href="{{ route('frontend.about.federation') }}">About the Federation</a></li>
<li><a href="{{ route('frontend.about.president') }}">President's Message</a></li>
<li><a href="{{ route('frontend.office-bearers.national') }}">Office Bearers</a></li>
<li><a href="{{ route('frontend.associations.index') }}">State Associations</a></li>
<li><a href="{{ route('frontend.community.index') }}">Awareness</a></li>
<li><a href="{{ route('frontend.contact') }}">Contact</a></li>
</ul>
</div>
<div class="col-6 col-md-4 col-lg-2">
<h2 class="footer-heading">Players &amp; Events</h2>
<ul class="footer-links">
<li><a href="{{ route('frontend.players.register') }}">Player Registration</a></li>
<li><a href="{{ route('frontend.players.index') }}">Player Database</a></li>
<li><a href="{{ route('frontend.certificates.index') }}">Verify a Certificate</a></li>
<li><a href="{{ route('frontend.events.upcoming') }}">Upcoming Events</a></li>
<li><a href="{{ route('frontend.results.index') }}">Championship Results</a></li>
<li><a href="{{ route('frontend.players.login') }}">Player Login</a></li>
</ul>
</div>
<div class="col-6 col-md-4 col-lg-3">
<h2 class="footer-heading">Media &amp; Documents</h2>
<ul class="footer-links">
<li><a href="{{ route('frontend.news.index') }}">News &amp; Press Releases</a></li>
<li><a href="{{ route('frontend.gallery.index') }}">Photo Gallery</a></li>
<li><a href="{{ route('frontend.videos') }}">Video Gallery</a></li>
<li><a href="{{ route('frontend.downloads') }}">Downloads &amp; Notices</a></li>
<li><a href="{{ route('frontend.rule-book') }}">Rule Book</a></li>
</ul>
</div>
</div>
<div class="footer-copyright-container">
<div class="footer-legalink-container">
<a class="legalink" href="{{ route('frontend.legal.privacy') }}">Privacy Policy</a>
<div class="divider"></div>
<a class="legalink" href="{{ route('frontend.legal.terms') }}">Terms &amp; Conditions</a>
</div>
<div class="footer-copyright-block">
<p class="mb-0 footer-copyright">&copy; {{ date('Y') }} {{ $site['footer_text'] }}</p>
<p class="mb-0 footer-credit">Designed &amp; Developed by <a href="https://10xcart.snehal.info/" rel="noopener" target="_blank">10xCart</a> &middot; <a href="https://www.instagram.com/10xcart" rel="noopener" target="_blank"><i aria-hidden="true" class="fa-brands fa-instagram"></i> @10xcart<span class="visually-hidden"> on Instagram</span></a></p>
</div>
</div>
</div>
</div>
</div>
</footer>
