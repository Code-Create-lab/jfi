@extends('layouts.frontend')

@section('title', 'Register a State Association')
@section('meta_description', 'Apply for recognition of your state Jumpball association by the Jumpball Federation of India.')

@section('content')
<x-page-banner :crumbs="['Associations' => route('frontend.associations.index')]" subtitle="Apply for recognition by the federation. Applications are reviewed by the federation office and you are informed of the decision by email." title="Register a State Association"/>

<section class="page-section">
<div class="hero-container">
<div class="detail-layout">
@if (session('registered_association'))
<article class="verify-card">
<div aria-live="polite" class="verify-status verify-status-valid">
<i aria-hidden="true" class="fa-solid fa-circle-check"></i>
<div>
<h2>Application received</h2>
<p>Thank you. The application from {{ session('registered_association') }} has been received.</p>
</div>
</div>
<div class="p-4">
<p>A confirmation has been sent to the official email address you entered. The federation office will review your application and documents and inform you of the decision by email. Approved associations appear on the recognized associations list.</p>
<div class="d-flex flex-wrap gap-3">
<a class="jfi-btn jfi-btn-primary" href="{{ route('frontend.associations.index') }}">Recognized Associations</a>
<a class="jfi-btn jfi-btn-outline" href="{{ route('frontend.home') }}">Back to Home</a>
</div>
</div>
</article>
@else
<div class="d-flex flex-column gap-4">
<x-form-alert :has-files="true"/>
<form action="{{ route('frontend.associations.store') }}" class="jfi-form" enctype="multipart/form-data" method="post">
@csrf
<x-honeypot/>
<div class="form-intro">
<p class="form-required-note">Fields marked <span aria-hidden="true" class="text-danger">*</span><span class="visually-hidden">with an asterisk</span> are required.</p>
</div>

