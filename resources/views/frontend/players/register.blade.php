@extends('layouts.frontend')

@php
    $associations ??= ((fn () => require resource_path('views/frontend/_preview-data.php'))())['associations'];
@endphp

@section('title', 'Player Registration')
@section('meta_description', 'Register as a Jumpball player with the Jumpball Federation of India and receive your official Player ID.')

@section('content')
<x-page-banner :crumbs="['Players' => route('frontend.players.index')]" subtitle="Register once to receive your official JFI Player ID. Your registration becomes active after it is approved by the federation office." title="Player Registration"/>

<section class="page-section">
<div class="hero-container">
<div class="detail-layout">
<form action="#" class="jfi-form" enctype="multipart/form-data" method="post">
@csrf
<div class="form-intro">
<p class="form-required-note">Fields marked <span aria-hidden="true" class="required">*</span><span class="visually-hidden">with an asterisk</span> are required.</p>
</div>

<fieldset class="form-section">
<legend>Personal Details</legend>
<p class="form-section-note">Use your name as it appears on your ID proof.</p>
<div class="form-grid">
<div class="form-field span-2">
<label class="form-label" for="name">Full name <span class="required" aria-hidden="true">*</span></label>
<input autocomplete="name" class="form-control-jfi" id="name" name="name" required type="text"/>
</div>
<div class="form-field">
<label class="form-label" for="father_name">Father's name</label>
<input class="form-control-jfi" id="father_name" name="father_name" type="text"/>
</div>
<div class="form-field">
<label class="form-label" for="date_of_birth">Date of birth <span class="required" aria-hidden="true">*</span></label>
<input aria-describedby="dob-help" autocomplete="bday" class="form-control-jfi" id="date_of_birth" max="{{ today()->toDateString() }}" name="date_of_birth" required type="date"/>
<p class="form-help" id="dob-help">Used for age categories and certificate lookup. Never published.</p>
</div>
<fieldset class="form-field span-2 border-0 p-0 m-0">
<legend class="form-label float-none mb-1">Gender <span class="required" aria-hidden="true">*</span></legend>
<div class="choice-group">
@foreach (App\Enums\Gender::cases() as $gender)
<label class="choice"><input name="gender" required type="radio" value="{{ $gender->value }}"/> {{ $gender->label() }}</label>
@endforeach
</div>
</fieldset>
<div class="form-field span-2">
<label class="form-label" for="photo">Passport-size photo</label>
<input accept="image/png,image/jpeg" aria-describedby="photo-help" class="form-control-jfi" id="photo" name="photo" type="file"/>
<p class="form-help" id="photo-help">JPG or PNG, up to 2 MB. Used on your player record only.</p>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>Contact</legend>
<p class="form-section-note">The federation sends your registration status to this email address.</p>
<div class="form-grid">
<div class="form-field">
<label class="form-label" for="email">Email <span class="required" aria-hidden="true">*</span></label>
<input autocomplete="email" class="form-control-jfi" id="email" name="email" required type="email"/>
</div>
<div class="form-field">
<label class="form-label" for="phone">Mobile number <span class="required" aria-hidden="true">*</span></label>
<input autocomplete="tel" class="form-control-jfi" id="phone" inputmode="tel" name="phone" required type="tel"/>
</div>
<div class="form-field span-2">
<label class="form-label" for="address">Address</label>
<textarea autocomplete="street-address" class="form-control-jfi" id="address" name="address" rows="3"></textarea>
</div>
<div class="form-field">
<label class="form-label" for="city">City</label>
<input autocomplete="address-level2" class="form-control-jfi" id="city" name="city" type="text"/>
</div>
<div class="form-field">
<label class="form-label" for="state">State or union territory</label>
<select autocomplete="address-level1" class="form-control-jfi" id="state" name="state">
<option value="">Select a state</option>
@foreach (config('jumpball.states') as $state)
<option value="{{ $state }}">{{ $state }}</option>
@endforeach
</select>
</div>
<div class="form-field">
<label class="form-label" for="pincode">PIN code</label>
<input autocomplete="postal-code" class="form-control-jfi" id="pincode" inputmode="numeric" maxlength="6" name="pincode" pattern="[0-9]{6}" type="text"/>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>State Association</legend>
<p class="form-section-note">Choose the recognized association you play under. If yours is not listed yet, leave this blank.</p>
<div class="form-grid">
<div class="form-field span-2">
<label class="form-label" for="state_association_id">State association</label>
<select class="form-control-jfi" id="state_association_id" name="state_association_id">
<option value="">My association is not listed</option>
@foreach ($associations as $association)
<option value="{{ $association->id }}">{{ $association->name }}</option>
@endforeach
</select>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>Documents</legend>
<p class="form-section-note">PDF, JPG or PNG, up to 5 MB each. Stored privately and seen only by the federation office.</p>
<div class="form-grid">
@foreach (config('jumpball.player_document_types') as $key => $label)
<div class="form-field">
<label class="form-label" for="document-{{ $key }}">{{ $label }} <span class="required" aria-hidden="true">*</span></label>
<input accept=".pdf,image/png,image/jpeg" class="form-control-jfi" id="document-{{ $key }}" name="documents[{{ $key }}]" required type="file"/>
</div>
@endforeach
</div>
</fieldset>

