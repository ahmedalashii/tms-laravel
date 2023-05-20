<x-mail::message>
# Hello {{ $user->displayName }},
We just need to verify your email address before you can access {{ config('app.name') }}.<br>
To verify your email address, please click the button below:<br>
<x-mail::button :url="$verification_url" color="success">
Verify Email Address
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
