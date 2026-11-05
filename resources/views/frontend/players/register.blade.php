@extends('layouts.frontend')

@section('title', 'Player Registration')
@section('meta_description', 'Register as a Jumpball player with the Jumpball Federation of India and receive your official Player ID.')

@section('content')
<x-page-banner :crumbs="['Players' => route('frontend.players.index')]" subtitle="Register once to receive your official JFI Player ID. Your registration becomes active after it is approved by the federation office." title="Player Registration"/>

<section class="page-section">
<div class="hero-container">
<div class="detail-layout">
@if (session('registered_player'))
<article class="verify-card">
<div aria-live="polite" class="verify-status verify-status-valid">
<i aria-hidden="true" class="fa-solid fa-circle-check"></i>
<div>
<h2>Registration received</h2>
<p>Thank you, {{ session('registered_player.name') }}. Your registration has been submitted.</p>
</div>
</div>
<dl class="verify-details">
<dt>Your Player ID</dt><dd class="player-id">{{ session('registered_player.registration_no') }}</dd>
<dt>Status</dt><dd>Pending approval by the federation office</dd>
</dl>
<div class="p-4">
<p>Please note your Player ID. It has also been sent to your email address. It becomes active once the federation approves your registration, and you will receive an email when that happens.</p>
<div class="d-flex flex-wrap gap-3">
<a class="jfi-btn jfi-btn-primary" href="{{ route('frontend.players.login') }}">Player Login</a>
<a class="jfi-btn jfi-btn-outline" href="{{ route('frontend.home') }}">Back to Home</a>
</div>
</div>
</article>
@elseif ($associations->isEmpty())
<x-empty-state icon="fa-solid fa-people-group" title="Registration opens soon">
Players register under a recognized state association. No association has been recognized yet, so online registration is not open. Please check again later or contact the federation office.
<x-slot:action>
<a class="jfi-btn jfi-btn-primary" href="{{ route('frontend.contact') }}">Contact the Federation</a>
</x-slot:action>
</x-empty-state>
@else
<div class="d-flex flex-column gap-4">
<x-form-alert :has-files="true"/>
<form action="{{ route('frontend.players.store') }}" class="jfi-form" enctype="multipart/form-data" method="post">
@csrf
<x-honeypot/>
<div class="form-intro">
<p class="form-required-note">Fields marked <span aria-hidden="true" class="required">*</span><span class="visually-hidden">with an asterisk</span> are required.</p>
</div>

