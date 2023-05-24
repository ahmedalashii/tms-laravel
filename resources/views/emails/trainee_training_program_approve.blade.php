<x-mail::message>
# Hello Trainee {{ $trainee->displayName }} 🙏🏼,
Your request to enroll in the {{ $trainingProgram->name }} training program has been approved by the manager {{ $manager->displayName }}.<br>
You can now start the training program from {{ $trainingProgram->start_date }}.<br>
And you have to complete the training program by {{ $trainingProgram->end_date }}.<br>
All the best for your training program. Please take care of your education.<br>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
