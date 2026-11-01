@props([
    'title',
    'icon' => 'fa-regular fa-folder-open',
])

<div {{ $attributes->class('empty-state') }}>
<i aria-hidden="true" class="{{ $icon }}"></i>
<h3>{{ $title }}</h3>
<p>{{ $slot }}</p>
@isset($action)
<div>{{ $action }}</div>
@endisset
</div>