<fieldset class="form-section">
<legend>Personal Details</legend>
<p class="form-section-note">Use your name as it appears on your ID proof.</p>
<div class="form-grid">
<div class="form-field span-2">
<label class="form-label" for="name">Full name <span class="required" aria-hidden="true">*</span></label>
<input @error('name') aria-describedby="name-error" aria-invalid="true" @enderror autocomplete="name" maxlength="255" @class(['form-control-jfi', 'is-invalid' => $errors->has('name')]) id="name" name="name" required type="text" value="{{ old('name') }}"/>
<x-form-error field="name" id="name"/>
</div>
<div class="form-field">
<label class="form-label" for="father_name">Father's or guardian's name</label>
<input @error('father_name') aria-describedby="father_name-error" aria-invalid="true" @enderror maxlength="255" @class(['form-control-jfi', 'is-invalid' => $errors->has('father_name')]) id="father_name" name="father_name" type="text" value="{{ old('father_name') }}"/>
<x-form-error field="father_name" id="father_name"/>
</div>
<div class="form-field">
<label class="form-label" for="date_of_birth">Date of birth <span class="required" aria-hidden="true">*</span></label>
<input aria-describedby="date_of_birth-help @error('date_of_birth') date_of_birth-error @enderror" @error('date_of_birth') aria-invalid="true" @enderror autocomplete="bday" max="{{ today()->subDay()->toDateString() }}" @class(['form-control-jfi', 'is-invalid' => $errors->has('date_of_birth')]) id="date_of_birth" name="date_of_birth" required type="date" value="{{ old('date_of_birth') }}"/>
<x-form-error field="date_of_birth" id="date_of_birth"/>
<p class="form-help" id="date_of_birth-help">Used for age categories and certificate lookup. Never published.</p>
</div>
<fieldset class="form-field span-2 border-0 p-0 m-0">
<legend class="form-label float-none mb-1">Gender <span class="required" aria-hidden="true">*</span></legend>
<div class="choice-group">
@foreach (App\Enums\Gender::cases() as $gender)
<label class="choice"><input @error('gender') aria-describedby="gender-error" aria-invalid="true" @enderror @checked(old('gender') === $gender->value) name="gender" required type="radio" value="{{ $gender->value }}"/> {{ $gender->label() }}</label>
@endforeach
</div>
<x-form-error field="gender" id="gender"/>
</fieldset>
<div class="form-field span-2">
<label class="form-label" for="photo">Passport-size photo</label>
<input aria-describedby="photo-help @error('photo') photo-error @enderror" @error('photo') aria-invalid="true" @enderror accept="image/png,image/jpeg" @class(['form-control-jfi', 'is-invalid' => $errors->has('photo')]) id="photo" name="photo" type="file"/>
<x-form-error field="photo" id="photo"/>
<p class="form-help" id="photo-help">Optional. JPG or PNG, up to 2 MB. Used on your player record only.</p>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>Contact</legend>
<p class="form-section-note">The federation sends your registration status to this email address.</p>
<div class="form-grid">
<div class="form-field">
<label class="form-label" for="email">Email <span class="required" aria-hidden="true">*</span></label>
<input @error('email') aria-describedby="email-error" aria-invalid="true" @enderror autocomplete="email" maxlength="255" @class(['form-control-jfi', 'is-invalid' => $errors->has('email')]) id="email" name="email" required type="email" value="{{ old('email') }}"/>
<x-form-error field="email" id="email"/>
</div>
<div class="form-field">
<label class="form-label" for="phone">Mobile number <span class="required" aria-hidden="true">*</span></label>
<input aria-describedby="phone-help @error('phone') phone-error @enderror" @error('phone') aria-invalid="true" @enderror autocomplete="tel-national" inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}" @class(['form-control-jfi', 'is-invalid' => $errors->has('phone')]) id="phone" name="phone" required type="tel" value="{{ old('phone') }}"/>
<x-form-error field="phone" id="phone"/>
<p class="form-help" id="phone-help">10-digit mobile number, without +91 or 0.</p>
</div>
<div class="form-field span-2">
<label class="form-label" for="address">Address</label>
<textarea @error('address') aria-describedby="address-error" aria-invalid="true" @enderror autocomplete="street-address" @class(['form-control-jfi', 'is-invalid' => $errors->has('address')]) id="address" maxlength="1000" name="address" rows="3">{{ old('address') }}</textarea>
<x-form-error field="address" id="address"/>
</div>
<div class="form-field">
<label class="form-label" for="city">City</label>
<input @error('city') aria-describedby="city-error" aria-invalid="true" @enderror autocomplete="address-level2" maxlength="255" @class(['form-control-jfi', 'is-invalid' => $errors->has('city')]) id="city" name="city" type="text" value="{{ old('city') }}"/>
<x-form-error field="city" id="city"/>
</div>
<div class="form-field">
<label class="form-label" for="state">State or union territory</label>
<select @error('state') aria-describedby="state-error" aria-invalid="true" @enderror autocomplete="address-level1" @class(['form-control-jfi', 'is-invalid' => $errors->has('state')]) id="state" name="state">
<option value="">Select a state</option>
@foreach (config('jumpball.states') as $state)
<option @selected(old('state') === $state) value="{{ $state }}">{{ $state }}</option>
@endforeach
</select>
<x-form-error field="state" id="state"/>
</div>
<div class="form-field">
<label class="form-label" for="pincode">PIN code</label>
<input @error('pincode') aria-describedby="pincode-error" aria-invalid="true" @enderror autocomplete="postal-code" inputmode="numeric" maxlength="6" pattern="[1-9][0-9]{5}" @class(['form-control-jfi', 'is-invalid' => $errors->has('pincode')]) id="pincode" name="pincode" type="text" value="{{ old('pincode') }}"/>
<x-form-error field="pincode" id="pincode"/>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>State Association</legend>
<p class="form-section-note">Choose the recognized association you play under.</p>
<div class="form-grid">
<div class="form-field span-2">
<label class="form-label" for="state_association_id">State association <span class="required" aria-hidden="true">*</span></label>
<select @error('state_association_id') aria-describedby="state_association_id-error" aria-invalid="true" @enderror @class(['form-control-jfi', 'is-invalid' => $errors->has('state_association_id')]) id="state_association_id" name="state_association_id" required>
<option value="">Select your association</option>
@foreach ($associations as $association)
<option @selected((string) old('state_association_id') === (string) $association->id) value="{{ $association->id }}">{{ $association->name }} ({{ $association->state }})</option>
@endforeach
</select>
<x-form-error field="state_association_id" id="state_association_id"/>
</div>
</div>
</fieldset>

