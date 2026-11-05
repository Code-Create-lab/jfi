<aside aria-label="Mobile menu">
<div>
<div class="sidebar-overlay"></div>
<div class="sidebar">
<div class="sidebar-header">
<div class="logo">
<img alt="Jumpball Federation of India" class="logo" src="{{ asset('assets/images/jfi-logo.png') }}"/>
</div>
<button aria-label="Close menu" class="close-btn" type="button"><i aria-hidden="true" class="fa-solid fa-xmark"></i></button>
</div>
<ul class="menu">
@foreach ($navigation as $item)
@if (isset($item['children']))
<li class="sidebar-dropdown">
<div class="dropdown-header">
<a href="#">{{ $item['label'] }}</a>
<button aria-label="Show {{ $item['label'] }} links" class="sidebar-dropdown-btn" type="button"><i aria-hidden="true" class="fa-solid fa-angle-down"></i></button>
</div>
<ul class="sidebar-dropdown-menu">
@foreach ($item['children'] as $child)
@if (isset($child['logout']))
<li><form action="{{ route('player.logout') }}" method="post">@csrf<button class="sidebar-logout" type="submit">{{ $child['label'] }}</button></form></li>
@else
<li><a href="{{ route($child['route']) }}">{{ $child['label'] }}</a></li>
@endif
@endforeach
</ul>
</li>
@else
<li @class(['below-dropdown' => $loop->last])><a href="{{ route($item['route']) }}">{{ $item['label'] }}</a></li>
@endif
@endforeach
<li class="below-dropdown"><a href="{{ $signedInPlayer ? route('player.dashboard') : route('frontend.players.register') }}">{{ $signedInPlayer ? 'My Account' : 'Register as a Player' }}</a></li>
</ul>
</div>
</div>
</aside>
