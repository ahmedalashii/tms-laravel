<x-mail::message>
# Hello {{ $manager->displayName }},
You have been activated to manage the system. Please click the button below to
login.<br>
<x-mail::button :url="route('manager.login')" color="success">
Login Now
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
