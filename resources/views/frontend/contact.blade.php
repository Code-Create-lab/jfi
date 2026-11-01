@extends('layouts.frontend')

@php
    $contact ??= (require resource_path('views/frontend/_preview-data.php'))['contact'];
@endphp

@section('title', 'Contact the Federation')
@section('meta_description', 'Contact the Jumpball Federation of India national office.')

@section('content')
<x-page-banner subtitle="Write to the national office about registrations, championships, certificates or anything else. The right team will respond." title="Contact the Federation"/>

<section class="page-section">
<div class="hero-container">
<div class="detail-layout">
<form action="#" class="jfi-form" method="post">
@csrf
<fieldset class="form-section">
<legend>Send a Message</legend>
<p class="form-section-note">Fields marked <span aria-hidden="true" class="required">*</span><span class="visually-hidden">with an asterisk</span> are required.</p>
<div class="form-grid">
<div class="form-field">
<label class="form-label" for="contact-name">Your name <span class="required" aria-hidden="true">*</span></label>
<input autocomplete="name" class="form-control-jfi" id="contact-name" name="name" required type="text"/>
</div>
<div class="form-field">
<label class="form-label" for="contact-email">Email <span class="required" aria-hidden="true">*</span></label>
<input autocomplete="email" class="form-control-jfi" id="contact-email" name="email" required type="email"/>
</div>
<div class="form-field">
<label class="form-label" for="contact-phone">Phone</label>
<input autocomplete="tel" class="form-control-jfi" id="contact-phone" inputmode="tel" name="phone" type="tel"/>
</div>
<div class="form-field">
<label class="form-label" for="contact-subject">Subject</label>
<select class="form-control-jfi" id="contact-subject" name="subject">
<option value="">Choose a topic</option>
<option>Player registration</option>
<option>State association recognition</option>
<option>Championships and events</option>
<option>Certificates</option>
<option>Media enquiry</option>
<option>Other</option>
</select>
</div>
<div class="form-field span-2">
<label class="form-label" for="contact-message">Message <span class="required" aria-hidden="true">*</span></label>
<textarea class="form-control-jfi" id="contact-message" name="message" required rows="6"></textarea>
<p class="form-help">Include your Player ID if your question is about a registration or certificate.</p>
</div>
</div>
</fieldset>
<div class="form-actions">
<button class="jfi-btn jfi-btn-gold" type="submit">Send Message <i aria-hidden="true" class="fa-solid fa-paper-plane"></i></button>
</div>
</form>

<aside aria-label="Contact details">
<div class="side-card">
<h2 class="side-card-title">National Office</h2>
<ul class="meta-list">
<li><i aria-hidden="true" class="fa-solid fa-location-dot"></i><span>{{ $contact['address'] }}</span></li>
<li><i aria-hidden="true" class="fa-solid fa-phone"></i><a href="tel:{{ preg_replace('/[^0-9+]/', '', $contact['phone']) }}">{{ $contact['phone'] }}</a></li>
<li><i aria-hidden="true" class="fa-solid fa-envelope"></i><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></li>
</ul>
</div>
<div class="side-card">
<h2 class="side-card-title">Quick Answers</h2>
<ul class="side-nav">
<li><a href="{{ route('frontend.players.register') }}">How do I get a Player ID? <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a></li>
<li><a href="{{ route('frontend.certificates.index') }}">Where is my certificate? <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a></li>
<li><a href="{{ route('frontend.associations.register') }}">How does recognition work? <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a></li>
<li><a href="{{ route('frontend.downloads') }}">Circulars and forms <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></a></li>
</ul>
</div>
</aside>
</div>
</div>
</section>
@endsection