<fieldset class="form-section">
<legend>Association Details</legend>
<p class="form-section-note">Enter the details exactly as they appear on your society registration certificate.</p>
<div class="form-grid">
<div class="form-field span-2">
<label class="form-label" for="name">Association name <span class="required" aria-hidden="true">*</span></label>
<input @error('name') aria-describedby="name-error" aria-invalid="true" @enderror autocomplete="organization" maxlength="255" @class(['form-control-jfi', 'is-invalid' => $errors->has('name')]) id="name" name="name" required type="text" value="{{ old('name') }}"/>
<x-form-error field="name" id="name"/>
</div>
<div class="form-field">
<label class="form-label" for="state">State or union territory <span class="required" aria-hidden="true">*</span></label>
<select @error('state') aria-describedby="state-error" aria-invalid="true" @enderror autocomplete="address-level1" @class(['form-control-jfi', 'is-invalid' => $errors->has('state')]) id="state" name="state" required>
<option value="">Select a state</option>
@foreach (config('jumpball.states') as $state)
<option @selected(old('state') === $state) value="{{ $state }}">{{ $state }}</option>
@endforeach
</select>
<x-form-error field="state" id="state"/>
</div>
<div class="form-field">
<label class="form-label" for="city">City</label>
<input @error('city') aria-describedby="city-error" aria-invalid="true" @enderror autocomplete="address-level2" maxlength="255" @class(['form-control-jfi', 'is-invalid' => $errors->has('city')]) id="city" name="city" type="text" value="{{ old('city') }}"/>
<x-form-error field="city" id="city"/>
</div>
<div class="form-field span-2">
<label class="form-label" for="address">Office address</label>
<textarea @error('address') aria-describedby="address-error" aria-invalid="true" @enderror autocomplete="street-address" @class(['form-control-jfi', 'is-invalid' => $errors->has('address')]) id="address" maxlength="1000" name="address" rows="3">{{ old('address') }}</textarea>
<x-form-error field="address" id="address"/>
</div>
<div class="form-field">
<label class="form-label" for="pincode">PIN code</label>
<input @error('pincode') aria-describedby="pincode-error" aria-invalid="true" @enderror autocomplete="postal-code" inputmode="numeric" maxlength="6" pattern="[1-9][0-9]{5}" @class(['form-control-jfi', 'is-invalid' => $errors->has('pincode')]) id="pincode" name="pincode" type="text" value="{{ old('pincode') }}"/>
<x-form-error field="pincode" id="pincode"/>
</div>
<div class="form-field">
<label class="form-label" for="society_registration_no">Society registration number</label>
<input @error('society_registration_no') aria-describedby="society_registration_no-error" aria-invalid="true" @enderror maxlength="255" @class(['form-control-jfi', 'is-invalid' => $errors->has('society_registration_no')]) id="society_registration_no" name="society_registration_no" type="text" value="{{ old('society_registration_no') }}"/>
<x-form-error field="society_registration_no" id="society_registration_no"/>
</div>
<div class="form-field span-2">
<label class="form-label" for="logo">Association logo</label>
<input aria-describedby="logo-help @error('logo') logo-error @enderror" @error('logo') aria-invalid="true" @enderror accept="image/png,image/jpeg" @class(['form-control-jfi', 'is-invalid' => $errors->has('logo')]) id="logo" name="logo" type="file"/>
<x-form-error field="logo" id="logo"/>
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
<input @error('president_name') aria-describedby="president_name-error" aria-invalid="true" @enderror autocomplete="name" maxlength="255" @class(['form-control-jfi', 'is-invalid' => $errors->has('president_name')]) id="president_name" name="president_name" type="text" value="{{ old('president_name') }}"/>
<x-form-error field="president_name" id="president_name"/>
</div>
<div class="form-field">
<label class="form-label" for="secretary_name">Secretary's name</label>
<input @error('secretary_name') aria-describedby="secretary_name-error" aria-invalid="true" @enderror autocomplete="name" maxlength="255" @class(['form-control-jfi', 'is-invalid' => $errors->has('secretary_name')]) id="secretary_name" name="secretary_name" type="text" value="{{ old('secretary_name') }}"/>
<x-form-error field="secretary_name" id="secretary_name"/>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>Contact</legend>
<p class="form-section-note">The federation sends the decision on your application to this email address.</p>
<div class="form-grid">
<div class="form-field">
<label class="form-label" for="email">Official email <span class="required" aria-hidden="true">*</span></label>
<input @error('email') aria-describedby="email-error" aria-invalid="true" @enderror autocomplete="email" maxlength="255" @class(['form-control-jfi', 'is-invalid' => $errors->has('email')]) id="email" name="email" required type="email" value="{{ old('email') }}"/>
<x-form-error field="email" id="email"/>
</div>
<div class="form-field">
<label class="form-label" for="phone">Phone number <span class="required" aria-hidden="true">*</span></label>
<input @error('phone') aria-describedby="phone-error" aria-invalid="true" @enderror autocomplete="tel" inputmode="tel" maxlength="20" @class(['form-control-jfi', 'is-invalid' => $errors->has('phone')]) id="phone" name="phone" required type="tel" value="{{ old('phone') }}"/>
<x-form-error field="phone" id="phone"/>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>Documents</legend>
<p class="form-section-note" id="documents-help">PDF, JPG or PNG, up to 2 MB each. Documents are stored privately and seen only by the federation office.</p>
<div class="form-grid">
@foreach (config('jumpball.association_document_types') as $key => $label)
<div class="form-field">
<label class="form-label" for="document-{{ $key }}">{{ $label }} <span class="required" aria-hidden="true">*</span></label>
<input accept=".pdf,image/png,image/jpeg" aria-describedby="documents-help @error('documents.'.$key) document-{{ $key }}-error @enderror" @error('documents.'.$key) aria-invalid="true" @enderror @class(['form-control-jfi', 'is-invalid' => $errors->has('documents.'.$key)]) id="document-{{ $key }}" name="documents[{{ $key }}]" required type="file"/>
<x-form-error :field="'documents.'.$key" :id="'document-'.$key"/>
</div>
@endforeach
</div>
</fieldset>

<fieldset class="form-section">
<legend>Declaration</legend>
<label class="choice choice-block mt-2">
<input @error('terms') aria-describedby="terms-error" aria-invalid="true" @enderror @checked(old('terms')) id="terms" name="terms" required type="checkbox" value="1"/>
<span>I confirm that the information provided is accurate and I agree to the <a href="{{ route('frontend.legal.terms') }}">Terms &amp; Conditions</a> and <a href="{{ route('frontend.legal.privacy') }}">Privacy Policy</a>. <span class="required" aria-hidden="true">*</span></span>
</label>
<x-form-error field="terms" id="terms"/>
</fieldset>

<div class="form-actions">
<button class="jfi-btn jfi-btn-gold" type="submit">Submit Application <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></button>
<p class="text-slate">You will receive an email confirming that your application was received.</p>
</div>
</form>
</div>
@endif

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
