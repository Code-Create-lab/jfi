@extends('layouts.frontend')

@section('title', 'Certificates & Verification')
@section('meta_description', 'Download your Jumpball Federation of India certificate with your Player ID and date of birth, or verify a certificate by scanning its QR code.')

@section('content')
<x-page-banner :crumbs="['Players' => route('frontend.players.index')]" subtitle="Find and download your championship certificates, or verify one issued by the federation." title="Certificates & Verification"/>

<section class="page-section">
<div class="hero-container">
@if ($lookupPlayer)
<section aria-labelledby="lookup-results-title" class="lookup-results mb-5">
<div class="lookup-results-head">
<h2 class="title-plain fs-3 mb-1" id="lookup-results-title">Certificates for {{ $lookupPlayer->name }}</h2>
<p class="mb-0">Player ID <span class="player-id">{{ $lookupPlayer->registration_no }}</span></p>
</div>
@if ($lookupPlayer->certificates->isNotEmpty())
<ul class="download-list">
@foreach ($lookupPlayer->certificates as $certificate)
<li class="download-item">
<span aria-hidden="true" class="file-icon">PDF</span>
<div>
<h3 class="download-title">{{ $certificate->title }}</h3>
@if ($certificate->achievement || $certificate->event)
<p>{{ collect([$certificate->achievement, $certificate->event?->title])->filter()->join(', ') }}</p>
@endif
<div class="meta-inline">
<span>Certificate No. <span class="player-id">{{ $certificate->certificate_no }}</span></span>
<span>Issued <time datetime="{{ $certificate->issued_on->toDateString() }}">{{ $certificate->issued_on->format('j M Y') }}</time></span>
</div>
</div>
<a class="jfi-btn jfi-btn-primary" href="{{ $downloadLinks[$certificate->id] }}"><i aria-hidden="true" class="fa-solid fa-download"></i> Download PDF<span class="visually-hidden"> {{ $certificate->title }}</span></a>
</li>
@endforeach
</ul>
<p class="form-help mt-3 mb-0">For your security these download links work for 30 minutes. Search again to get new links.</p>
@else
<x-empty-state icon="fa-regular fa-file-lines" title="No certificates yet">
No certificates have been issued to this Player ID yet. They appear here once the federation issues them.
</x-empty-state>
@endif
</section>
@endif
<div class="row gx-4 gy-5">
<div class="col-lg-6">
<div class="auth-card h-100">
<h2 class="title-plain fs-3 mb-2">Find My Certificate</h2>
<p class="mb-4">Enter your Player ID and date of birth. Both must match our records.</p>
@if (session('lookup_failed'))
<div class="form-alert form-alert-error" role="alert">
<i aria-hidden="true" class="fa-solid fa-circle-exclamation"></i>
<div><strong>We could not find certificates for this Player ID and date of birth.</strong><p>Check both and try again. Only approved registrations have certificates.</p></div>
</div>
@endif
<x-form-alert/>
<form action="{{ route('frontend.certificates.lookup') }}" class="jfi-form gap-4" method="post" novalidate>
@csrf
<x-honeypot/>
<div class="form-field">
<label class="form-label" for="lookup-player-id">Player ID</label>
<input aria-describedby="lookup-player-id-help @error('player_id') lookup-player-id-error @enderror" @error('player_id') aria-invalid="true" @enderror autocapitalize="characters" @class(['form-control-jfi', 'is-invalid' => $errors->has('player_id')]) id="lookup-player-id" name="player_id" pattern="[A-Za-z]+-[0-9]{4}-[0-9]+" placeholder="JFI-2026-00001" required type="text" value="{{ old('player_id') }}"/>
<p class="form-help" id="lookup-player-id-help">Printed on your registration confirmation, for example JFI-2026-00001.</p>
<x-form-error field="player_id" id="lookup-player-id"/>
</div>
<div class="form-field">
<label class="form-label" for="lookup-dob">Date of birth</label>
<input @error('date_of_birth') aria-describedby="lookup-dob-error" aria-invalid="true" @enderror autocomplete="bday" @class(['form-control-jfi', 'is-invalid' => $errors->has('date_of_birth')]) id="lookup-dob" max="{{ today()->toDateString() }}" name="date_of_birth" required type="date"/>
<x-form-error field="date_of_birth" id="lookup-dob"/>
</div>
<button class="jfi-btn jfi-btn-primary jfi-btn-block" type="submit"><i aria-hidden="true" class="fa-solid fa-magnifying-glass"></i> Find Certificates</button>
</form>
<p class="form-help mt-4 mb-0">Registered players can also download certificates after <a href="{{ route('frontend.players.login') }}">signing in</a>.</p>
</div>
</div>
<div class="col-lg-6">
<figure class="certificate-preview m-0">
<img alt="Sample JFI certificate showing the player's name, Player ID, achievement, signatures and a QR code" height="1131" loading="lazy" src="{{ asset('assets/images/jfi/certificate-sample.webp') }}" width="1600"/>
</figure>
<p class="form-help mt-3">Sample certificate. Every certificate carries a certificate number and a QR code.</p>
</div>
</div>
</div>
</section>

<div class="section-wrapper py-0">
<section aria-labelledby="how-verification-works" class="page-band">
<div class="hero-container">
<div class="row gx-4 gy-5 align-items-start">
<div class="col-lg-5">
<x-section-heading label="QR Verification" lede="Anyone can check that a certificate is genuine. The QR code links to a verification page on this website, so there is nothing to install." title="How Verification Works" id="how-verification-works"/>
</div>
<div class="col-lg-7">
<ol class="steps">
<li><div><h3>Scan the QR code</h3><p>Use any phone camera to scan the code printed on the certificate.</p></div></li>
<li><div><h3>Open the verification page</h3><p>The link opens a page on this website showing the certificate details held by the federation.</p></div></li>
<li><div><h3>Compare the details</h3><p>Check that the name, Player ID, achievement and event match the printed certificate.</p></div></li>
</ol>
<div class="info-note mt-4">
<i aria-hidden="true" class="fa-solid fa-circle-info"></i>
<p>If the page says the certificate was not found, or the details do not match, <a href="{{ route('frontend.contact') }}">contact the federation office</a>.</p>
</div>
</div>
</div>
</div>
</section>
</div>
@endsection
