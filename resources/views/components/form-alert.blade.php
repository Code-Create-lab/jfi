@props([
    'success' => null,
    'hasFiles' => false,
])

@if ($errors->any())
<div class="form-alert form-alert-error" role="alert">
<i aria-hidden="true" class="fa-solid fa-circle-exclamation"></i>
<div>
@if ($errors->has('website'))
<strong>{{ $errors->first('website') }}</strong>
@else
<strong>Please correct the highlighted {{ Str::plural('field', $errors->count()) }} and submit again.</strong>
@if ($hasFiles)
<p>For your security, selected files are not kept after an error. Please choose them again.</p>
@endif
@endif
</div>
</div>
@elseif ($success)
<div class="form-alert form-alert-success" role="status">
<i aria-hidden="true" class="fa-solid fa-circle-check"></i>
<div><strong>{{ $success }}</strong></div>
</div>
@endif
