<x-mail::message>
# Hello Advisor {{ $advisor->displayName }},
I'm your trainee {{ $trainee->displayName }}.<br> I want to tell you that: <br>
{{ $message }}.<br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
