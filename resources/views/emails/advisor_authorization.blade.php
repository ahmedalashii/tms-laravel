<x-mail::message>
# Hello Advisor {{ $advisor->displayName }},
You have been authorized by {{ $manager->displayName }} to access the system. Please click the button below to
login.<br>
Your ID is: {{ $advisor->auth_id }}<br>
Please keep this ID safe as you will need it to login.<br>
<x-mail::button :url="route('advisor.login')" color="success">
Login Now
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
