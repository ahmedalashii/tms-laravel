<x-mail::message>
# Hello Trainee {{ $trainee->displayName }},
I'm your advisor {{ $advisor->displayName }}.<br> I want to tell you that: <br>
{{ $message }}.<br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
