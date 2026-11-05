@extends('layouts.frontend')

@section('title', 'My Account')
@section('meta_description', 'Your Jumpball Federation of India registration, Player ID and certificates.')

@section('content')
<x-page-banner :crumbs="['Players' => route('frontend.players.index')]" :subtitle="'Welcome, '.$player->name.'.'" title="My Account"/>

<section class="page-section">
<div class="hero-container">
<x-form-alert :success="session('status')"/>
<div class="row gx-4 gy-5">
<div class="col-lg-8">
<article class="verify-card mb-5">
<div @class(['verify-status', 'verify-status-valid' => $player->status === App\Enums\RegistrationStatus::Approved, 'verify-status-invalid' => $player->status === App\Enums\RegistrationStatus::Rejected])>
<div>
<h2>Registration {{ Str::lower($player->status->label()) }}</h2>
@if ($player->status === App\Enums\RegistrationStatus::Approved)
<p>Your registration is approved.</p>
@elseif ($player->status === App\Enums\RegistrationStatus::Rejected)
<p>Your registration was not approved.@if ($player->admin_remarks) Reason: {{ $player->admin_remarks }}@endif</p>
@else
<p>The federation office is reviewing your registration. You will receive an email once it is approved.</p>
@endif
</div>
</div>
<dl class="verify-details">
<dt>Player ID</dt><dd class="player-id">{{ $player->registration_no }}</dd>
<dt>Name</dt><dd>{{ $player->name }}</dd>
@if ($player->father_name)<dt>Father / guardian</dt><dd>{{ $player->father_name }}</dd>@endif
<dt>Date of birth</dt><dd>{{ $player->date_of_birth?->format('j F Y') }}</dd>
@if ($player->gender)<dt>Gender</dt><dd>{{ $player->gender->label() }}</dd>@endif
<dt>Email</dt><dd>{{ $player->email }}</dd>
<dt>Phone</dt><dd>{{ $player->phone }}</dd>
<dt>Address</dt><dd>{{ collect([$player->address, $player->city, $player->state, $player->pincode])->filter()->join(', ') }}</dd>
<dt>State association</dt><dd>{{ $player->stateAssociation?->name ?? 'Not linked' }}</dd>
</dl>
</article>

<h2 class="title-plain fs-3 mb-3">My Certificates</h2>
@if ($player->status !== App\Enums\RegistrationStatus::Approved)
<p>Certificates are available once your registration is approved.</p>
@elseif ($player->certificates->isEmpty())
<x-empty-state icon="fa-regular fa-file-lines" title="No certificates yet">They appear here once the federation issues them.</x-empty-state>
@else
<ul class="download-list">
@foreach ($player->certificates as $certificate)
<li class="download-item certificate-item">
<span aria-hidden="true" class="file-icon"><i class="fa-solid fa-award"></i></span>
<div>
<h3 class="download-title">{{ $certificate->title }}</h3>
<div class="meta-inline"><span>Certificate No. <span class="player-id">{{ $certificate->certificate_no }}</span></span><span>Issued {{ $certificate->issued_on->format('j M Y') }}</span></div>
</div>
<div class="download-actions">
<a class="jfi-btn jfi-btn-outline" href="{{ route('frontend.certificates.verify', $certificate->verification_code) }}" rel="noopener" target="_blank">Verify</a>
<a class="jfi-btn jfi-btn-primary" href="{{ route('player.certificates.download', $certificate) }}">Download PDF</a>
</div>
</li>
@endforeach
</ul>
@endif
</div>
<div class="col-lg-4">
<div class="side-card">
@if ($player->photo)
<img alt="{{ $player->name }}" class="img-fluid mb-3" src="{{ route('player.photo') }}"/>
@endif
<p class="mb-3">To change your details, contact the <a href="{{ route('frontend.contact') }}">federation office</a>.</p>
<form action="{{ route('player.logout') }}" method="post">
@csrf
<button class="jfi-btn jfi-btn-outline jfi-btn-block" type="submit">Log out</button>
</form>
</div>
</div>
</div>
</div>
</section>
@endsection