<fieldset class="form-section">
<legend>Account</legend>
<p class="form-section-note">You will sign in with your email and this password to see your Player ID and certificates.</p>
<div class="form-grid">
<div class="form-field">
<label class="form-label" for="password">Password <span class="required" aria-hidden="true">*</span></label>
<div class="password-field">
<input aria-describedby="password-help" autocomplete="new-password" class="form-control-jfi" id="password" minlength="8" name="password" required type="password"/>
<button aria-controls="password" aria-label="Show password" class="password-toggle" data-password-toggle type="button"><i aria-hidden="true" class="fa-regular fa-eye"></i></button>
</div>
<p class="form-help" id="password-help">At least 8 characters.</p>
</div>
<div class="form-field">
<label class="form-label" for="password_confirmation">Confirm password <span class="required" aria-hidden="true">*</span></label>
<input autocomplete="new-password" class="form-control-jfi" id="password_confirmation" minlength="8" name="password_confirmation" required type="password"/>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>Declaration</legend>
<label class="choice choice-block mt-2">
<input name="terms" required type="checkbox" value="1"/>
<span>I confirm that the information provided is accurate and I agree to the <a href="{{ route('frontend.legal.terms') }}">Terms &amp; Conditions</a> and <a href="{{ route('frontend.legal.privacy') }}">Privacy Policy</a>. <span class="required" aria-hidden="true">*</span></span>
</label>
</fieldset>

<div class="form-actions">
<button class="jfi-btn jfi-btn-gold" type="submit">Submit Registration <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></button>
<p class="text-slate">Already registered? <a href="{{ route('frontend.players.login') }}">Sign in</a></p>
</div>
</form>

<aside aria-label="About your Player ID">
<div class="side-card">
<h2 class="side-card-title">Your Player ID</h2>
<p>Your Player ID is created when you submit this form, for example <span class="player-id">JFI-2026-00001</span>. It becomes active once the federation approves your registration.</p>
<ul class="meta-list mt-3">
<li><i aria-hidden="true" class="fa-solid fa-trophy"></i><span>Required to enter sanctioned championships</span></li>
<li><i aria-hidden="true" class="fa-solid fa-certificate"></i><span>Links your results and certificates</span></li>
<li><i aria-hidden="true" class="fa-solid fa-magnifying-glass"></i><span>Lets selectors confirm your record</span></li>
</ul>
</div>
<div class="side-card">
<h2 class="side-card-title">Your Privacy</h2>
<p class="mb-0">The public Player Database shows only your name, Player ID and state association. Your date of birth, contact details and documents are never published.</p>
</div>
</aside>
</div>
</div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/jfi-forms.js') }}"></script>
@endpush
