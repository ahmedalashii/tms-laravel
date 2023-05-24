<x-mail::message>
# Hello Trainee {{ $trainee->displayName }} 🙏🏼,
We're Sorry!!, Your request to enroll in the {{ $trainingProgram->name }} training program has been rejected by the manager {{ $manager->displayName }}.<br>
You can try to enroll in another training program.<br>
All the best for your future. Please take care of your education.<br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
