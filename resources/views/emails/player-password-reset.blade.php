<x-mail::message>
# Reset your password

Dear {{ $player->name }},

We received a request to reset the password for your player account (Player ID **{{ $player->registration_no }}**).

<x-mail::button :url="$resetUrl">
Choose a new password
</x-mail::button>

This link works for {{ $expiresInMinutes }} minutes. If you did not ask to reset your password, you can ignore this email; your password stays the same.

Regards,<br>
Jumpball Federation of India
</x-mail::message>
