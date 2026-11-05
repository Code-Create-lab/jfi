@extends('layouts.frontend')

@section('title', 'Player Login')
@section('meta_description', 'Sign in to view your Jumpball Federation of India registration, Player ID and certificates.')

@section('content')
<x-page-banner :crumbs="['Players' => route('frontend.players.index')]" subtitle="Sign in to see your registration details, Player ID and certificates." title="Player Login"/>

<section class="page-section">
<div class="hero-container">
<div class="row gx-4 gy-5 align-items-start">
<div class="col-lg-6">
<div class="auth-card">
<h2 class="title-plain fs-3 mb-4">Sign in to your account</h2>
<x-form-alert :success="session('status')"/>
<form action="{{ route('frontend.players.login.store') }}" class="jfi-form gap-4" method="post" novalidate>
@csrf
<div class="form-field">
<label class="form-label" for="login-id">Email or Player ID</label>
<input aria-describedby="login-id-help @error('login') login-id-error @enderror" @error('login') aria-invalid="true" @enderror autocapitalize="none" autocomplete="username" @class(['form-control-jfi', 'is-invalid' => $errors->has('login')]) id="login-id" name="login" required spellcheck="false" type="text" value="{{ old('login') }}"/>
<p class="form-help" id="login-id-help">The email address you registered with, or your Player ID (for example JFI-2026-00001).</p>
<x-form-error field="login" id="login-id"/>
</div>
<div class="form-field">
<label class="form-label" for="login-password">Password</label>
<div class="password-field">
<input @error('password') aria-describedby="login-password-error" aria-invalid="true" @enderror autocomplete="current-password" @class(['form-control-jfi', 'is-invalid' => $errors->has('password')]) id="login-password" name="password" required type="password"/>
<button aria-controls="login-password" aria-label="Show password" class="password-toggle" data-password-toggle type="button"><i aria-hidden="true" class="fa-regular fa-eye"></i></button>
</div>
<x-form-error field="password" id="login-password"/>
</div>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
<label class="choice">
<input @checked(old('remember')) name="remember" type="checkbox" value="1"/> Keep me signed in on this device
</label>
<a class="form-help" href="{{ route('player.password.request') }}">Forgotten your password?</a>
</div>
<button class="jfi-btn jfi-btn-primary jfi-btn-block" data-busy-label="Signing in..." type="submit">Sign In</button>
</form>
</div>
</div>
<div class="col-lg-6">
<div class="side-card">
<h2 class="side-card-title">After You Sign In</h2>
<ul class="meta-list">
<li><i aria-hidden="true" class="fa-solid fa-id-card"></i><span>View your registration details and approval status</span></li>
<li><i aria-hidden="true" class="fa-solid fa-hashtag"></i><span>See your official Player ID</span></li>
<li><i aria-hidden="true" class="fa-solid fa-file-arrow-down"></i><span>Download your championship certificates</span></li>
</ul>
</div>
<div class="side-card">
<h2 class="side-card-title">New Player?</h2>
<p class="mb-3">Register once to receive your Player ID and take part in sanctioned events.</p>
<a class="jfi-btn jfi-btn-gold jfi-btn-block" href="{{ route('frontend.players.register') }}">Register as a Player</a>
</div>
</div>
</div>
</div>
</section>
@endsection

@push('scripts')
<script src="@versionedAsset('assets/js/jfi-forms.js')"></script>
@endpush
