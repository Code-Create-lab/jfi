@props(['results', 'caption'])

<div {{ $attributes->class('table-scroll') }}>
<table class="jfi-table">
<caption class="visually-hidden">{{ $caption }}</caption>
<thead>
<tr>
<th scope="col">Position</th>
<th scope="col">Team / Player</th>
<th scope="col">State association</th>
<th scope="col">Score</th>
</tr>
</thead>
<tbody>
@foreach ($results->sortBy('position') as $result)
<tr>
<td>
<span @class(['position-badge', 'position-'.$result->position => $result->position <= 3])>{{ $result->position }}</span>
<span class="position-label">{{ match ($result->position) { 1 => 'Winner', 2 => 'Runner-up', 3 => 'Third place', default => 'Standings' } }}</span>
</td>
<td><strong>{{ $result->participant_name }}</strong></td>
<td>{{ $result->stateAssociation?->name ?? '-' }}</td>
<td class="tabular">{{ $result->score ?? '-' }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
