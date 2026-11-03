@php($isPlayer = $registrant instanceof App\Models\Player)
<x-mail::message>
# Registration received

Dear {{ $registrant->name }},

@if ($isPlayer)
Thank you for registering with the Jumpball Federation of India.

**Player ID:** {{ $registrant->registration_no }}

Please keep your Player ID for all communication with the federation and your state association. Your registration will be reviewed by the federation office, and you will receive an email once it has been approved or if anything else is needed.
@else
Thank you for applying for recognition of **{{ $registrant->name }}** by the Jumpball Federation of India.

The federation office will review your application and documents. You will receive an email once a decision has been made.
@endif

If any of the details you submitted are incorrect, please contact the federation office.

Regards,<br>
Jumpball Federation of India
</x-mail::message>
