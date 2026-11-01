@extends('layouts.frontend')

@php
    $preview = isset($players, $associations) ? null : require resource_path('views/frontend/_preview-data.php');
    $players ??= $preview['players'];
    $associations ??= $preview['associations'];
@endphp

@section('title', 'Player Database')
@section('meta_description', 'Search registered Jumpball players by name or Player ID. Only approved players are listed.')

@section('content')
<x-page-banner :crumbs="['Players' => route('frontend.players.index')]" subtitle="Search approved players by name or Player ID. Only the name, Player ID and state association are published." title="Player Database"/>

<section class="page-section">
<div class="hero-container">
<form action="{{ route('frontend.players.index') }}" class="search-bar" method="get" role="search">
<div class="form-field">
<label class="form-label" for="player-search">Name or Player ID</label>
<input class="form-control-jfi" id="player-search" name="q" placeholder="e.g. JFI-2026-00001" type="search" value="{{ request('q') }}"/>
</div>
<div class="form-field">
<label class="form-label" for="player-association">State association</label>
<select class="form-control-jfi" id="player-association" name="association">
<option value="">All associations</option>
@foreach ($associations as $association)
<option @selected(request()->filled('association') && (string) request('association') === (string) $association->id) value="{{ $association->id }}">{{ $association->name }}</option>
@endforeach
</select>
</div>
<button class="jfi-btn jfi-btn-primary" type="submit"><i aria-hidden="true" class="fa-solid fa-magnifying-glass"></i> Search</button>
</form>

@if ($players->isEmpty())
<x-empty-state icon="fa-solid fa-user-group" title="No players found">
Check the spelling or the Player ID format, for example JFI-2026-00001.
</x-empty-state>
@else
<p class="text-slate mb-3" role="status">Showing {{ $players->count() }} {{ Str::plural('player', $players->count()) }}</p>
<div class="table-scroll">
<table class="jfi-table">
<caption class="visually-hidden">Approved players</caption>
<thead>
<tr>
<th scope="col">Player ID</th>
<th scope="col">Name</th>
<th scope="col">State association</th>
</tr>
</thead>
<tbody>
@foreach ($players as $player)
<tr>
<td><span class="player-id">{{ $player->registration_no }}</span></td>
<td>{{ $player->name }}</td>
<td>{{ $player->stateAssociation?->name ?? 'Not affiliated' }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<nav aria-label="Player list pages">
<ul class="jfi-pagination">
<li><span aria-disabled="true">Previous</span></li>
<li><span aria-current="page">1</span></li>
<li><a href="{{ route('frontend.players.index', ['page' => 2]) }}">2</a></li>
<li><a href="{{ route('frontend.players.index', ['page' => 2]) }}">Next</a></li>
</ul>
</nav>
@endif

<div class="row g-4 mt-4">
<div class="col-lg-6">
<div class="info-note h-100">
<i aria-hidden="true" class="fa-solid fa-shield-halved"></i>
<p>Personal details such as date of birth, phone, email and address are never shown publicly.</p>
</div>
</div>
<div class="col-lg-6">
<div class="info-note h-100">
<i aria-hidden="true" class="fa-solid fa-id-card"></i>
<p>Not registered yet? <a href="{{ route('frontend.players.register') }}">Register as a player</a> to receive your Player ID.</p>
</div>
</div>
</div>
</div>
</section>
@endsection
