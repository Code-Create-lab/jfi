{{-- JFI email layout: logo header, federation contact details from Site Settings in the footer. --}}
@php($siteName = App\Models\Setting::get('site_name', 'Jumpball Federation of India'))
<x-mail::layout>
<x-slot:header>
<x-mail::header :url="route('frontend.home')">
{{ $siteName }}
</x-mail::header>
</x-slot:header>

{!! $slot !!}

@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

<x-slot:footer>
<x-mail::footer>
**{{ $siteName }}**<br>
{{ collect([App\Models\Setting::get('contact_address'), App\Models\Setting::get('contact_phone'), App\Models\Setting::get('contact_email')])->filter()->join(' · ') }}<br>
© {{ date('Y') }} {{ $siteName }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
