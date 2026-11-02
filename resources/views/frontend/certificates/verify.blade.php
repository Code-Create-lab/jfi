@extends('layouts.frontend')

@php
    // Preview: any code shows the sample certificate except "invalid", which shows the not-found state.
    if (! isset($certificate) && $code !== 'invalid') {
        $certificate = ((fn () => require resource_path('views/frontend/_preview-data.php'))())['certificate'];
    }
    $certificate ??= null;
@endphp

@section('title', 'Certificate Verification')
@section('meta_description', 'Verify a certificate issued by the Jumpball Federation of India.')

@section('content')
<x-page-banner :crumbs="['Certificates' => route('frontend.certificates.index')]" subtitle="Details held by the Jumpball Federation of India for this certificate." title="Certificate Verification"/>

<section class="page-section">
<div class="hero-container">
<div class="row justify-content-center">
<div class="col-lg-9 col-xl-8">
@if ($certificate)
<article class="verify-card">
<div aria-live="polite" class="verify-status verify-status-valid">
<i aria-hidden="true" class="fa-solid fa-circle-check"></i>
<div>
<h2>Verified certificate</h2>
<p>This certificate was issued by the Jumpball Federation of India and matches our records.</p>
</div>
</div>
<dl class="verify-details">
<dt>Certificate number</dt><dd class="player-id">{{ $certificate->certificate_no }}</dd>
<dt>Awarded to</dt><dd>{{ $certificate->player->name }}</dd>
<dt>Player ID</dt><dd class="player-id">{{ $certificate->player->registration_no }}</dd>
<dt>Certificate</dt><dd>{{ $certificate->title }}</dd>
@if ($certificate->achievement)
<dt>Achievement</dt><dd>{{ $certificate->achievement }}</dd>
@endif
@if ($certificate->event)
<dt>Event</dt><dd>{{ $certificate->event->title }}, {{ $certificate->event->dateRange() }}</dd>
@endif
<dt>Issued on</dt><dd>{{ $certificate->issued_on->format('j F Y') }}</dd>
</dl>
</article>
@else
<article class="verify-card">
<div aria-live="polite" class="verify-status verify-status-invalid">
<i aria-hidden="true" class="fa-solid fa-circle-xmark"></i>
<div>
<h2>Certificate not found</h2>
<p>We could not find a certificate for this verification link.</p>
</div>
</div>
<div class="p-4">
<p>Check that you scanned the full QR code. Links copied by hand can contain mistakes. If the problem continues, the certificate may not have been issued by the federation.</p>
<a class="jfi-btn jfi-btn-primary" href="{{ route('frontend.contact') }}">Contact the Federation</a>
</div>
</article>
@endif
<p class="text-slate mt-4 mb-0">Verification confirms only records held by the Jumpball Federation of India.</p>
</div>
</div>
</div>
</section>
@endsection
