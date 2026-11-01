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
@foreach (config('jumpball.navigation') as $item)
@if (isset($item['children']))
<li class="sidebar-dropdown">
<div class="dropdown-header">
<a href="#">{{ $item['label'] }}</a>
<button aria-label="Show {{ $item['label'] }} links" class="sidebar-dropdown-btn" type="button"><i aria-hidden="true" class="fa-solid fa-angle-down"></i></button>
</div>
<ul class="sidebar-dropdown-menu">
@foreach ($item['children'] as $child)
<li><a href="{{ route($child['route']) }}">{{ $child['label'] }}</a></li>
@endforeach
</ul>
</li>
@else
<li @class(['below-dropdown' => $loop->last])><a href="{{ route($item['route']) }}">{{ $item['label'] }}</a></li>
@endif
@endforeach
<li class="below-dropdown"><a href="{{ route('frontend.players.register') }}">Register as a Player</a></li>
</ul>
</div>
</div>
</aside>
