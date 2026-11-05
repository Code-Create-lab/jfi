@extends('layouts.frontend')

@section('title', 'Choose a New Password')
@section('meta_description', 'Choose a new password for your Jumpball Federation of India player account.')

@push('styles')
{{-- Reset links carry a one-time token; keep them out of search results. --}}
<meta content="noindex" name="robots"/>
@endpush

@section('content')
<x-page-banner :crumbs="['Player Login' => route('frontend.players.login')]" subtitle="Choose a new password for your player account." title="Choose a New Password"/>

<section class="page-section">
<div class="hero-container">
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="auth-card">
<h2 class="title-plain fs-3 mb-4">New password</h2>
<x-form-alert/>
<form action="{{ route('player.password.update') }}" class="jfi-form gap-4" method="post" novalidate>
@csrf
<input name="token" type="hidden" value="{{ $token }}"/>
<div class="form-field">
<label class="form-label" for="reset-email">Email</label>
<input @error('email') aria-describedby="reset-email-error" aria-invalid="true" @enderror autocomplete="email" @class(['form-control-jfi', 'is-invalid' => $errors->has('email')]) id="reset-email" name="email" required type="email" value="{{ old('email', $email) }}"/>
<x-form-error field="email" id="reset-email"/>
</div>
<div class="form-field">
<label class="form-label" for="reset-password">New password</label>
<div class="password-field">
<input aria-describedby="reset-password-help @error('password') reset-password-error @enderror" @error('password') aria-invalid="true" @enderror autocomplete="new-password" @class(['form-control-jfi', 'is-invalid' => $errors->has('password')]) id="reset-password" minlength="8" name="password" required type="password"/>
<button aria-controls="reset-password" aria-label="Show password" class="password-toggle" data-password-toggle type="button"><i aria-hidden="true" class="fa-regular fa-eye"></i></button>
</div>
<p class="form-help" id="reset-password-help">At least 8 characters.</p>
<x-form-error field="password" id="reset-password"/>
</div>
<div class="form-field">
<label class="form-label" for="reset-password-confirmation">Confirm new password</label>
<input autocomplete="new-password" class="form-control-jfi" id="reset-password-confirmation" name="password_confirmation" required type="password"/>
</div>
<button class="jfi-btn jfi-btn-primary jfi-btn-block" data-busy-label="Saving..." type="submit">Save New Password</button>
</form>
</div>
</div>
</div>
</div>
</section>
@endsection

@push('scripts')
<script src="@versionedAsset('assets/js/jfi-forms.js')"></script>
@endpush
