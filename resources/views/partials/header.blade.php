<header>
<div class="navbar-container">
<div class="hero-container">
<nav aria-label="Primary" class="navbar navbar-expand-xl">
<div class="navbar-nav-container">
<div class="logo-container">
<a class="navbar-brand" href="{{ route('frontend.home') }}">
<img alt="Jumpball Federation of India - home" class="img-fluid" height="68" src="{{ asset('assets/images/jfi-logo.png') }}" width="91"/>
</a>
</div>
<div class="nav-link-container">
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav mx-auto">
@foreach (config('jumpball.navigation') as $item)
@php($isActive = request()->routeIs(...$item['active']))
@if (isset($item['children']))
<li class="nav-item dropdown">
<a aria-expanded="false" @class(['nav-link dropdown-toggle', 'active' => $isActive]) data-bs-toggle="dropdown" href="#" role="button">
{{ $item['label'] }} <i aria-hidden="true" class="fa-solid fa-chevron-down"></i>
</a>
<ul class="dropdown-menu">
@foreach ($item['children'] as $child)
<li><a @if (request()->routeIs($child['route'])) aria-current="page" @endif @class(['dropdown-item', 'active' => request()->routeIs($child['route'])]) href="{{ route($child['route']) }}">{{ $child['label'] }}</a></li>
@endforeach
</ul>
</li>
@else
<li class="nav-item">
<a @if ($isActive) aria-current="page" @endif @class(['nav-link', 'active' => $isActive]) href="{{ route($item['route']) }}">{{ $item['label'] }}</a>
</li>
@endif
@endforeach
</ul>
</div>
</div>
<button aria-controls="navbarNav" aria-expanded="false" aria-label="Open menu" class="nav-btn" data-bs-target="#navbarNav" data-bs-toggle="collapse" type="button">
<i aria-hidden="true" class="fa-solid fa-bars"></i>
</button>
<div class="navbar-cta-container">
<a class="btn btn-accent" href="{{ route('frontend.players.register') }}">
<span class="btn-title">Register</span>
<span aria-hidden="true" class="icon-circle">
<i class="fa-solid fa-arrow-right"></i>
</span>
</a>
</div>
</div>
</nav>
</div>
</div>
</header>
