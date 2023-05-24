<x-mail::message>
# Hello Trainee {{ $trainee->displayName }} 🙏🏼,
You sent a request to enroll in the {{ $trainingProgram->name }} training program. Your request is getting processed and you will be notified once it is approved/rejected.<br>
Please keep patience and wait for the approval.<br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
