@extends('layouts.frontend')

@section('title', 'Contact the Federation')
@section('meta_description', 'Contact the Jumpball Federation of India national office.')

@section('content')
<x-page-banner subtitle="Write to the national office about registrations, championships, certificates or anything else. The right team will respond." title="Contact the Federation"/>

<section class="page-section">
<div class="hero-container">
<div class="detail-layout">
<div class="d-flex flex-column gap-4">
<x-form-alert :success="session('status')"/>
<form action="{{ route('frontend.contact.store') }}" class="jfi-form" method="post">
@csrf
<x-honeypot/>
<fieldset class="form-section">
<legend>Send a Message</legend>
<p class="form-section-note">Fields marked <span aria-hidden="true" class="required">*</span><span class="visually-hidden">with an asterisk</span> are required.</p>
<div class="form-grid">
<div class="form-field">
<label class="form-label" for="contact-name">Your name <span class="required" aria-hidden="true">*</span></label>
<input @error('name') aria-describedby="contact-name-error" aria-invalid="true" @enderror autocomplete="name" @class(['form-control-jfi', 'is-invalid' => $errors->has('name')]) id="contact-name" maxlength="255" name="name" required type="text" value="{{ old('name') }}"/>
<x-form-error field="name" id="contact-name"/>
</div>
<div class="form-field">
<label class="form-label" for="contact-email">Email <span class="required" aria-hidden="true">*</span></label>
<input @error('email') aria-describedby="contact-email-error" aria-invalid="true" @enderror autocomplete="email" @class(['form-control-jfi', 'is-invalid' => $errors->has('email')]) id="contact-email" maxlength="255" name="email" required type="email" value="{{ old('email') }}"/>
<x-form-error field="email" id="contact-email"/>
</div>
<div class="form-field">
<label class="form-label" for="contact-phone">Phone</label>
<input @error('phone') aria-describedby="contact-phone-error" aria-invalid="true" @enderror autocomplete="tel" @class(['form-control-jfi', 'is-invalid' => $errors->has('phone')]) id="contact-phone" inputmode="tel" maxlength="20" name="phone" type="tel" value="{{ old('phone') }}"/>
<x-form-error field="phone" id="contact-phone"/>
</div>
<div class="form-field">
<label class="form-label" for="contact-subject">Subject</label>
<select @error('subject') aria-describedby="contact-subject-error" aria-invalid="true" @enderror @class(['form-control-jfi', 'is-invalid' => $errors->has('subject')]) id="contact-subject" name="subject">
<option value="">Choose a topic</option>
@foreach (App\Http\Requests\Frontend\StoreContactMessageRequest::SUBJECTS as $subject)
<option @selected(old('subject') === $subject) value="{{ $subject }}">{{ $subject }}</option>
@endforeach
</select>
<x-form-error field="subject" id="contact-subject"/>
</div>
<div class="form-field span-2">
<label class="form-label" for="contact-message">Message <span class="required" aria-hidden="true">*</span></label>
<textarea aria-describedby="contact-message-help @error('message') contact-message-error @enderror" @error('message') aria-invalid="true" @enderror @class(['form-control-jfi', 'is-invalid' => $errors->has('message')]) id="contact-message" maxlength="5000" name="message" required rows="6">{{ old('message') }}</textarea>
<x-form-error field="message" id="contact-message"/>
<p class="form-help" id="contact-message-help">Include your Player ID if your question is about a registration or certificate.</p>
</div>
</div>
</fieldset>
<div class="form-actions">
<button class="jfi-btn jfi-btn-gold" type="submit">Send Message <i aria-hidden="true" class="fa-solid fa-paper-plane"></i></button>
</div>
</form>
</div>

<aside aria-label="Contact details">
<div class="side-card">
<h2 class="side-card-title">National Office</h2>
<ul class="meta-list">
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
<ul class="social-links mt-3">
@foreach ($social as $label => $link)
<li><a aria-label="{{ $label }}" href="{{ $link['url'] }}" rel="noopener" target="_blank"><i aria-hidden="true" class="{{ $link['icon'] }}"></i></a></li>
@endforeach
</ul>
@endif
</div>
@if ($contact['map_embed'])
<div class="side-card map-embed">
<h2 class="side-card-title">Find Us</h2>
<iframe allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="{{ $contact['map_embed'] }}" title="Map to the federation office"></iframe>
</div>
@endif
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
