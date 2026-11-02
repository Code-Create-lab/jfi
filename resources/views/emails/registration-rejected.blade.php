@php($isPlayer = $registrant instanceof App\Models\Player)
<x-mail::message>
# Registration not approved

Dear {{ $registrant->name }},

@if ($isPlayer)
We have reviewed your player registration{{ $registrant->registration_no ? ' ('.$registrant->registration_no.')' : '' }} with the Jumpball Federation of India and are unable to approve it at this time.
@else
We have reviewed the application from **{{ $registrant->name }}** and are unable to approve it at this time.
@endif

**Reason:** {{ $registrant->admin_remarks }}

If you have questions or can provide the missing information, please contact the federation office.

Regards,<br>
Jumpball Federation of India
</x-mail::message>
