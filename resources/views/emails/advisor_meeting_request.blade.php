<x-mail::message>
# Hello Advisor {{ $advisor->displayName }},
You have received a meeting request from {{ $trainee->displayName }}.<br> The meeting is scheduled for {{ $meeting->date }} at {{ $meeting->time }}.<br>
To accept or reject the meeting, please login to your account.<br>
<x-mail::button :url="route('advisor.login')" color="success">
Login Now
</x-mail::button>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
