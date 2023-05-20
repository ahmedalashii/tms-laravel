<x-mail::message>
# Hello {{ $user->displayName }},
We received a request to reset your password for {{ config('app.name') }}.<br>
If you did not request this, please disregard this email.<br>
To reset your password, please click the button below:<br>
<x-mail::button :url="$resetting_url" color="success">
Reset Password
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
