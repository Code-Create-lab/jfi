@extends('layouts.frontend')

@section('title', 'Forgotten Password')
@section('meta_description', 'Reset the password for your Jumpball Federation of India player account.')

@section('content')
<x-page-banner :crumbs="['Player Login' => route('frontend.players.login')]" subtitle="We will email you a link to choose a new password." title="Forgotten Password"/>

<section class="page-section">
<div class="hero-container">
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="auth-card">
<h2 class="title-plain fs-3 mb-2">Reset your password</h2>
<p class="mb-4">Enter the email address you registered with. The link we send works for {{ config('auth.passwords.players.expire') }} minutes.</p>
<x-form-alert :success="session('status')"/>
<form action="{{ route('player.password.email') }}" class="jfi-form gap-4" method="post" novalidate>
@csrf
<div class="form-field">
<label class="form-label" for="forgot-email">Email</label>
<input @error('email') aria-describedby="forgot-email-error" aria-invalid="true" @enderror autocomplete="email" @class(['form-control-jfi', 'is-invalid' => $errors->has('email')]) id="forgot-email" name="email" required type="email" value="{{ old('email') }}"/>
<x-form-error field="email" id="forgot-email"/>
</div>
<button class="jfi-btn jfi-btn-primary jfi-btn-block" data-busy-label="Sending..." type="submit">Email Me a Reset Link</button>
</form>
<p class="form-help mt-4 mb-0">Remembered it? <a href="{{ route('frontend.players.login') }}">Back to sign in</a>. No longer have access to your email? Contact the <a href="{{ route('frontend.contact') }}">federation office</a>.</p>
</div>
</div>
</div>
</div>
</section>
@endsection

@push('scripts')
<script src="@versionedAsset('assets/js/jfi-forms.js')"></script>
@endpush
