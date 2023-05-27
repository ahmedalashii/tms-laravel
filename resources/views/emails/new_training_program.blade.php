<x-mail::message>
# Hello Trainee {{ $trainee->displayName }},
We're notifying you that there is a new training program available for you to complete. Please click the button below to login.<br>
<x-mail::button :url="route('advisor.login')" color="success">
Login Now
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