<fieldset class="form-section">
<legend>Documents</legend>
<p class="form-section-note" id="documents-help">PDF, JPG or PNG, up to 2 MB each. Stored privately and seen only by the federation office.</p>
<div class="form-grid">
@foreach (config('jumpball.player_document_types') as $key => $label)
<div class="form-field">
<label class="form-label" for="document-{{ $key }}">{{ $label }} <span class="required" aria-hidden="true">*</span></label>
<input accept=".pdf,image/png,image/jpeg" aria-describedby="documents-help @error('documents.'.$key) document-{{ $key }}-error @enderror" @error('documents.'.$key) aria-invalid="true" @enderror @class(['form-control-jfi', 'is-invalid' => $errors->has('documents.'.$key)]) id="document-{{ $key }}" name="documents[{{ $key }}]" required type="file"/>
<x-form-error :field="'documents.'.$key" :id="'document-'.$key"/>
</div>
@endforeach
</div>
</fieldset>

<fieldset class="form-section">
<legend>Account</legend>
<p class="form-section-note">You will sign in with your email or Player ID and this password to see your details and certificates.</p>
<div class="form-grid">
<div class="form-field">
<label class="form-label" for="password">Password <span class="required" aria-hidden="true">*</span></label>
<div class="password-field">
<input aria-describedby="password-help @error('password') password-error @enderror" @error('password') aria-invalid="true" @enderror autocomplete="new-password" @class(['form-control-jfi', 'is-invalid' => $errors->has('password')]) id="password" minlength="8" name="password" required type="password"/>
<button aria-controls="password" aria-label="Show password" class="password-toggle" data-password-toggle type="button"><i aria-hidden="true" class="fa-regular fa-eye"></i></button>
</div>
<x-form-error field="password" id="password"/>
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
<input @error('terms') aria-describedby="terms-error" aria-invalid="true" @enderror @checked(old('terms')) id="terms" name="terms" required type="checkbox" value="1"/>
<span>I confirm that the information provided is accurate and I agree to the <a href="{{ route('frontend.legal.terms') }}">Terms &amp; Conditions</a> and <a href="{{ route('frontend.legal.privacy') }}">Privacy Policy</a>. <span class="required" aria-hidden="true">*</span></span>
</label>
<x-form-error field="terms" id="terms"/>
</fieldset>

<div class="form-actions">
<button class="jfi-btn jfi-btn-gold" type="submit">Submit Registration <i aria-hidden="true" class="fa-solid fa-arrow-right"></i></button>
<p class="text-slate">Already registered? <a href="{{ route('frontend.players.login') }}">Sign in</a></p>
</div>
</form>
</div>
@endif

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
<script src="@versionedAsset('assets/js/jfi-forms.js')"></script>
@endpush
