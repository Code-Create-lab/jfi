@php($isPlayer = $registrant instanceof App\Models\Player)
<x-mail::message>
# Registration approved

Dear {{ $registrant->name }},

@if ($isPlayer)
Your player registration with the Jumpball Federation of India has been approved.

**Player ID:** {{ $registrant->registration_no }}

Use your Player ID in all communication with the federation and your state association. You can sign in to view your details and certificates.

<x-mail::button :url="route('frontend.players.login')">
Player Login
</x-mail::button>
@else
The application from **{{ $registrant->name }}** has been approved. The association is now listed as a recognized state association of the Jumpball Federation of India.
@endif

@if ($registrant->admin_remarks)
**Note from the federation office:** {{ $registrant->admin_remarks }}
@endif

Regards,<br>
Jumpball Federation of India
</x-mail::message>
