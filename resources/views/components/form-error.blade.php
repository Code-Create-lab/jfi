@props([
    'field',
    'id',
])

@error($field)
<p {{ $attributes->class('form-error') }} id="{{ $id }}-error"><i aria-hidden="true" class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
@enderror
