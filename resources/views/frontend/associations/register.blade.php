@extends('layouts.frontend')

@section('title', 'Register a State Association')
@section('meta_description', 'Apply for recognition of your state Jumpball association by the Jumpball Federation of India.')

@section('content')
<x-page-banner :crumbs="['Associations' => route('frontend.associations.index')]" subtitle="Apply for recognition by the federation. Applications are reviewed by the federation office and you are informed of the decision by email." title="Register a State Association"/>

<section class="page-section">
<div class="hero-container">
<div class="detail-layout">
<form action="#" class="jfi-form" enctype="multipart/form-data" method="post">
@csrf
<div class="form-intro">
<p class="form-required-note">Fields marked <span aria-hidden="true" class="text-danger">*</span><span class="visually-hidden">with an asterisk</span> are required.</p>
</div>

<fieldset class="form-section">
<legend>Association Details</legend>
<p class="form-section-note">Enter the details exactly as they appear on your society registration certificate.</p>
<div class="form-grid">
<div class="form-field span-2">
<label class="form-label" for="name">Association name <span class="required" aria-hidden="true">*</span></label>
<input autocomplete="organization" class="form-control-jfi" id="name" name="name" required type="text"/>
</div>
<div class="form-field">
<label class="form-label" for="state">State or union territory <span class="required" aria-hidden="true">*</span></label>
<select class="form-control-jfi" id="state" name="state" required>
<option value="">Select a state</option>
@foreach (config('jumpball.states') as $state)
<option value="{{ $state }}">{{ $state }}</option>
@endforeach
</select>
</div>
<div class="form-field">
<label class="form-label" for="city">City</label>
<input autocomplete="address-level2" class="form-control-jfi" id="city" name="city" type="text"/>
</div>
<div class="form-field span-2">
<label class="form-label" for="address">Office address</label>
<textarea autocomplete="street-address" class="form-control-jfi" id="address" name="address" rows="3"></textarea>
</div>
<div class="form-field">
<label class="form-label" for="pincode">PIN code</label>
<input autocomplete="postal-code" class="form-control-jfi" id="pincode" inputmode="numeric" maxlength="6" name="pincode" pattern="[0-9]{6}" type="text"/>
</div>
<div class="form-field">
<label class="form-label" for="society_registration_no">Society registration number</label>
<input class="form-control-jfi" id="society_registration_no" name="society_registration_no" type="text"/>
</div>
<div class="form-field span-2">
<label class="form-label" for="logo">Association logo</label>
<input accept="image/png,image/jpeg" aria-describedby="logo-help" class="form-control-jfi" id="logo" name="logo" type="file"/>
<p class="form-help" id="logo-help">Optional. Square PNG or JPG, up to 2 MB. Shown on the public list once approved.</p>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>Office Bearers</legend>
<p class="form-section-note">You can add the full list of state office bearers after approval.</p>
<div class="form-grid">
<div class="form-field">
<label class="form-label" for="president_name">President's name</label>
<input autocomplete="name" class="form-control-jfi" id="president_name" name="president_name" type="text"/>
</div>
<div class="form-field">
<label class="form-label" for="secretary_name">Secretary's name</label>
<input autocomplete="name" class="form-control-jfi" id="secretary_name" name="secretary_name" type="text"/>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>Contact</legend>
<p class="form-section-note">The federation sends the decision on your application to this email address.</p>
<div class="form-grid">
<div class="form-field">
<label class="form-label" for="email">Official email <span class="required" aria-hidden="true">*</span></label>
<input autocomplete="email" class="form-control-jfi" id="email" name="email" required type="email"/>
</div>
<div class="form-field">
<label class="form-label" for="phone">Phone number <span class="required" aria-hidden="true">*</span></label>
<input autocomplete="tel" class="form-control-jfi" id="phone" inputmode="tel" name="phone" required type="tel"/>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>Documents</legend>
<p class="form-section-note">PDF, JPG or PNG, up to 5 MB each. Documents are stored privately and seen only by the federation office.</p>
<div class="form-grid">
@foreach (config('jumpball.association_document_types') as $key => $label)
<div class="form-field">
<label class="form-label" for="document-{{ $key }}">{{ $label }} <span class="required" aria-hidden="true">*</span></label>
<input accept=".pdf,image/png,image/jpeg" class="form-control-jfi" id="document-{{ $key }}" name="documents[{{ $key }}]" required type="file"/>
</div>
@endforeach
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
<button class="jfi-btn jfi-btn-gold" type="submit">Submit Application <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></button>
<p class="text-slate">You will receive an email confirming that your application was received.</p>
</div>
</form>

<aside aria-label="How recognition works">
<div class="side-card">
<h2 class="side-card-title">How Recognition Works</h2>
<ol class="steps">
<li><div><h3>Apply online</h3><p>Submit this form with your registration documents.</p></div></li>
<li><div><h3>Federation review</h3><p>The federation office checks your application and documents.</p></div></li>
<li><div><h3>Decision by email</h3><p>You are informed whether the application is approved or rejected.</p></div></li>
<li><div><h3>Public listing</h3><p>Approved associations appear on the recognized associations list.</p></div></li>
</ol>
</div>
<div class="side-card">
<h2 class="side-card-title">Need Help?</h2>
<p class="mb-3">Questions about eligibility or documents? Contact the federation office before you apply.</p>
<a class="jfi-btn jfi-btn-outline jfi-btn-block" href="{{ route('frontend.contact') }}">Contact the Federation</a>
</div>
</aside>
</div>
</div>
</section>
@endsection
